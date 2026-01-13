<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // --- Get /api/categories
    public function getCategories()
    {
        $categories = Category::all();
        
        return response()->json([
            "message" => "Getting list of categories",
            "data" => $categories
        ], 200);
    }

    // --- Web GET /categories (alias)
    public function index()
    {
        return $this->getCategories();
    }

    // --- Post /api/categories
    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        $category = Category::create($validated);

        return response()->json([
            "message" => "Category created successfully",
            "data" => $category
        ], 201);
    }

    // --- Get /api/categories/{categoryId}
    public function getCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return response()->json([
            "message" => "Getting category by ID",
            "data" => $category
        ], 200);
    }

    // --- Patch /api/categories/{categoryId}
    public function updateCategory(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $categoryId
        ]);

        $category->update($validated);

        return response()->json([
            "message" => "Category updated successfully",
            "data" => $category->fresh()
        ], 200);
    }

    // --- Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();

        return response()->json([
            "message" => "Category deleted successfully"
        ], 200);
    }
}