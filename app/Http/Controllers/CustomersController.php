<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\CustomerChild;
use App\Models\CustomerParent;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CustomersController extends Controller
{
    public function index() {
        return view('customers.index');
    }
    public function getCustomers(Request $request) {
        if($request->ajax()) {

            $customers = CustomerParent::join('company', 'customer_parent.company_id', "=", "company.company_id")
                ->join('billing_address', 'customer_parent.billing_address_id', "=", "billing_address.billing_address_id")
                ->select("company.name as company_name", "billing_address.name as billing_address_name", "customer_parent.postal_address", "customer_parent.city", "customer_parent.customer_id");

            return DataTables::of($customers)
                ->addIndexColumn()
                ->addColumn('contacts_persons', function($row){
                    $persons = CustomerChild::where('customer_id', '=', $row->customer_id)->select('last_name')->get();
                    $html = '';
                    foreach($persons as $key=>$person) {
                        $html .= $person->last_name;
                        if(count($persons) > 1 && $key < count($persons)-1) {
                            $html .= ', ';
                        }
                    }
                    return $html;
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
                    <a href="#" class="edit-archive" id="edit_'.$row->customer_id.'">Edit</a>
                    <a href="#" class="delete-archive" id="delete_'.$row->customer_id.'">Delete</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function createCustomer() {
        $billing_address = BillingAddress::get();
        $company = Company::get();
        $country = Country::get();
        $province = Province::get();
        $city = City::get();
        return view('customers.create', [
            'billing_address' => $billing_address,
            'company' => $company,
            'country' => $country,
            'province' => $province,
            'city' => $city
        ]);
    }
    public function storeCustomer(Request $request) {

        $findCustomer = CustomerParent::where([
            ['company_id', '=', $request->company_id],
            ['billing_address_id', '=', $request->billing_address_id]
        ])->select('customer_id')->first();

        if(strlen($findCustomer) > 0) {
            return redirect()->back()->with([
                'error' => 'Customer already exist!', 
                'postal_address' => $request->postal_address,
                'postal_code' => $request->postal_code,
                'fax' => $request->fax,
                'extension' => $request->extension,
                'company_id' => $request->company_id,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'telephone' => $request->telephone
            ]);
        }
        
        CustomerParent::create([
            'postal_address' => $request->postal_address,
            'postal_code' => $request->postal_code,
            'fax' => $request->fax,
            'extension' => $request->extension,
            'company_id' => $request->company_id,
            'billing_address_id' => $request->billing_address_id,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'telephone' => $request->telephone
        ]);

        return view('customers.create')->with('message', 'Customer created successfully!');
    }

    public function updateCustomer() {
        return view('customers.update');
    }
    public function editCustomer() {
        return redirect()->back()->with('message', 'Customer updated successfully!');
    }
    public function getContacts(Request $request) {
        if($request->ajax()) {

            $customers = CustomerParent::join('company', 'customer_parent.company_id', "=", "company.company_id")
                ->join('billing_address', 'customer_parent.billing_address_id', "=", "billing_address.billing_address_id")
                ->select("company.name as company_name", "billing_address.name as billing_address_name", "customer_parent.postal_address", "customer_parent.city", "customer_parent.customer_id")->get();

            return DataTables::of($customers)
                ->addIndexColumn()
                ->addColumn('contacts_persons', function($row){
                    $persons = CustomerChild::where('customer_id', '=', $row->customer_id)->select('last_name')->get();
                    $html = '';
                    foreach($persons as $key=>$person) {
                        $html .= $person->last_name;
                        if(count($persons) > 1 && $key < count($persons)-1) {
                            $html .= ', ';
                        }
                    }
                    return $html;
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
                    <a href="#" class="edit-archive" id="edit_'.$row->customer_id.'">Edit</a>
                    <a href="#" class="delete-archive" id="delete_'.$row->customer_id.'">Delete</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}