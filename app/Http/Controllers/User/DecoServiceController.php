<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DecoServiceResource;
use App\Models\DecoService;


class DecoServiceController extends Controller
{
    public function getUnavailableDates($id)
    {
        $decoService = DecoService::with('dates')->findOrFail($id);

        $dates = $decoService->dates->pluck('date')->toArray();

        return response()->json($dates);
    }

    public function index()
    {
        $services = DecoService::with('category')->get();

        $formattedServices = $services->map(function ($service) {
            return [
                'id' => $service->id,
                'title' => $service->name,
                'description' => $service->description,
                'price' => $service->price,
                'image_url' => $service->image_url 
                    ? asset('storage/deco_images/' . $service->image_url) 
                    : null,
                'category' => $service->category 
                    ? [
                        'id' => $service->category->id,
                        'name' => $service->category->name,
                    ]
                    : null,
            ];
        });

        return response()->json($formattedServices);
    }

    public function show($id)
    {
        $service = DecoService::with(['dates','category'])->find($id);
        return $service 
            ? new DecoServiceResource($service) 
            : response()->json(['message' => 'Not found'], 404);
    }

    public function store(Request $request)
    {
        $service = DecoService::create($request->all());
        return response()->json($service, 201);
    }

    public function update(Request $request, $id)
    {
        $service = DecoService::find($id);
        if (!$service) return response()->json(['message' => 'Not found'], 404);

        $service->update($request->all());
        return response()->json($service);
    }

    public function destroy($id)
    {
        $service = DecoService::find($id);
        if (!$service) return response()->json(['message' => 'Not found'], 404);

        $service->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
