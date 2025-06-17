<?php
// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show the form to create a new category
    public function create()
    {
        return view('categories.create'); // Form to add a new category
    }

    // Store a newly created category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:product,service',
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        // Redirect based on type
        return $request->type === 'product'
            ? redirect()->route('categories.products.categories')->with('success', 'Product category added.')
            : redirect()->route('categories.decoServices.categories')->with('success', 'Service category added.');
    }
    // Display a list of categories
    public function productbyCategory()
    {
        $categories = Category::where('type', 'product')->get();
        return view('products.categories', compact('categories'));
    }

    public function serviceByCategory()
    {
        $categories = Category::where('type', 'service')->get();
        return view('decoServices.categories', compact('categories'));
    }

    // Show the form for editing a specific category
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Update the specified category in the database
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:product,service',

        ]);

        $category->update([
            'name' => $request->name,
            'type' => $request->type,

        ]);

        // Redirect based on type
        return $request->type === 'product'
            ? redirect()->route('categories.products.categories')->with('success', 'Product category added.')
            : redirect()->route('categories.decoServices.categories')->with('success', 'Service category added.');    }

    // Delete the specified category from the database
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $type = $category->type;
        $category->delete();

        if ($type === 'product') {
            return redirect()->route('categories.products.categories')->with('success', 'Product category deleted successfully!');
        } else {
            return redirect()->route('categories.decoServices.categories')->with('success', 'Service category deleted successfully!');
        }
    }
}
