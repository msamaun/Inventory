<?php

namespace App\Http\Controllers;

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
         $user_id = Auth::id();
         $total = $request->input('total');
         $discount = $request->input('discount');
         $tax = $request->input('tax');
         $payable = $request->input('payable');
         $customer_id = $request->input('customer_id');

         $invoice = Invoice::create([
             'user_id' => $user_id,
             'total' => $total,
             'discount' => $discount,
             'tax' => $tax,
             'payable' => $payable,
             'customer_id' => $customer_id
             
         ]);



         $invoiceID =$invoice->id;
         $products = $request->input('products');

         foreach ($products as $Product)
         {
             InvoiceProduct::create([
                 'invoice_id' => $invoiceID,
                 'user_id' => $user_id,
                 'product_id' => $Product['product_id'],
                 'quantity' => $Product['quantity'],
                 'price' => $Product['price']
             ]);

         }
         DB::commit();
         return response()->json('Invoice Created Successfully');
         }
         catch (Exception $e) {
         DB::rollback();
         return response()->json($e->getMessage());
     }
 }
}
