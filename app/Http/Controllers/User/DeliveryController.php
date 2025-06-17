<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        return response()->json(Delivery::all());
    }

    public function show($id)
    {
        $delivery = Delivery::find($id);
        if (!$delivery) {
            return response()->json(['message' => 'Delivery not found'], 404);
        }
        return response()->json($delivery);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $delivery = Delivery::create($validated);

        return response()->json($delivery, 201);
    }

    public function update(Request $request, $id)
    {
        $delivery = Delivery::find($id);
        if (!$delivery) {
            return response()->json(['message' => 'Delivery not found'], 404);
        }

        $validated = $request->validate([
            'address' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:255',
        ]);

        $delivery->update($validated);

        return response()->json($delivery);
    }

    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        if (!$delivery) {
            return response()->json(['message' => 'Delivery not found'], 404);
        }

        $delivery->delete();

        return response()->json(['message' => 'Delivery deleted']);
    }
}
