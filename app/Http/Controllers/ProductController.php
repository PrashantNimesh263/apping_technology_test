<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::with('category')->paginate(10); // Paginate 10 products per page
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('products.create', compact('categories'));
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
        ]);

        // Store the product
        Product::create($validated);

        // Redirect with success message
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
        ]);

        // Update the product
        $product->update($validated);

        // Redirect with success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

