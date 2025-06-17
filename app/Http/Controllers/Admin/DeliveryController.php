<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::all();
        return view('deliveries.index', compact('deliveries'));
    }

    public function create()
    {
        return view('deliveries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        Delivery::create($validated);
        return redirect()->route('deliveries.index')->with('success', 'Delivery created successfully!');
    }

    public function edit($id)
    {
        $delivery = Delivery::findOrFail($id);
        return view('deliveries.edit', compact('delivery'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        Delivery::findOrFail($id)->update($validated);
        return redirect()->route('deliveries.index')->with('success', 'Delivery updated successfully!');
    }

    public function destroy($id)
    {
        Delivery::findOrFail($id)->delete();
        return redirect()->route('deliveries.index')->with('success', 'Delivery deleted successfully!');
    }
}