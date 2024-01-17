<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function ProductCreate(Request $request , )
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'unit_price' => 'required|numeric',
                'category_id' => 'required|string|max:255',
                'quantity' => 'required|numeric',
                'image' => 'required|image',
            ]);
            $user_id =Auth::id();
            $img = $request->file('image');
            $t = time();
            $file_name =$img->getClientOriginalName();
            $img_name =("{$user_id}-$t-{$file_name}");
            $img_url="uploads/{$img_name}";

            $img->move(public_path('uploads'), $img_name);

            Product::create([
                'name' => $request->input('name'),
                'quantity' => $request->input('quantity'),
                'description' => $request->input('description'),
                'unit_price' => $request->input('unit_price'),
                'category_id' => $request->input('category_id'),
                'image' => $img_url,
                'user_id' => $user_id,
            ]);
            return response()->json(['status' => 'success', 'message' => 'product created successfully']);



        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    function ProductUpdate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'unit_price' => 'required|numeric',
                'category_id' => 'required|string|max:255',
                'quantity' => 'required|numeric',
            ]);
            $user_id = Auth::id();
            $product_id = $request->input('id');

       if ($request->hasFile('image')) {
           $img = $request->file('image');
           $t = time();
           $file_name = $img->getClientOriginalName();
           $img_name = ("{$user_id}-$t-{$file_name}");
           $img_url = "uploads/{$img_name}";
           $img->move(public_path('uploads'), $img_name);

            $filePath = $request->input('file_path');
            File::delete($filePath);




      return Product::where('id', $product_id)->Where('user_id', $user_id)->update([
        'name' => $request->input('name'),
        'quantity' => $request->input('quantity'),
        'description' => $request->input('description'),
        'unit_price' => $request->input('unit_price'),
        'category_id' => $request->input('category_id'),
        'image' => $img_url,
        'user_id' => $user_id,
    ]);
}
        else {
    return Product::where('id', $product_id)->Where('user_id', $user_id)->update([
        'name' => $request->input('name'),
        'quantity' => $request->input('quantity'),
        'description' => $request->input('description'),
        'unit_price' => $request->input('unit_price'),
        'category_id' => $request->input('category_id'),
        'user_id' => $user_id,
    ]);
}


        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    function ProductDelete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            $user_id =Auth::id();
            $product_id = $request->input('id');
            $filePath = $request->input('file_path');
            File::delete($filePath);
           return Product::where('id', $product_id)->Where('user_id', $user_id)->delete();
        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    function ProductById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            $user_id =Auth::id();
            $product_id = $request->input('id');
            $rows = Product::where('id', $product_id)->Where('user_id', $user_id)->first();
            return response()->json(['status' => 'success', 'data' => $rows]);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    function ProductList(Request $request)
    {
        try {
            $user_id =Auth::id();
            $rows = Product::with('category')->where('user_id', $user_id)->get();
            return response()->json(['status' => 'success', 'data' => $rows]);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
