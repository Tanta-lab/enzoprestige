<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        $product->categories()->sync($validated['categories'] ?? []);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Produit créé.');
    }

    public function show(Product $product)
    {
        $product->load('categories');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('categories');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        $product->categories()->sync($validated['categories'] ?? []);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit supprimé.');
    }
}
