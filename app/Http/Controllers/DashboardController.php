<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function Dashboard(Request $request)
    {
        $user_id =Auth::id();
        $customer = customer::where('user_id', $user_id)->count();
        $product = product::where('user_id', $user_id)->count();
        $category = category::where('user_id', $user_id)->count();
        $invoice = Invoice::where('user_id', $user_id)->count();
        $total = Invoice::where('user_id',$user_id)->sum('total');
        $vat= Invoice::where('user_id',$user_id)->sum('vat');
        $payable =Invoice::where('user_id',$user_id)->sum('payable');


        return[
            'product'=> $product,
            'category'=> $category,
            'customer'=> $customer,
            'invoice'=> $invoice,
            'total'=> round($total,2),
            'vat'=> round($vat,2),
            'payable'=> round($payable,2)
        ];
    }

}
