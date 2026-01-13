<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // --- Get /api/products
    public function getProducts()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'message' => 'Getting list of products',
            'data' => $products
        ], 200);
    }

    // --- Post /api/products
    public function createProduct(Request $request)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'pricing' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'images' => 'nullable|array'
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product->load('category')
        ], 201);
    }

    // --- Get /api/products/{productId}
    public function getProduct($productId)
    {
        $product = Product::with('category')->findOrFail($productId);
        $this->authorize('view', $product);

        return response()->json([
            'message' => 'Getting product by ID',
            'data' => $product
        ], 200);
    }

    // --- Patch /api/products/{productId}
    public function updateProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'pricing' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'images' => 'nullable|array'
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->fresh()->load('category')
        ], 200);
    }

    // --- Delete /api/products/{productId}
    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $this->authorize('delete', $product);

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
