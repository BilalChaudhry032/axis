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
use App\Models\PaymentMethod;
use App\Models\Vendor;
use App\Models\Workorder;
use App\Models\WorkorderLabor;
use App\Models\WorkorderPart;
use Carbon\Carbon;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class WorkOrderController extends Controller
{
    public function index(Request $request) {
        
        return view('workorders.index');
    }
    public function getWorkOrders(Request $request) {
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
                return DataTables::of($workOrders)
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
                    <a href="#" class="edit-workorder" id="edit_'.$row->workorder_id.'">Edit</a>
                    <a href="#" class="cancel-workorder" id="cancel_'.$row->workorder_id.'">Cancel</a>
                    <a href="#" class="archive-workorder" id="archive_'.$row->workorder_id.'">Archive</a>
                    </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
        }
        
        public function archiveWorkorder($workorder_id) {
            Workorder::where([
                ['workorder_id', '=', $workorder_id],
                ['archived', '=', 0]
                ])->update([
                    'archived' => 1
                ]);
                
                return redirect()->back()->with('message', 'Workorder archived successfully!');
            }
            
            public function cancelWorkorder($workorder_id) {
                Workorder::where([
                    ['workorder_id', '=', $workorder_id],
                    ['cancelled', '=', 0],
                    ])->update([
                        'cancelled' => 1
                    ]);
                    
                    return redirect()->back()->with('message', 'Workorder cancelled successfully!');
                }
                
                public function createWorkorder() {
                    // dd(session()->get('user-session.uid'));
                    $countries = Country::all();
                    $company = Company::all();
                    $vendor = Vendor::all();
                    
                    return view('workorders.create', [
                        'company' => $company,
                        'countries' => $countries,
                        'vendor' => $vendor,
                    ]);
                }
                public function storeWorkorder(Request $request) {
                    $sales_tax_rate = 0;
                    
                    $customer = CustomerParent::where([
                        ['company_id', '=', $request->company_id],
                        ['billing_address_id', '=', $request->billing_address]
                        ])
                        ->select('customer_id', 'province')->first();
                        if(!$customer) {
                            return Redirect::to(url('/workorders/create'))->with('message', 'Customer not found!');
                        }
                        if($request->taxable){
                            if($customer->province == 'Sindh' || $customer->province == 'Sind'){
                                $sales_tax_rate = 13;
                            }else if($customer->province == 'Punjab'){
                                $sales_tax_rate = 16;
                            }else{
                                $sales_tax_rate = 15;
                            }
                        }
                        
                        $employee_id = session()->get('user-session.uid');
                        
                        
                        $new_workorder = Workorder::insertGetId([
                            'customer_id' => $customer->customer_id,
                            'employee_id' => $employee_id,
                            'po_num' => $request->po_num,
                            'date_received' => Carbon::parse($request->date_received)->format('Y-m-d'),
                            'report_name' => $request->report_name,
                            'serial_num' => $request->serial_num,
                            'problem_desc' => $request->problem_desc,
                            'country' => $request->country,
                            'date_delivered' => Carbon::parse($request->date_delivered)->format('Y-m-d'),
                            'sales_tax_rate' => $sales_tax_rate,
                            'child_id' => $request->contact_person,
                            'reference_num' => $request->reference_num,
                            'branch' => $request->branch ? $request->branch : 0,
                            'vendor_id' => $request->vendor_id,
                            'financial' => $request->financial,
                            'hardcopy_delivered' => $request->hardcopy_delivered ? 1 : 0,
                            'discount' => $request->discount,
                            
                        ]);
                        
                        if($new_workorder && $new_workorder != -1) {
                            $po_num = $new_workorder-1000;
                            Workorder::where('workorder_id', '=', $new_workorder)
                            ->update([
                                'po_num' => $po_num,
                            ]);
                        }
                        
                        return Redirect::to(url('/workorders/workorder/'.$new_workorder.'#step-workorder'))->with('message', 'Workorder created successfully!');
                    }
                    
                    public function editWorkorder($workorder_id) {
                        $workOrder = Workorder::where('workorder_id', '=', $workorder_id)->first();
                        
                        $customer_address = CustomerParent::where('customer_id', '=', $workOrder->customer_id)->first();
                        
                        $customer_info = CustomerChild::where([
                            ['customer_id', '=', $workOrder->customer_id],
                            ['active', '=', 1]
                            ])->get();
                            
                            $countries = Country::all();
                            
                            $company = Company::get();
                            
                            $vendor = Vendor::get();
                            
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
                                ->select('workorder_part.wo_part_id', 'workorder_part.part_id', 'part.name', 'workorder_part.quantity', 'workorder_part.unit_price', 'workorder_part.us_price', 'workorder_part.exchange_rate')
                                ->paginate(10);
                                $parts_list = Part::select('name', 'part_id')->get();
                                
                                // WorkOrder Labors
                                $wo_labors = WorkorderLabor::where('workorder_id', '=', $workOrder->workorder_id)
                                ->join('employee', 'employee.employee_id', '=', 'workorder_labor.employee_id')
                                ->select('workorder_labor.wo_labor_id', 'workorder_labor.employee_id', 'workorder_labor.billable_hours', 'workorder_labor.hourly_rate', 'workorder_labor.comments', 'employee.first_name', 'employee.last_name')
                                ->paginate(10);
                                $employee_list = Employee::select('employee_id', 'first_name', 'last_name')->get();
                                
                                // WorkOrder Payments
                                $wo_payments = Payment::where('workorder_id', '=', $workOrder->workorder_id)
                                ->join('payment_method', 'payment_method.payment_method_id', '=', 'payment.payment_method_id')
                                ->select('payment.payment_id', 'payment.payment_method_id', 'payment.payment_date', 'payment.payment_amount', 'payment.bank_name', 'payment.cheque_num', 'payment.cheque_date', 'payment.cheque_amount', 'payment.received', 'payment_method.name')
                                ->paginate(10);
                                $payment_method_list = PaymentMethod::select('payment_method_id', 'name')->get();
                                // dd($wo_payments);
                                
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
                                
                                $workorder_labors = (isset($wo_labors) ? $wo_labors : '');
                                
                                $workorder_payments = (isset($wo_payments) ? $wo_payments : '');
                                
                                $all_billing_address = CustomerParent::where('company_id', '=', $company_id)
                                ->join('billing_address', 'billing_address.billing_address_id', '=', 'customer_parent.billing_address_id')
                                ->select('billing_address.billing_address_id', 'billing_address.name')->get();
                                
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
                                    
                                    'workorder_labors' => $workorder_labors,
                                    'employee_list' => $employee_list,
                                    
                                    'workorder_payments' => $workorder_payments,
                                    'payment_method_list' => $payment_method_list
                                    
                                ]);
                            }
                            public function updateWorkorder(Request $request, $workorder_id) {
                                
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
                                    'vendor_id' => $request->vendor_id,
                                    
                                ]);
                                
                                CustomerParent::where('customer_id', '=', $workOrder->customer_id)->update([
                                    'billing_address_id' => $request->billing_address,
                                    'company_id' => $request->company_id,
                                    'postal_address' => $request->postal_address,
                                    
                                ]);
                                
                                
                                return Redirect::to(URL::previous() . "#step-workorder")->with('message', 'Workorder updated successfully!');
                            }
                            
                            public function storeParts(Request $request) {
                                // dd($request);
                                WorkorderPart::create([
                                    'workorder_id' => $request->workorder_id,
                                    'part_id' => $request->part_id,
                                    'quantity' => $request->quantity,
                                    'unit_price' => $request->unit_price,
                                    'us_price' => $request->us_price,
                                    'exchange_rate' => $request->exchange_rate
                                ]);
                                
                                return Redirect::to(URL::previous() . "#step-parts")->with('message', 'Part added successfully!');
                            }
                            public function updateParts(Request $request, $wo_part_id) {
                                // dd($request);
                                WorkorderPart::where('wo_part_id', '=', $wo_part_id)->update([
                                    'workorder_id' => $request->workorder_id,
                                    'part_id' => $request->part_id,
                                    'quantity' => $request->quantity,
                                    'unit_price' => $request->unit_price,
                                    'us_price' => $request->us_price,
                                    'exchange_rate' => $request->exchange_rate
                                ]);
                                
                                return Redirect::to(URL::previous() . "#step-parts")->with('message', 'Part updated successfully!');
                            }
                            public function destroyParts($wo_part_id) {
                                WorkorderPart::where('wo_part_id', '=', $wo_part_id)->delete();
                                
                                return Redirect::to(URL::previous() . "#step-parts")->with('message', 'Part deleted successfully!');
                            }
                            
                            public function storeLabors(Request $request) {
                                // dd($request);
                                WorkorderLabor::create([
                                    'workorder_id' => $request->workorder_id,
                                    'employee_id' => $request->technician_id,
                                    'billable_hours' => $request->billable_hours,
                                    'hourly_rate' => $request->hourly_rate,
                                    'comments' => $request->comments
                                ]);
                                
                                return Redirect::to(URL::previous() . "#step-labor")->with('message', 'Labor added successfully!');
                            }
                            public function updateLabors(Request $request, $wo_labor_id) {
                                // dd($request);
                                WorkorderLabor::where('wo_labor_id', '=', $wo_labor_id)->update([
                                    'workorder_id' => $request->workorder_id,
                                    'employee_id' => $request->technician_id,
                                    'billable_hours' => $request->billable_hours,
                                    'hourly_rate' => $request->hourly_rate,
                                    'comments' => $request->comments
                                ]);
                                
                                return Redirect::to(URL::previous() . "#step-labor")->with('message', 'Labor updated successfully!');
                            }
                            public function destroyLabors($wo_labor_id) {
                                WorkorderLabor::where('wo_labor_id', '=', $wo_labor_id)->delete();
                                
                                return Redirect::to(URL::previous() . "#step-labor")->with('message', 'Labor deleted successfully!');
                            }
                            
                            public function storePayments(Request $request) {
                                // dd($request);
                                Payment::create([
                                    'workorder_id'      => $request->workorder_id,
                                    'payment_method_id' => $request->payment_method_id,
                                    'payment_amount'    => $request->payment_amount,
                                    'payment_date'      => Carbon::parse($request->payment_date)->format('Y-m-d'),
                                    'cheque_date'       => Carbon::parse($request->cheque_date)->format('Y-m-d'),
                                    'bank_name'         => $request->bank_name,
                                    'cheque_num'        => $request->cheque_num,
                                    'cheque_amount'     => $request->cheque_amount,
                                    'received'          => $request->received ? 1 : 0
                                ]);
                                
                                return Redirect::to(URL::previous() . "#step-payment")->with('message', 'Payment added successfully!');
                            }
                            public function updatePayments(Request $request, $payment_id) {
                                // dd($request);
                                Payment::where('payment_id', '=', $payment_id)->update([
                                    'workorder_id'      => $request->workorder_id,
                                    'payment_method_id' => $request->payment_method_id,
                                    'payment_amount'    => $request->payment_amount,
                                    'payment_date'      => Carbon::parse($request->payment_date)->format('Y-m-d'),
                                    'cheque_date'       => Carbon::parse($request->cheque_date)->format('Y-m-d'),
                                    'bank_name'         => $request->bank_name,
                                    'cheque_num'        => $request->cheque_num,
                                    'cheque_amount'     => $request->cheque_amount,
                                    'received'          => $request->received ? 1 : 0
                                ]);
                                
                                return Redirect::to(URL::previous() . "#step-payment")->with('message', 'Payment updated successfully!');
                            }
                            public function destroyPayments($payment_id) {
                                Payment::where('payment_id', '=', $payment_id)->delete();
                                
                                return Redirect::to(URL::previous() . "#step-payment")->with('message', 'Payment deleted successfully!');
                            }
                            
                            public function workorderInvoice($workorder_id) {
                                
                                $sql = "select t.workorder_id, t.child_id, t.customer_id, t.employee_id, t.po_num, DATE_FORMAT(t.date_received, '%d/%m/%Y') as date_received, t.report_name, t.serial_num, t.problem_desc, t.country, DATE_FORMAT(t.date_delivered, '%d/%m/%Y') as date_delivered, t.sales_tax_rate, b.name as bname, c.name as cname, t.reference_num from workorder t, customer_parent p, company c, billing_address b where t.workorder_id=$workorder_id and t.customer_id=p.customer_id and p.company_id=c.company_id and p.billing_address_id=b.billing_address_id";
                                $row = DB::select($sql)[0];

                                $sql = "select * from customer_parent p, customer_child c where p.customer_id=".$row->customer_id." and p.customer_id=c.customer_id and c.child_id=".$row->child_id;
                                $customer = DB::select($sql)[0];

                                $sql = "select p.name, wp.quantity, wp.us_price, wp.exchange_rate, wp.unit_price from workorder_part wp, part p where wp.workorder_id=$workorder_id and wp.part_id=p.part_id";
                                $products = DB::select($sql);
                                // dd($products);
                                
                                $sql = "select sum(p.quantity*p.unit_price) as sub_total from workorder_part p, part pa where p.workorder_id=$workorder_id and p.part_id=pa.part_id";
                                $sub_total = DB::select($sql)[0];
                                $sub_total = $sub_total->sub_total;
                                // dd($sub_total);
                                
                                $payments = Payment::where([
                                    ['workorder_id', '=', $workorder_id],
                                    ['received', '=', 1]
                                    ])
                                    ->sum('payment_amount');

                                $date_delivered = (isset($row) ? $row->date_delivered : '');
                                $customer_id = (isset($row) ? $row->customer_id : '');
                                $workorder_id = (isset($row) ? $row->workorder_id : '');
                                $date_received = (isset($row) ? $row->date_received : '');
                                $po_num = (isset($row) ? $row->po_num : '');
                                $cname = (isset($row) ? $row->cname : '');
                                $report_name = (isset($row) ? $row->report_name : '');
                                $problem_desc = (isset($row) ? $row->problem_desc : '');
                                $country = (isset($row) ? $row->country : '');
                                $reference_num = (isset($row) ? $row->reference_num : '');

                                $province = (isset($customer) ? $customer->province : '');
                                $last_name = (isset($customer) ? $customer->last_name : '');
                                $contact_title = (isset($customer) ? $customer->contact_title : '');
                                $postal_address = (isset($customer) ? $customer->postal_address : '');
                                $city = (isset($customer) ? $customer->city : '');
                                $telephone = (isset($customer) ? $customer->telephone : '');
                                $extension = (isset($customer) ? $customer->extension : '');
                                $direct = (isset($customer) ? $customer->direct : '');


                                $sales_tax_rate = (isset($row) ? $row->sales_tax_rate : '');
                                
                                $amount_due = $sub_total - $payments;
                                $sales_tax = $sub_total*$sales_tax_rate/100;
                                $order_total = $sub_total+$sales_tax;
                                $amount_due += $sales_tax;
                                
                                $sub_total = ($sub_total == 0 ? '0' : number_format($sub_total, 0));
                                $sales_tax = ($sales_tax == 0 ? '0' : number_format($sales_tax, 0));
                                $order_total = ($order_total == 0 ? '0' : number_format($order_total, 0));
                                $payments = ($payments == 0 ? '0' : number_format($payments, 0));
                                $amount_due = ($amount_due == 0 ? '0' : number_format($amount_due, 0));

                                return view('reports.invoice', [
                                    'workorder_id' => $workorder_id,
                                    'province' => $province,
                                    'date_delivered' => $date_delivered,
                                    'last_name' => $last_name,
                                    'customer_id' => $customer_id,
                                    'contact_title' => $contact_title,
                                    'date_received' => $date_received,
                                    'po_num' => $po_num,
                                    'cname' => $cname,
                                    'report_name' => $report_name,
                                    'postal_address' => $postal_address,
                                    'city' => $city,
                                    'problem_desc' => $problem_desc,
                                    'telephone' => $telephone,
                                    'extension' => $extension,
                                    'country' => $country,
                                    'direct' => $direct,
                                    'reference_num' => $reference_num,

                                    'products' => $products,

                                    'sub_total' => $sub_total,
                                    'sales_tax_rate' => $sales_tax_rate,
                                    'sales_tax' => $sales_tax,
                                    'order_total' => $order_total,
                                    'payments' => $payments,

                                ]);
                            }
                            
                            // AJAX Functions
                            public function getProduct() {
                                $part_id = $_GET['part_id'];
                                $part_info = Part::where('part_id', '=', $part_id)->select('unit_price')->get();
                                return response()->json(['msg'=> $part_info], 200);
                            }
                            public function getCompanyAddresses() {
                                $wo_company_id = $_GET['wo_company_id'];
                                
                                $company_billing_addresses = CustomerParent::where('company_id', '=', $wo_company_id)
                                ->join('billing_address', 'billing_address.billing_address_id', '=', 'customer_parent.billing_address_id')
                                ->select('billing_address.billing_address_id', 'billing_address.name')->get();
                                
                                return response()->json(['response'=> $company_billing_addresses], 200);
                            }
                            public function getCompanyPersons() {
                                $wo_company_id = $_GET['wo_company_id'];
                                $wo_billing_address_id = $_GET['wo_billing_address_id'];
                                
                                $company_persons = CustomerParent::where([
                                    ['company_id', '=', $wo_company_id],
                                    ['billing_address_id', '=', $wo_billing_address_id]
                                    ])
                                    ->join('customer_child', 'customer_child.customer_id', '=', 'customer_parent.customer_id')
                                    ->select('customer_child.child_id', 'customer_child.first_name', 'customer_child.last_name')->get();
                                    
                                    $postal_address = CustomerParent::where([
                                        ['company_id', '=', $wo_company_id],
                                        ['billing_address_id', '=', $wo_billing_address_id]
                                        ])
                                        ->select('postal_address')->first();
                                        
                                        return response()->json(['response'=> $company_persons, $postal_address], 200);
                                    }
                                    public function getCompanyHistory() {
                                        $wo_company_id = $_GET['wo_company_id'];
                                        $wo_billing_address_id = $_GET['wo_billing_address_id'];
                                        
                                        $company_history = CustomerParent::where([
                                            ['company_id', '=', $wo_company_id],
                                            ['billing_address_id', '=', $wo_billing_address_id]
                                            ])
                                            ->join('workorder', 'workorder.customer_id', '=', 'customer_parent.customer_id')
                                            ->select('workorder.po_num', 'workorder.report_name', DB::raw('DATE_FORMAT(workorder.date_received, "%d-%m-%Y") as date_received'), DB::raw('DATE_FORMAT(workorder.date_delivered, "%d-%m-%Y") as date_delivered'))->get();
                                            
                                            $company_name = Company::where('company_id', '=', $wo_company_id)->select('name')->first();
                                            
                                            return response()->json(array(
                                                'response' => $company_history,
                                                'company_name' => $company_name
                                            ), 200);
                                        }
                                        
                                    }
                                    