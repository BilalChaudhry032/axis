<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BillingAddressController extends Controller
{
    public function index() {
        return view('billingAddress.index');
    }
    public function getBillingAddresses(Request $request) {
        if($request->ajax()) {
            $billingAddresses = BillingAddress::select('billing_address_id', 'name');

            return DataTables::of($billingAddresses)
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
                            <a href="#" class="bill_addr_edit_modal_btn" id="edit_'.$row->billing_address_id.'">Edit</a>
                            <a href="#" class="bill_addr_delete_modal_btn" id="delete_'.$row->billing_address_id.'">Delete</a>
                        </div>
                    </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function store(Request $request) {
        BillingAddress::create([
            'name' => $request->name
        ]);
        
        return redirect()->back()->with('message', 'Billing Address created successfully!');
    }

    public function getBillingAddress() {
        $billing_address_id = $_GET['billing_address_id'];
        $billing_address = BillingAddress::where('billing_address_id', '=', $billing_address_id)->select('name')->first();
        return response()->json(['response'=> $billing_address], 200);
    }
    public function update(Request $request, $billing_address_id) {
        BillingAddress::where('billing_address_id', '=', $billing_address_id)->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('message', 'Billing Address updated successfully!');
    }

    public function destroy($billing_address_id) {
        BillingAddress::where('billing_address_id', '=', $billing_address_id)->delete();

        return redirect()->back()->with('message', 'Billing Address deleted successfully!');
    }
}
