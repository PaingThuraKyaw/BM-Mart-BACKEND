<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImg;
use Exception;
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
        $product = Product::all();
        return response()->json([
            'data' => ProductResource::collection($product)
        ]);
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

      try{
        $products = new Product();
        $products->title = $request->title;
        $products->price = $request->price;
        $products->description = $request->description;
        $products->save();


        if($request->hasFile('image')){
          $files =   $request->file('image');
          foreach($files as $file){
            $fileName = time() . '_' . $file->getClientOriginalName();
            $dataFile =  $file->storeAs('public/upload',$fileName);
            $products->productImg()->create([
                'extension' => $file->getClientOriginalExtension(),
                'image' => $dataFile
            ]);
        }

       }

       return response()->json([
        'message' =>"Create Successfully"
       ],201);
      }catch(Exception $err){
         return response()->json([
        'message' => $err
       ]);
      }

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
