<?php

namespace App\Http\Controllers;

use App\Models\category;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function CreateCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3',
            ]);
            $user_id =Auth::id();
            category::create([
                'name' => $request->input('name'),
                'user_id' => $user_id,
            ]);
            return response()->json(['status' => 'success', 'message' => 'category created successfully']);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    function UpdateCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3',
                'id' => 'required',
            ]);
            $user_id =Auth::id();
            $category_id = $request->input('id');

            category::where('id', $category_id)->Where('user_id', $user_id)->update([
                'name' => $request->input('name'),
            ]);
            return response()->json(['status' => 'success', 'message' => 'category updated successfully']);

        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }


    function DeleteCategory(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            $user_id =Auth::id();
            $category_id = $request->input('id');
            category::where('id', $category_id)->Where('user_id', $user_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'category deleted successfully']);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    function CategoryById(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            $user_id =Auth::id();
            $category_id = $request->input('id');
            $rows = category::where('id', $category_id)->Where('user_id', $user_id)->first();
            return response()->json(['status' => 'success', 'data' => $rows]);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    function ListCategory(Request $request)
    {
        try {
            $user_id =Auth::id();
            $rows = category::where('user_id', $user_id)->get();
            return response()->json(['status' => 'success', 'data' => $rows]);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
