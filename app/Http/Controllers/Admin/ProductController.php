<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // List all product categories
    public function productByCategory()
    {
        $categories = Category::where('type', 'product')->get();
        return view('products.categories', compact('categories'));
    }

    // View products by selected category
    public function index($category_id)
    {
        $category = Category::findOrFail($category_id);
        $products = Product::where('category_id', $category_id)->get();
        return view('products.index', compact('products', 'category'));
    }

    // Show create form
    public function create($category_id)
    {
        $categories = Category::where('type', 'product')->get();
        return view('products.create', compact('categories', 'category_id'));
    }

    // Store product
    public function store(Request $request, $category_id)
    {
        $request->validate([
            'product_id' => 'required|unique:products,product_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/product_images', $imageName);
        }

        Product::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'image_path' => $imageName,
        ]);

        return redirect()->route('products.index', ['category' => $category_id])
                         ->with('success', 'Product added successfully');
    }

    // Edit product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('type', 'product')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    // Update product
    public function update(Request $request, $product_id)
    {
        $request->validate([
            'product_id' => ['required', Rule::unique('products', 'product_id')->ignore($product_id)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($product_id);

        $data = [
            'product_id'  => $request->product_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'stock'       => $request->stock,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/product_images', $imageName);
            $data['image_path'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('products.index', ['category' => $product->category_id])
                         ->with('success', 'Product updated successfully');
    }

    // Delete product
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Product deleted successfully');
    }

    // NEW: Delete category and its products
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        // Delete all products in the category
        Product::where('category_id', $id)->delete();

        // Delete the category
        $category->delete();

        return redirect()->route('products.categories')->with('success', 'Category and its products deleted successfully');
    }
}
