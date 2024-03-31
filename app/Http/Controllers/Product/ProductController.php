<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(),[
            'title' => 'required',
            'price' => 'required|integer',
            'description' => 'required',
            'image' => ['required']
        ]);

        if($validation->fails()){
            return response()->json([
                'message' => $validation->errors()
            ]);
        };

        $products = new Product();
        $products->title = $request->title;
        $products->price = $request->price;
        $products->description = $request->description;
        $products->save();

       if($request->hasFile('image')){
          $files =   $request->file('image');
          foreach($files as $file){
            $products->productImg()->create([
                'extension' => $file->getClientOriginalExtension(),
                'image' => $file->getClientOriginalName()
            ]);
          }
       }

       return response()->json([
        'message' =>"Create Successfully"
       ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
