<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    public function index() {

        return view('company.index');
    }
    public function getCompanies(Request $request) {
        if($request->ajax()) {
            $companies = Company::select('company_id', 'name');

            return DataTables::of($companies)
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
                            <a href="#" class="company_edit_modal_btn" id="edit_'.$row->company_id.'">Edit</a>
                            <a href="#" class="company_delete_modal_btn" id="delete_'.$row->company_id.'">Delete</a>
                        </div>
                    </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function store(Request $request) {
        Company::create([
            'name' => $request->name
        ]);
        
        return redirect()->back()->with('message', 'Company created successfully!');
    }

    public function getCompany() {
        $company_id = $_GET['company_id'];
        $company = Company::where('company_id', '=', $company_id)->select('name')->first();
        return response()->json(['response'=> $company], 200);
    }
    public function update(Request $request, $company_id) {
        Company::where('company_id', '=', $company_id)->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('message', 'Company updated successfully!');
    }

    public function destroy($company_id) {
        Company::where('company_id', '=', $company_id)->delete();

        return redirect()->back()->with('message', 'Company deleted successfully!');
    }
}
