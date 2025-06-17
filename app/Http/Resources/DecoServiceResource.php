<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DecoServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name, // Map 'title' to 'name' for consistency with product
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id ?? null,
                    'name' => $this->category->name ?? null,
                ];
            }),
            'image_url' => $this->image_path
                ? asset('storage/deco_images/' . basename($this->image_path))
                : null,
            'unavailable_dates' => $this->whenLoaded('dates', function () {
                return $this->dates->pluck('date')->values();
            }),
            'created_at' => $this->created_at,
        ];
    }
}
