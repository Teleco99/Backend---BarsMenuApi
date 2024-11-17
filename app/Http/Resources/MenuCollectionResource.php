<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'idAdmin' => $this->idAdmin,
            'name' => $this->name,
            'hasImage' => (bool) $this->hasImage,
            'products' => ProductResource::collection($this->products),
        ];
    }
}
