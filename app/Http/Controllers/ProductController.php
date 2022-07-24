<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function storeProduct(Request $request)
    {
            //get the base-64 from data
            $image = $request->path_image;

            //decode base64 string
            $image = base64_decode($image);

            $safeName = Str::random(10).'.'.'png';
            Storage::disk('public')->put('product/'.$safeName, $image);
            $path = env('APP_URL').'/storage/product/'.$safeName;
           
            $imageProduct             = new Product();
            $imageProduct->name       = $request->name;
            $imageProduct->path_image =  $path;
            $imageProduct->description= $request->description;

            $imageProduct->save(); 

 
            return response([
                $imageProduct,
                'message'    => 'Créez un nouveau produit !',
                    ], 200);
    }
    public function update(Request $request,Product $product)
    {  
        //get the base-64 from data

            $image = $request->path_image;
            $image = base64_decode($image);
            
            $safeName = Str::random(10).'.'.'png';
            Storage::disk('public')->put('product/'.$safeName, $image);
            $path = env('APP_URL').'/storage/product/'.$safeName;
            
            $product->update([   
                'name'           => $request->name,
                'path_image'     => $path,
                'description'    => $request->description,
            ]);

                return response([
                    $product ,
                    'message'    => 'Mettre à jour une code produit !',
                        ], 200);
   }
}
