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
                // ->addIndexColumn()
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
                        $receivedBtn = '<label class="switch with-icon payment-received">
                                <input type="checkbox" name="received" id="received_'.$row->payment_id.'" checked>
                                <span class="control">
                                <span class="check"></span>
                                </span>
                            </label>';
                    } else {
                        $receivedBtn = '<label class="switch with-icon payment-received">
                                <input type="checkbox" name="received" id="received_'.$row->payment_id.'">
                                <span class="control">
                                <span class="check"></span>
                                </span>
                            </label>';
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

    public function updateReceived() {
        $payment_id = $_POST['payment_id'];
        $received = $_POST['received']; 
        Payment::where('payment_id', '=', $payment_id)->update(['received' => $received]);
        return response()->json(['message'=> 'Payment updated successfully!'], 200);
    }

    public function getAmounts() {
        $workorder_id = $_GET['workorder_id'];
        // dd($sub_total);
        $sub_total = 0;
        $sub = WorkorderPart::select('quantity','unit_price')
        ->where('workorder_id','=', $workorder_id)
        ->get();
        foreach($sub as $s) {
            $sub_total = $sub_total + ($s->quantity * $s->unit_price);
        }

        $sales_tax_rate = Workorder::where('workorder_id', '=', $workorder_id)->select('sales_tax_rate')->first();
        $sales_tax_rate = $sales_tax_rate == null ? 0 : $sales_tax_rate->sales_tax_rate;

        $sales_tax = $sub_total * $sales_tax_rate/100;

        $payments = Payment::where([
        ['workorder_id', '=', $workorder_id],
        ['received', '=', 1]
        ])
        ->sum('payment_amount');

        $amount_due = $sub_total - $payments;
        $amount_due += $sales_tax;
        // dd($amount_due);

        return response()->json([
            'sub_total'=> number_format($sub_total, 0), 
            'sales_tax'=> number_format($sales_tax, 0), 
            'amount_due'=> number_format($amount_due, 0)
        ], 200);
    }

    public function getPayment() {
        $payment_id = $_GET['payment_id'];

        $payment = Payment::where('payment_id', '=', $payment_id)
        ->select('payment.*', DB::raw('DATE_FORMAT(payment.payment_date, "%d-%m-%Y") as payment_date'), DB::raw('DATE_FORMAT(payment.cheque_date, "%d-%m-%Y") as cheque_date'))->first();
        return response()->json(['payment'=> $payment], 200);
    }
}
