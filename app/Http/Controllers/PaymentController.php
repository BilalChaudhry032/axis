<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Workorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function index() {
        return view('payments.index');
    }
    public function getPayments(Request $request) {
        if($request->ajax()) {
            $workOrders = Workorder::where([
                ['cancelled', '=', 0],
                ['archived', '=', 0]
                ])
                ->orderByDesc('workorder_id')
                ->join('customer_parent', 'workorder.customer_id', '=', 'customer_parent.customer_id')
                ->join('company', 'customer_parent.company_id', "=", "company.company_id")
                ->select("workorder.workorder_id", "workorder.po_num", "workorder.report_name", DB::raw('DATE_FORMAT(workorder.date_received, "%d-%m-%Y") as date_received'), DB::raw('DATE_FORMAT(workorder.date_delivered, "%d-%m-%Y") as date_delivered'), "company.name");
                // dd($workOrders[0]);
            $payments = Payment::where([
                ['payment_amount', '>', 0],
                ['payment_method_id', '=', 'payment_method.payment_method_id']
            ])->orderBy('workorder_id', 'asc')
            ->crossJoin('payment_method')
            ->select('payment.payment_id', 'payment.workorder_id', 'payment_method.name', DB::raw('DATE_FORMAT(payment.payment_date, "%d/%m/%Y") as payment_date'), 'payment.payment_amount', 'payment.bank_name', 'payment.cheque_num', DB::raw('DATE_FORMAT(payment.cheque_date, "%d/%m/%Y") as cheque_date'), 'payment.cheque_amount', 'payment.received')
            ->get();

            // $sql = "select sum(p.quantity*p.unit_price) as sub_total from workorder_part p, part pa where p.workorder_id=$workorder_id and p.part_id=pa.part_id";
            // $sub_total = DB::select($sql)[0];
            // $sub_total = $sub_total->sub_total;
            
            // $sql = "select p.payment_id, p.workorder_id, (select sum(wp.quantity*wp.unit_price) from workorder_part wp, part pa where wp.workorder_id=p.workorder_id and wp.part_id=pa.part_id), m.name, DATE_FORMAT(p.payment_date, '%d/%m/%Y'), p.payment_amount, p.bank_name, p.cheque_num, DATE_FORMAT(p.cheque_date, '%d/%m/%Y'), p.cheque_amount, p.received from payment p, payment_method m where p.payment_amount > 0 and p.payment_method_id=m.payment_method_id";
            // $payments = DB::select($sql);
            // dd($payments);
            return DataTables::of($payments)
                ->addIndexColumn()
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
                    <a href="#" class="cancel-payment" id="cancel_'.$row->payment_id.'">Cancel</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
