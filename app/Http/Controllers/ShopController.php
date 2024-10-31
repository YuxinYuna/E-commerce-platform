<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        $cartItem = CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ],
            [
                'quantity' => DB::raw("quantity + $quantity")
            ]
        );

        return redirect()->route('cart')->with('success', 'Product added to cart');
    }

    /**
     * Update quantity of an item in the cart.
     */
    public function updateCart(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $quantity]);
        }

        return redirect()->route('cart')->with('success', 'Cart updated');
    }

    /**
     * Remove a product from the cart.
     */
    public function removeFromCart(Product $product)
    {
        CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return redirect()->route('cart')->with('success', 'Product removed from cart');
    }

    /**
     * Checkout and create an order.
     */
    public function checkout()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        foreach ($cartItems as $item) {
            $order->products()->attach($item->product_id, ['quantity' => $item->quantity]);
            $item->delete();
        }

        return redirect()->route('order.history')->with('success', 'Order placed successfully');
    }

    public function account(Request $request)
    {
        $user = Auth::user();
    
        // Determine the section to show based on the query parameter
        $section = $request->query('section', 'profile'); // default to 'profile' section if not specified
    
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
    

    // /**
    //  * Display order history for the customer.
    //  */
    // public function orderHistory()
    // {
    //     $orders = Auth::user()->orders()->with('products')->get();
    //     return view('shop.order_history', compact('orders'));
    // }
}
