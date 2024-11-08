<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    /**
     * Show the main shopping page with product listings.
     */
    public function index()
    {
        $products = Product::all();
        return view('shop.index', compact('products'));
    }

    /**
     * Display the shopping cart.
     */
    public function cart()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
        return view('shop.cart', compact('cartItems'));
    }

    // Add item to cart
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        $user = Auth::user();

        // Check if the product is already in the cart
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
        } else {
            $cartItem = $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        $cartItem->save();

        return redirect()->route('account', ['section' => 'cart'])->with('success', 'Product added to cart successfully!');
    }

    // Update cart item quantity
    public function updateCart(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem = Auth::user()->cartItems->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();
        }

        return redirect()->route('account', ['section' => 'cart'])->with('success', 'Cart updated successfully!');
    }

    // Remove item from cart
    public function removeFromCart(Product $product)
    {
        $cartItem = Auth::user()->cartItems->where('product_id', $product->id)->first();
        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('account', ['section' => 'cart'])->with('success', 'Product removed from cart successfully!');
    }

    public function processCheckout()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('account', ['section' => 'cart'])->with('error', 'Your cart is empty!');
        }

        // Generate a unique random order number
        $orderNumber = $this->generateOrderNumber();
        print($orderNumber);

        // Create an order with the unique order number
        $order = $user->orders()->create([
            'order_number' => $orderNumber,
            'status' => 'Pending',
        ]);

        // Loop through cart items, add to order summary, and update stock
        $orderItems = [];
        foreach ($cartItems as $item) {
            // Get product details
            $product = $item->product;

            $orderItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image, // Assuming 'image' is the name of the column storing the product image path
                'quantity' => $item->quantity,
                'price' => $product->price,
            ];

            // Update the stock for each product
            $product->decrement('stock', $item->quantity);
        }

        // Optionally, store the order items in the order (if needed)
        $order->items = json_encode($orderItems); // Store order items as JSON in the order's 'items' column
        $order->save();

        // Clear the cart items after checkout
        $user->cartItems()->delete();

        return redirect()->route('account', ['section' => 'order-history'])->with('success', 'Checkout successful! Your order has been placed.');
    }



    public function account(Request $request, $section)
    {
        $user = Auth::user();

        // Load data specific to the section
        switch ($section) {
            case 'order-history':
                $orders = $user->orders; // Assuming a relationship with orders in the User model
                return view('shop.account', compact('user', 'section', 'orders'));
    
            case 'cart':
                $cartItems = $user->cartItems; // Assuming a relationship with cartItems in the User model
                return view('shop.account', compact('user', 'section', 'cartItems'));
    
            default:
                // Profile section
                return view('shop.account', compact('user', 'section'));
        }
    }


    // Update the profile information
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('account', ['section' => 'profile'])->with('success', 'Profile updated successfully.');
    }

    /**
     * Generate a unique order number with uppercase letters and numbers.
     *
     * @return string
     */
    protected function generateOrderNumber()
    {
        $orderNumber = strtoupper(substr(bin2hex(random_bytes(5)), 0, 15));

        // Check if this order number already exists and regenerate if necessary
        while (\App\Models\Order::where('order_number', $orderNumber)->exists()) {
            $orderNumber = strtoupper(substr(bin2hex(random_bytes(5)), 0, 15));
        }

        return $orderNumber;
    }

    public function destroyOrder(Order $order)
    {
        // Delete the order and its related data if necessary
        $order->delete();

        return redirect()->route('account', ['section' => 'order-history'])->with('success', 'Order deleted successfully.');
    }

}
