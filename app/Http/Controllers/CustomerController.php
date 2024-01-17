<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
   function CustomerCreate(Request $request)
   {
       try {
           $request->validate([
               'firstName' => 'required|string|max:255',
               'lastName' => 'required|string|max:255',
               'email' => 'required|email|max:255',
               'phone' => 'required|string|max:255',
               'address' => 'required|string|max:255',
           ]);
           $user_id =Auth::id();
           customer::create([
               'firstName' => $request->input('firstName'),
               'lastName' => $request->input('lastName'),
               'email' => $request->input('email'),
               'phone' => $request->input('phone'),
               'address' => $request->input('address'),
               'user_id' => $user_id,
           ]);
           return response()->json(['status' => 'success', 'message' => 'customer created successfully']);

       }

       catch (Exception $e) {
           return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
       }
   }

   function CustomerUpdate(Request $request){
       try{
          $request->validate([
              'id' => 'required',
              'firstName' => 'required|string|max:255',
              'lastName' => 'required|string|max:255',
              'email' => 'required|email|max:255',
              'phone' => 'required|string|max:255',
              'address' => 'required|string|max:255',
          ]);
          $user_id =Auth::id();
          $customer_id = $request->input('id');
          customer::where('id', $customer_id)->Where('user_id', $user_id)->update([
              'firstName' => $request->input('firstName'),
              'lastName' => $request->input('lastName'),
              'email' => $request->input('email'),
              'phone' => $request->input('phone'),
              'address' => $request->input('address'),
          ]);
          return response()->json(['status' => 'success', 'message' => 'customer updated successfully']);
       }
       catch(Exception $e){
           return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
       }
   }

   function CustomerDelete(Request $request){
       try {
           $request->validate([
               'id' => 'required',
           ]);
           $user_id =Auth::id();
           $customer_id = $request->input('id');
           customer::where('id', $customer_id)->Where('user_id', $user_id)->delete();
           return response()->json(['status' => 'success', 'message' => 'customer deleted successfully']);

       }
       catch(Exception $e){
           return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
       }
   }

   function CustomerList(Request $request){
       try {
           $user_id =Auth::id();
           $rows = customer::where('user_id', $user_id)->get();
           return response()->json(['status' => 'success', 'data' => $rows]);
       }
       catch (Exception $e) {
           return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
       }
   }

   function CustomerById(Request $request)
   {
       try {
           $request->validate([
               'id' => 'required',
           ]);
           $user_id =Auth::id();
           $customer_id = $request->input('id');
           $rows = customer::where('id', $customer_id)->Where('user_id', $user_id)->first();
           return response()->json(['status' => 'success', 'data' => $rows]);
       }
       catch (Exception $e) {
           return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
       }
   }

}
