<?php

namespace App\Http\Resources;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Rating extends JsonResource
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
            'username' => User::findOrFail($this->id)->name,
            'product_id' => $this->product_id,
            'rating' => $this->rating,
            'review' => Review::where('rating_id','=',$this->id)->pluck('review')[0],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
