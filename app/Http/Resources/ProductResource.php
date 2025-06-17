<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category?->name ?? 'Uncategorized',
            'image_url' => $this->image_path
                ? asset('storage/product_images/' . basename($this->image_path))
                : null,
        ];
    }
}
