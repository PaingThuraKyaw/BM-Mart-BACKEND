<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'review',
        'user_id',
        'rating_id'
    ];

    public function rating(){
        return $this->belongsTo(Rating::class);
    }
}
