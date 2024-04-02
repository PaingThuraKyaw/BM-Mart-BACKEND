<?php

namespace App\Http\Resources;

use App\Models\ProductImg;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $files = ProductImg::where('product_id', '=', $this->id)->get();
        $image = [];
        foreach ($files as $file) {
            $image[]  =  asset(str_replace('public', 'storage', $file->image));
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $image
        ];
    }
}
