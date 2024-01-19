<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
 function InvoiceCreate(Request $request)
 {
     DB::beginTransaction();
     try {
         $request->validate([
             'total' => 'required|string|max:255',
             'discount' => 'required|string|max:255',
             'vat' => 'required|string|max:255',
             'payable' => 'required|string|max:255',
             'customer_id' => 'required|string|max:255',
         ]);
         $user = Auth::id();
         $total = $request->input('total');
         $discount = $request->input('discount');
         $tax = $request->input('vat');
         $payable = $request->input('payable');
         $customer_id = $request->input('customer_id');

         $invoice = Invoice::create([
             'user_id' => $user,
             'total' => $total,
             'discount' => $discount,
             'vat' => $tax,
             'payable' => $payable,
             'customer_id' => $customer_id,
         ]);

         $invoice_id = $invoice->id;
         $products = $request->input('products');
         foreach ($products as $EachProduct) {
             InvoiceProduct::create([
                 'invoice_id' => $invoice_id,
                 'product_id' => $EachProduct['product_id'],
                 'user_id' => $user,
                 'qty' => $EachProduct['qty'],
                 'sale_price' => $EachProduct['sale_price'],
             ]);
         }
         DB::commit();
         return response()->json(['status' => 'success', 'message' => 'Invoice Created']);

     } catch (Exception $ex) {
         DB::rollBack();
         return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
     }
 }

 function InvoiceSelect(Request $request)
 {
     try {
         $user_id = Auth::id();
         $rows = Invoice::where('user_id', $user_id)->with('customer')->get();
         return response()->json(['status' => 'success', 'rows' => $rows]);
     }
     catch (Exception $ex) {
         return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
     }
 }

 function InvoiceDetails(Request $request){
     try {
         $user_id = Auth::id();
         $customerDetails = Customer::where('user_id',$user_id)->where('id',$request->input('cus_id'))->first();
         $invoiceTotal = Invoice::where('user_id',$user_id)->where('id',$request->input('inv_id'))->first();
         $invoiceProduct = InvoiceProduct::where('invoice_id',$request->input('inv_id'))
             ->where('user_id',$user_id)->with('product')->get();

         $rows = [
             'customer'=>$customerDetails,
             'invoice'=>$invoiceTotal,
             'products'=>$invoiceProduct
         ];
         return response()->json(['status' => 'success', 'rows' => $rows]);
     }
     catch (Exception $ex) {
         return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
     }
 }

 function InvoiceDelete(Request $request){
     try {
         $user_id = Auth::id();
         InvoiceProduct::where('invoice_id',$request->input('inv_id'))
             ->where('user_id',$user_id)
             ->delete();

         Invoice::where('id',$request->input('inv_id'))->delete();
         return response()->json(['status' => 'success', 'message' => 'Invoice Deleted']);
     }
     catch (Exception $ex) {
         return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
     }
 }


}
