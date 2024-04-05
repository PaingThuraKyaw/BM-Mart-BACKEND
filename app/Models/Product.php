<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'price',
        'description',
    ];


    public function productImg () {
        return $this->hasMany(ProductImg::class);
    }

    public function rating() {
        return $this->hasMany(Rating::class);
    }

}
