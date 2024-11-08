<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'Pending')->count();
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'pendingOrders', 'recentOrders'));
    }

    public function orders()
    {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'Shipped';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order marked as shipped.');
    }
    public function products()
    {
        // Fetch all products
        $products = Product::all();
        // Return view with products data
        return view('admin.products', compact('products'));
    }
    public function createProduct()
    {
        return view('admin.create_product');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validated['image'] = $imageName;
        }
    
        Product::create($validated);
    
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function editProduct(Product $product)
    {
        return view('admin.edit_product', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }

            // Upload and save the new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validated['image'] = $imageName;
        } else {
            // Retain the existing image if no new image is uploaded
            $validated['image'] = $product->image;
        }

        // Update the product with validated data
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }


    public function destroyProduct(Product $product)
    {
        // // Check if the product has an image and if the file exists in the specified path
        // $imagePath = public_path('images/products/' . $product->image);
        // if ($product->image && file_exists($imagePath)) {
        //     // Delete the image file
        //     unlink($imagePath);
        // }

        // Delete the product record from the database
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product and associated image deleted successfully.');
    }
}
