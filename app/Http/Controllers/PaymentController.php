<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index() {
        return view('payments.index');
    }
    public function getPayments(Request $request) {
        if($request->ajax()) {
            // $workOrders = Workorder::where([
            //     ['cancelled', '=', 0],
            //     ['archived', '=', 0]
            //     ])
            //     ->orderByDesc('workorder_id')
            //     ->join('customer_parent', 'workorder.customer_id', '=', 'customer_parent.customer_id')
            //     ->join('company', 'customer_parent.company_id', "=", "company.company_id")
            //     ->select("workorder.workorder_id", "workorder.po_num", "workorder.report_name", DB::raw('DATE_FORMAT(workorder.date_received, "%d-%m-%Y") as date_received'), DB::raw('DATE_FORMAT(workorder.date_delivered, "%d-%m-%Y") as date_delivered'), "company.name");
            //     // dd($workOrders[0]);
            // return DataTables::of($workOrders)
            //     ->addIndexColumn()
            //     ->addColumn('action', function($row){
            //         $actionBtn = '<div class="dropdown-button">
            //         <a href="#" class="d-flex align-items-center justify-content-end" data-toggle="dropdown">
            //         <div class="menu-icon mr-0">
            //         <span></span>
            //         <span></span>
            //         <span></span>
            //         </div>
            //         </a>
            //         <div class="dropdown-menu dropdown-menu-right">
            //         <a href="#" class="edit-workorder" id="edit_'.$row->workorder_id.'">Edit</a>
            //         <a href="#" class="cancel-workorder" id="cancel_'.$row->workorder_id.'">Cancel</a>
            //         <a href="#" class="archive-workorder" id="archive_'.$row->workorder_id.'">Archive</a>
            //         </div>
            //         </div>';
            //         return $actionBtn;
            //     })
            //     ->rawColumns(['action'])
            //     ->make(true);
        }
    }
}
