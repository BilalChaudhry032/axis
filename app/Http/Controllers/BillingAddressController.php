<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use Illuminate\Http\Request;

class BillingAddressController extends Controller
{
    public function index() {
        $billingAddresses = BillingAddress::where('name', 'LIKE', "%".request('search')."%")
            ->orderByDesc('billing_address_id')
            ->paginate(10);

        return view('billingAddress.index', [
            'billingAddresses' => $billingAddresses,
            'search' => request('search')
        ]);
    }

    public function store(Request $request) {
        BillingAddress::create([
            'name' => $request->name
        ]);
        
        return redirect()->back()->with('message', 'Billing Address created successfully!');
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
