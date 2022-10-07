<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
// use Yajra\Datatables\Facades\Datatables;

class VendorController extends Controller
{
    public function index() {
        // $vendors = Vendor::where('name', 'LIKE', "%".request('search')."%")
        //     ->orderByDesc('vendor_id')
        //     ->paginate(10);

        $vendors = Vendor::orderByDesc('vendor_id')->get();

        return view('vendor.index', [
            'vendors' => $vendors,
            // 'search' => request('search')
        ]);
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
