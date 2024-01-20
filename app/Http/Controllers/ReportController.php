<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    function salesReport(Request $request):Response
    {
        $user_id = Auth::id();
        $FormDate = date('Y-m-d', strtotime($request->FormDate));
        $ToDate = date('Y-m-d', strtotime($request->ToDate));

        $total=Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat=Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $payable=Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');
        $discount=Invoice::where('user_id', $user_id)->whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');

        $list=Invoice::where('user_id', $user_id)
                 ->whereDate('created_at', '>=', $FormDate)
                ->whereDate('created_at', '<=', $ToDate)
                ->with('customer')->get();


        $data = [
            'total' => $total,
            'vat' => $vat,
            'payable' => $payable,
            'discount' => $discount,
            'list' => $list,
            'FormDate' => $request->FormDate,
            'ToDate' => $request->ToDate,


        ];

        $pdf =Pdf::loadView('admin.report.SalesReport', $data);

        return $pdf->download('invoice.pdf');
    }
}
