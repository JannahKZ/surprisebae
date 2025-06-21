<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DecoService;
use App\Models\Category;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;


class DecoServiceController extends Controller
{
    // Show all service categories
    public function serviceByCategory(Request $request)
    {
        $query = Category::where('type', 'service');

        if ($search = $request->query('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $categories = $query->orderBy('name')->get();

        return view('decoServices.categories', compact('categories'));
    }

    // Show all deco services by category
    public function index($category_id)
    {
        $category = Category::findOrFail($category_id);

        $decoServices = DecoService::where('category_id', $category_id)
            ->with('dates', 'category')
            ->get();

        return view('decoServices.index', compact('decoServices', 'category'));
    }

    // Show create form
    public function create($category_id)
    {
        $category = Category::findOrFail($category_id);
        $categories = Category::where('type', 'service')->get();

        // Get unavailable dates from bookings
        $unavailableDates = Booking::all()->flatMap(function ($booking) {
            return json_decode($booking->dates ?? '[]', true);
        })->unique()->values()->toArray();

        return view('decoServices.create', compact('categories', 'unavailableDates', 'category'));
    }

    // Store new service
    public function store(Request $request)
    {
        $datesArray = [];
        if ($request->has('date')) {
            $datesArray = array_filter(array_map('trim', explode(',', $request->input('date'))));
            $request->merge(['date' => $datesArray]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|array|min:1',
            'date.*' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('deco_images', 'public');
        }

        $decoService = DecoService::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'image' => $imagePath,
        ]);

        foreach ($validated['date'] as $date) {
            $decoService->dates()->create(['date' => $date]);
        }

        return redirect()->route('decoServices.index', $decoService->category_id)
                         ->with('success', 'DecoService created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $decoService = DecoService::with('dates')->findOrFail($id);
        $categories = Category::where('type', 'service')->get();
        $datesArray = $decoService->dates->pluck('date')->toArray();

        return view('decoServices.edit', compact('decoService', 'categories', 'datesArray'));
    }

    // Update service
    public function update(Request $request, $id)
    {

        $datesArray = [];
        if ($request->has('date')) {
            $datesArray = array_filter(array_map('trim', explode(',', $request->input('date'))));
            $request->merge(['date' => $datesArray]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|array|min:1',
            'date.*' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $decoService = DecoService::findOrFail($id);

        

        if ($request->hasFile('image')) {
            if ($decoService->image && Storage::disk('public')->exists($decoService->image)) {
                Storage::disk('public')->delete($decoService->image);
            }

            $imagePath = $request->file('image')->store('deco_images', 'public');
            $decoService->image_url = $imagePath;
        }

        $decoService->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        // Sync dates
        $decoService->dates()->delete();
        foreach ($validated['date'] as $date) {
            $decoService->dates()->create(['date' => $date]);
        }

        return redirect()->route('decoServices.index', $decoService->category_id)
                         ->with('success', 'DecoService updated successfully!');
    }

    // Delete service
    public function destroy($id)
    {
        $decoService = DecoService::findOrFail($id);
        $category_id = $decoService->category_id;

        $decoService->dates()->delete();
        $decoService->delete();

        return redirect()->route('decoServices.index', $category_id)
                         ->with('success', 'DecoService deleted successfully!');
    }

    // Delete category and all services under it
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        $services = DecoService::where('category_id', $id)->get();
        foreach ($services as $service) {
            $service->dates()->delete();
            $service->delete();
        }

        $category->delete();

        return redirect()->route('decoServices.categories')
                         ->with('success', 'Category and its services deleted successfully!');
    }
}
