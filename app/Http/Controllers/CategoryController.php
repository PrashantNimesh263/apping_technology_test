<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'name' => 'required|unique:categories,name', // Ensures 'name' is unique in 'categories' table
        ]);

        // Store the category if validation passes
        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Validation rules with unique check, but excluding the current category being updated
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id, // Excluding the current category's ID
        ]);

        // Update the category if validation passes
        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

}

