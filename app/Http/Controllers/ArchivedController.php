<?php

namespace App\Http\Controllers;

use App\Models\Workorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class ArchivedController extends Controller
{
    public function index() {
        return view('archived.index');
    }
    public function getArchived(Request $request) {
        if($request->ajax()) {

            $archive = Workorder::where([
                ['cancelled', '=', 0],
                ['archived', '=', 1]
                ])
                // ->orderByDesc('workorder_id')
                ->join('customer_parent', 'workorder.customer_id', '=', 'customer_parent.customer_id')
                ->join('company', 'customer_parent.company_id', "=", "company.company_id")
                ->select("workorder.workorder_id", "workorder.report_name", DB::raw('DATE_FORMAT(workorder.date_received, "%d-%m-%Y") as date_received'), DB::raw('DATE_FORMAT(workorder.date_delivered, "%d-%m-%Y") as date_delivered'), "company.name");

            return DataTables::of($archive)
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
                    <a href="#" class="activate-archive" id="activate_'.$row->workorder_id.'">Activate</a>
                    <a href="#" class="detail-archive" id="detail_'.$row->workorder_id.'">Detail</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function workorderUnArchive($workorder_id) {
        Workorder::where('workorder_id', '=', $workorder_id)->update(['archived' => 0]);

        return Redirect::to(URL::previous())->with('message', 'Workorder updated successfully!');
    }
}
