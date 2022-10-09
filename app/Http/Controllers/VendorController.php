<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    public function index() {
        // $vendors = Vendor::where('name', 'LIKE', "%".request('search')."%")
        //     ->orderByDesc('vendor_id')
        //     ->paginate(10);

        // $vendors = Vendor::orderByDesc('vendor_id')->get();

        return view('vendor.index', [
            // 'vendors' => $vendors,
            // 'search' => request('search')
        ]);
    }

    public function getVendors(Request $request) {
        if($request->ajax()) {
            $vendors = Vendor::orderByDesc('vendor_id')->select('vendor_id', 'name');
            return DataTables::of($vendors)
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
                            <a href="#" class="vendor_edit_modal_btn" id="edit_'.$row->vendor_id.'">Edit</a>
                            <a href="#" class="vendor_delete_modal_btn" id="delete_'.$row->vendor_id.'">Delete</a>
                        </div>
                    </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getVendor() {
        $vendor_id = $_GET['vendor_id'];
        $vendor = Vendor::where('vendor_id', '=', $vendor_id)->select('name')->first();
        return response()->json(['response'=> $vendor], 200);
    }

    public function store(Request $request) {
        Vendor::create([
            'name' => $request->name
        ]);
        
        return redirect()->back()->with('message', 'Vendor created successfully!');
    }

    public function update(Request $request, $vendor_id) {
        Vendor::where('vendor_id', '=', $vendor_id)->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('message', 'Vendor updated successfully!');
    }

    public function destroy($vendor_id) {
        Vendor::where('vendor_id', '=', $vendor_id)->delete();

        return redirect()->back()->with('message', 'Vendor deleted successfully!');
    }

    // public function searchVendor() {
    //     $v_data = $_GET['v_data'];
    //     $vendors = Vendor::where('name', 'LIKE', "%".$v_data."%")
    //         ->orderByDesc('vendor_id')
    //         ->get();
    //     return response()->json(['response'=> $vendors], 200);
    // }
}
