<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Workorder;
use App\Models\WorkorderPart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function index() {
        $payment_method_list = PaymentMethod::select('payment_method_id', 'name')->get();
        return view('payments.index', [
            'payment_method_list' => $payment_method_list,
        ]);
    }
    public function getPayments(Request $request) {
        if($request->ajax()) {

            $payments = Payment::where('payment_amount', '>', 0)->select('payment.*');

            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('invoice_amount', function($row, $sub_total = 0){
                    $sub = WorkorderPart::select('quantity','unit_price')
                    ->where('workorder_id','=', $row->workorder_id)
                    ->get();
                    foreach($sub as $s) {
                        $sub_total = $sub_total + ($s->quantity * $s->unit_price);
                    }
                    return $sub_total;
                })
                ->addColumn('name', function($row){
                    if($row->payment_method_id == 1) {
                        $nameBtn = 'Cash';
                    } elseif($row->payment_method_id == 2) {
                        $nameBtn = 'Checque';
                    } else {
                        $nameBtn = '';
                    }
                    return $nameBtn;
                })
                ->addColumn('payment_date', function($row){
                    return Carbon::parse($row->payment_date)->format('d-m-Y');
                })
                ->addColumn('cheque_date', function($row){
                    return Carbon::parse($row->cheque_date)->format('d-m-Y');
                })
                ->addColumn('received', function($row){
                    if($row->received == 1) {
                        $receivedBtn = '<span class="font-weight-bold text-success">Yes</span>';
                    } else {
                        $receivedBtn = '<span class="font-weight-bold text-danger">No</span>';
                    }
                    return $receivedBtn;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<div class="dropdown-button">
                    <a href="#" class="d-flex align-items-center justify-content-end" data-toggle="dropdown">
                    <div class="menu-icon mr-0">
                    <span></span>
                    <span></span>
                    <span></span>
                    </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="edit-payment" id="edit_'.$row->payment_id.'">Edit</a>
                    <a href="#" class="delete-payment" id="delete_'.$row->payment_id.'">Delete</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'received'])
                ->make(true);
        }
    }
}
