<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\Company;
use App\Models\Country;
use App\Models\CustomerChild;
use App\Models\CustomerParent;
use App\Models\Employee;
use App\Models\Part;
use App\Models\Payment;
use App\Models\Vendor;
use App\Models\Workorder;
use App\Models\WorkorderPart;
use Carbon\Carbon;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index() {
        // DB::enableQueryLog();
        // dd(is_int(request('search')));
        // $_date = '';
        // if( filter_var(request('search'), FILTER_VALIDATE_INT) && ValidateDate(request('search')) ) {
        //     $_date = \Carbon\Carbon::parse(request('search'))->format('Y-m-d');
        // }
        
        $workOrders = Workorder::where([
            ['cancelled', '=', 0],
            ['archived', '=', 0]
        ])
        ->orderByDesc('workorder_id')
        ->join('customer_parent', 'workorder.customer_id', '=', 'customer_parent.customer_id')
        ->join('company', 'customer_parent.company_id', "=", "company.company_id")
        ->select("workorder.*", "company.name")
        ->where('company.name', 'LIKE', "%".request('search')."%")
        ->orWhere('workorder_id', 'LIKE', "%".request('search')."%")
        ->orWhere('po_num', 'LIKE', "%".request('search')."%")
        ->orWhere('report_name', 'LIKE', "%".request('search')."%")
        // ->orWhere('date_received', 'LIKE', "%".$_date."%")
        // ->orWhere('date_delivered', 'LIKE', "%".$_date."%")
        ->paginate(10);
        // dd(DB::getQueryLog());

        return view('workorders.index', [
            'workOrders' => $workOrders
        ]);
    }

    public function editWorkorder($workorder_id) {
        $workOrder = Workorder::where('workorder_id', '=', $workorder_id)->first();

        $customer_address = CustomerParent::where('customer_id', '=', $workOrder->customer_id)->first();

        $customer_info = CustomerChild::where([
            ['customer_id', '=', $workOrder->customer_id],
            ['active', '=', 1]
        ])->get();

        $countries = Country::all();

        $all_billing_address = BillingAddress::all();

        $company = Company::get();

        $vendor = Vendor::get();

        // $payment = Payment::where('workorder_id', '=', $workOrder->workorder_id)->get();
        
        $sql = "select sum(p.quantity*p.unit_price) as sub_total from workorder_part p, part pa where p.workorder_id=$workOrder->workorder_id and p.part_id=pa.part_id";
        $sub_total = DB::select($sql);
        $sub_total = $sub_total[0]->sub_total;

        $payments = Payment::where([
            ['workorder_id', '=', $workOrder->workorder_id],
            ['received', '=', 1]
        ])
        ->sum('payment_amount');

        // dd($sub_total - $payments);

        // WorkOrder Parts
        $wo_parts = WorkorderPart::where('workorder_id', '=', $workOrder->workorder_id)
        ->join('part', 'part.part_id', '=', 'workorder_part.part_id')
        ->select('workorder_part.wo_part_id', 'workorder_part.part_id', 'part.name', 'workorder_part.quantity', 'workorder_part.unit_price', 'workorder_part.us_price', 'workorder_part.exchange_rate')->paginate(10);

        $parts_list = Part::select('name', 'part_id')->get();
// dd($company);

        $workorder_id = (isset($workOrder) ? $workOrder->workorder_id : '');
        $date_received = (isset($workOrder) ? Carbon::parse($workOrder->date_received)->format('d-m-Y') : '');
        $po_num = (isset($workOrder) ? $workOrder->po_num : '');
        $reference_num = (isset($workOrder) ? $workOrder->reference_num : '');
        $branch = (isset($workOrder) ? $workOrder->branch : '');
        $woCountry = (isset($workOrder) ? $workOrder->country : '');
        $serial_num = (isset($workOrder) ? $workOrder->serial_num : '');
        $problem_desc = (isset($workOrder) ? $workOrder->problem_desc : '');
        $date_delivered = (isset($workOrder) ? Carbon::parse($workOrder->date_delivered)->format('d-m-Y') : '');
        $hardcopy_delivered = (isset($workOrder) ? $workOrder->hardcopy_delivered : '');
        $contact_person = (isset($workOrder) ? $workOrder->child_id : '');
        $report_name = (isset($workOrder) ? $workOrder->report_name : '');
        $vendor_id = (isset($workOrder) ? $workOrder->vendor_id : '');
        $discount = (isset($workOrder) ? $workOrder->discount : '');
        $sales_tax_rate = (isset($workOrder) ? $workOrder->sales_tax_rate : '');
        $financial = (isset($workOrder) ? $workOrder->financial : '');

        $woBilling_address = (isset($customer_address) ? $customer_address->billing_address_id : '');
        $postal_address = (isset($customer_address) ? $customer_address->postal_address : '');
        $company_id = (isset($customer_address) ? $customer_address->company_id : '');

        $amount_due = $sub_total - $payments;
        $sales_tax = $sub_total*$sales_tax_rate/100;
        $order_total = $sub_total+$sales_tax;
        $amount_due += $sales_tax;

        $sub_total = ($sub_total == 0 ? '0.00' : number_format($sub_total, 2, '.', ','));
        $sales_tax = ($sales_tax == 0 ? '0.00' : number_format($sales_tax, 2, '.', ','));
        $order_total = ($order_total == 0 ? '0.00' : number_format($order_total, 2, '.', ','));
        $payments = ($payments == 0 ? '0.00' : number_format($payments, 2, '.', ','));
        $amount_due = ($amount_due == 0 ? '0.00' : number_format($amount_due, 2, '.', ','));

        $workorder_parts = (isset($wo_parts) ? $wo_parts : '');

        return view('workorders.update', [
            'company' => $company,
            'vendor' => $vendor,
            'workorder_id' => $workorder_id,
            'date_received' => $date_received,
            'po_num' => $po_num,
            'reference_num' => $reference_num,
            'branch' => $branch,
            'woCountry' => $woCountry,
            'countries' => $countries,
            'woBilling_address' => $woBilling_address,
            'all_billing_address' => $all_billing_address,
            'serial_num' => $serial_num,
            'problem_desc' => $problem_desc,
            'date_delivered' => $date_delivered,
            'hardcopy_delivered' => $hardcopy_delivered,
            'contact_person' => $contact_person,
            'customer_info' => $customer_info,
            'postal_address' => $postal_address,
            'company_id' => $company_id,
            'report_name' => $report_name,
            'vendor_id' => $vendor_id,
            'financial' => $financial,
            'discount' => $discount,
            'sales_tax_rate' => $sales_tax_rate,
            'sub_total' => $sub_total,
            'sales_tax' => $sales_tax,
            'order_total' => $order_total,
            'payments' => $payments,
            'amount_due' => $amount_due,

            'workorder_parts' => $workorder_parts,
            'parts_list' => $parts_list,

        ]);
    }

    public function updateWorkorder(Request $request, $workorder_id) {
        // dd($request);
        // $request->validate([
        //     'username' => 'required', 
        //     'password' => 'required',
        // ]);

        $workOrder = Workorder::where('workorder_id', '=', $workorder_id)->first();

        Workorder::where('workorder_id', '=', $workorder_id)->update([
            'date_received' => Carbon::parse($request->date_received)->format('Y-m-d'),
            'po_num' => $request->po_num,
            'reference_num' => $request->reference_num,
            'branch' => $request->branch,
            'country' => $request->country,
            'serial_num' => $request->serial_num,
            'problem_desc' => $request->problem_desc,
            'child_id' => $request->contact_person,
            'report_name' => $request->report_name,
            'discount' => $request->discount,
            'sales_tax_rate' => $request->sales_tax_rate,
            'financial' => $request->financial,
            'hardcopy_delivered' => $request->hardcopy_delivered ? 1 : 0,
            'date_delivered' => Carbon::parse($request->date_delivered)->format('Y-m-d'),
            
        ]);

        CustomerParent::where('customer_id', '=', $workOrder->customer_id)->update([
            'billing_address_id' => $request->billing_address,
            'company_id' => $request->company,
            'postal_address' => $request->postal_address,
            
        ]);


        return redirect()->back()->with('message', 'Workorder updated successfully!');
    }

    public function updateParts(Request $request, $workorder_id) {
        dd($request);

        return redirect()->back()->with('message', 'Part updated successfully!');
    }

    public function getProduct() {
        $part_id = $_GET['part_id'];
        $part_info = Part::where('part_id', '=', $part_id)->select('unit_price')->get();
        return response()->json(array('msg'=> $part_info), 200);
    }
}
