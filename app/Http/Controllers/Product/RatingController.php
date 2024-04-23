<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rating as ResourcesRating;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rating = new Rating();

        $review = new Review();
        return response()->json([
            'message' => ResourcesRating::collection($rating->all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|in:1,2,3,4,5',
            'review' => 'required|min:1'
        ]);

        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 400);
        }

        $user = auth()->user();
        $product = Product::findOrFail($request->product_id);

        // Check if the user has already rated the product
        $existingRating = Rating::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingRating) {
            return response()->json(['message' => 'You have already rated this product'], 400);
        }

        $rating = new Rating();
        $rating->user_id = $user->id;
        $rating->product_id = $product->id;
        $rating->rating = $request->rating;
        $rating->save();

        $review =  Review::create([
            'review' => $request->review,
            'rating_id' => $rating->id
        ]);


        return response()->json([
            'rating' => $rating,
            'review' => $review
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
