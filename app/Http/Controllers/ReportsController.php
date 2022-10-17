<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\CustomerChild;
use App\Models\Part;
use App\Models\Workorder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index() {
        $company_list = Company::all();
        $country_list = Country::all();
        $part_list = Part::all();
        $city_list = City::all();
        return view('reports.index', [
            'company_list' => $company_list,
            'country_list' => $country_list,
            'part_list' => $part_list,
            'city_list' => $city_list
        ]);
    }
    
    public function getMonthlySale(Request $request) {
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            // dd($request);
            $company = "";
            if(isset($request->company_id) && strlen($request->company_id) > 0) {
                $company = Company::where('company_id', '=', $request->company_id)->select('name')->first();
                $company = $company->name;
            }
            $billing_address = "";
            if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
                $billing_address = BillingAddress::where('billing_address_id', '=', $request->billing_address_id)
                ->select('name')->first();
                $billing_address =$billing_address->name;
            }
            $child = "";
            if(isset($request->child_id) && strlen($request->child_id) > 0) {
                $child = CustomerChild::where('child_id', '=', $request->child_id)
                ->select('last_name')->first();
                $child = $child->last_name;
            }
            $part = "";
            if(isset($request->part_id) && strlen($request->part_id) > 0) {
                $part = Part::where('part_id', '=', $request->part_id)->select('name')->first();
                if($part) {
                    $part = " ($part->name)";
                }
            }
            $city = "";
            $city_name = "";
            if(isset($request->city_id) && strlen($request->city_id) > 0) {
                $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
                $city = $city->name;
                if($city) {
                    $city_name = " ($city)";
                }
            }

            $result = Workorder::join('workorder_part', 'workorder_part.workorder_id', '=', 'workorder.workorder_id')
            ->join('customer_parent', 'customer_parent.customer_id', '=', 'workorder.customer_id')
            ->where([
                ['workorder.cancelled', '=', 0],
                ['workorder.archived', '=', 0]
            ])->whereBetween('workorder.date_received', [
                Carbon::parse($request->from_date)->format('Y-m-d'),
                Carbon::parse($request->to_date)->format('Y-m-d'),
            ])->select(
                DB::raw('DATE_FORMAT(workorder.date_received, "%M %Y") as month'),
                DB::raw('sum(workorder_part.unit_price*workorder_part.quantity) as total'),
                DB::raw('ifnull(sum(workorder.sales_tax_rate), 0) as sales_tax'),
            )
            ->orderBy('workorder.date_received')
            ->groupby('month');
            
            if(isset($request->company_id) && strlen($request->company_id) > 0) {
                $result = $result->where('customer_parent.company_id', '=', $request->company_id);
            }
            if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
                $result = $result->where('customer_parent.billing_address_id', '=', $request->billing_address_id);
            }
            if(isset($request->child_id) && strlen($request->child_id) > 0) {
                $result = $result->where('workorder.child_id', '=', $request->child_id);
            }
            if(isset($request->part_id) && strlen($request->part_id) > 0) {
                $result = $result->where('workorder_part.part_id', '=', $request->part_id);
            }
            if(isset($city) && strlen($city) > 0) {
                $result = $result->where('customer_parent.city', '=', $city);
            }
            $result = $result->get();

            // dd($result);

            return view('reports.monthlySale', [
                'from_date' => Carbon::parse($request->from_date)->format('d/m/Y'),
                'to_date' => Carbon::parse($request->to_date)->format('d/m/Y'),
                'company' => $company,
                'billing_address' => $billing_address,
                'child' => $child,
                'part' => $part,
                'city_name' => $city_name,
                'result' => $result
            ]);
        }
        return redirect()->back()->with('error', 'From Date and To Date Required!');
    }

    public function getReceivable(Request $request) {
        // dd($request);
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }

        $company = "";
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $company = Company::where('company_id', '=', $request->company_id)->select('name')->first();
            $company = $company->name;
        }
        $billing_address = "";
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $billing_address = BillingAddress::where('billing_address_id', '=', $request->billing_address_id)
            ->select('name')->first();
            $billing_address =$billing_address->name;
        }
        $child = "";
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $child = CustomerChild::where('child_id', '=', $request->child_id)
            ->select('last_name')->first();
            $child = $child->last_name;
        }
        $part = "";
        if(isset($request->part_id) && strlen($request->part_id) > 0) {
            $part = Part::where('part_id', '=', $request->part_id)->select('name')->first();
            if($part) {
                $part = " ($part->name)";
            }
        }
        $city = "";
        $city_name = "";
        if(isset($request->city_id) && strlen($request->city_id) > 0) {
            $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
            $city = $city->name;
            if($city) {
                $city_name = " ($city)";
            }
        }

        $sql1 = "select DISTINCT w.customer_id, c.name as cname, b.name as bname, cp.province, cp.city, cp.telephone, cp.fax from workorder w, customer_parent cp, billing_address b, company c where w.cancelled=0 and w.archived=0 and w.payment_received=0";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql1 .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $sql1 .= " and cp.company_id=$request->company_id";
        }
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $sql1 .= " and cp.billing_address_id=$request->billing_address_id";
        }
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $sql1 .= " and w.child_id=$request->child_id";
        }
        if(isset($city) && strlen($city) > 0) {
            $sql1 .= " and cp.city='$city'";
        }
        $sql1 .= " and w.customer_id=cp.customer_id and cp.billing_address_id=b.billing_address_id and cp.company_id=c.company_id order by 2, 3";
        $top_result = DB::select($sql1);

        $result = [];
        foreach ($top_result as $key => $top) {
            $temp = "";
            if(isset($request->part_id) && strlen($request->part_id) > 0) {
                $temp = " wp.part_id=$request->part_id and ";
            }

            $sql = "select DISTINCT w.workorder_id, w.sales_tax_rate, w.branch, w.reference_num, cc.last_name, DATE_FORMAT(w.date_delivered, '%d/%m/%Y') as date_delivered, w.report_name, (select sum(wp.quantity*wp.unit_price) from workorder_part wp, part p where $temp wp.workorder_id=w.workorder_id and wp.part_id=p.part_id)-(select ifnull(sum(pay.payment_amount), 0) from payment pay where pay.workorder_id=w.workorder_id and pay.received=1) as amount from workorder w , customer_child cc, customer_parent cp, billing_address b, company c, workorder_part wp where w.customer_id=".$top->customer_id." and w.cancelled=0 and w.archived=0 and w.payment_received=0 and w.pending=0";
            if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
                $sql .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
            }
            if(isset($request->company_id) && strlen($request->company_id) > 0) {
                $sql .= " and cp.company_id=$request->company_id";
            }
            if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
                $sql .= " and cp.billing_address_id=$request->billing_address_id";
            }
            if(isset($request->child_id) && strlen($request->child_id) > 0) {
                $sql .= " and w.child_id=$request->child_id";
            }
            if(isset($request->part_id) && strlen($request->part_id) > 0) {
                $sql .= " and wp.part_id=$request->part_id";
            }
            $sql .= " and w.child_id=cc.child_id and w.customer_id=cp.customer_id and cp.billing_address_id=b.billing_address_id and cp.company_id=c.company_id and w.workorder_id=wp.workorder_id order by w.branch, 1 ";

            $result[$key] = DB::select($sql);
        }

        return view('reports.receivable', [
            'date' => $date,
            'company' => $company,
            'billing_address' => $billing_address,
            'child' => $child,
            'part' => $part,
            'city_name' => $city_name,
            'top_result' => $top_result,
            'result' => $result
        ]);
    }

    public function getPending(Request $request) {
        // dd('asdf');
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }

        $company = "";
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $company = Company::where('company_id', '=', $request->company_id)->select('name')->first();
            $company = $company->name;
        }
        $billing_address = "";
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $billing_address = BillingAddress::where('billing_address_id', '=', $request->billing_address_id)
            ->select('name')->first();
            $billing_address =$billing_address->name;
        }
        $child = "";
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $child = CustomerChild::where('child_id', '=', $request->child_id)
            ->select('last_name')->first();
            $child = $child->last_name;
        }
        $city = "";
        $city_name = "";
        if(isset($request->city_id) && strlen($request->city_id) > 0) {
            $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
            $city = $city->name;
            if($city) {
                $city_name = " ($city)";
            }
        }

        $sql = "select w.po_num, c.name, ch.last_name, p.telephone, DATE_FORMAT(w.date_received, '%d/%m/%Y') as date_received, w.report_name, v.name as vname from workorder w, customer_parent p, customer_child ch, company c, vendor v where w.cancelled=0 and w.archived=0 and w.date_delivered is null";
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $sql .= " and p.company_id=$request->company_id";
        }
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $sql .= " and p.billing_address_id=$request->billing_address_id";
        }
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $sql .= " and w.child_id=$request->child_id";
        }
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        if(isset($city) && strlen($city) > 0) {
            $sql .= " and p.city='$city'";
        }
        $sql .= " and w.child_id=ch.child_id and ch.customer_id=p.customer_id and p.customer_id=ch.customer_id and p.company_id=c.company_id and w.vendor_id=v.vendor_id order by w.date_received desc, 1, 2";
        $result = DB::select($sql);

        return view('reports.pending', [
            'date' => $date,
            'company' => $company,
            'billing_address' => $billing_address,
            'child' => $child,
            'city_name' => $city_name,
            'result' => $result
        ]);
    }

    public function getProduct(Request $request) {
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }

        $company = "";
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $company = Company::where('company_id', '=', $request->company_id)->select('name')->first();
            $company = $company->name;
        }
        $billing_address = "";
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $billing_address = BillingAddress::where('billing_address_id', '=', $request->billing_address_id)
            ->select('name')->first();
            $billing_address =$billing_address->name;
        }
        $child = "";
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $child = CustomerChild::where('child_id', '=', $request->child_id)
            ->select('last_name')->first();
            $child = $child->last_name;
        }
        $part = "";
        if(isset($request->part_id) && strlen($request->part_id) > 0) {
            $part = Part::where('part_id', '=', $request->part_id)->select('name')->first();
            if($part) {
                $part = " ($part->name)";
            }
        }
        $city = "";
        $city_name = "";
        if(isset($request->city_id) && strlen($request->city_id) > 0) {
            $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
            $city = $city->name;
            if($city) {
                $city_name = " ($city)";
            }
        }

        $cond = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $cond .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $cond .= " and w.child_id=$request->child_id";
        }
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $cond .= " and cp.company_id=$request->company_id";
        }
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $cond .= " and cp.billing_address_id=$request->billing_address_id";
        }
        if(isset($city) && strlen($city) > 0) {
            $cond .= " and cp.city='$city'";
        }
        $sql = "select p.name, (select sum(wp.quantity) from workorder_part wp, workorder w, customer_parent cp, customer_child cc where wp.part_id=p.part_id and wp.workorder_id=w.workorder_id $cond and w.customer_id=cp.customer_id and w.child_id=cc.child_id) as quantity, (select sum(wp.quantity*wp.unit_price) from workorder_part wp, workorder w, customer_parent cp, customer_child cc where wp.part_id=p.part_id and wp.workorder_id=w.workorder_id $cond and w.customer_id=cp.customer_id and w.child_id=cc.child_id) as price from part p";
        if(isset($request->part_id) && strlen($request->part_id) > 0) {
            $sql .= " where p.part_id=$request->part_id";
        }
        
        $result = DB::select($sql);

        return view('reports.product', [
            'date' => $date,
            'company' => $company,
            'billing_address' => $billing_address,
            'child' => $child,
            'part' => $part,
            'city_name' => $city_name,
            'result' => $result
        ]);
    }

    public function getTax(Request $request) {
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }
        $city = "";
        $city_name = "";
        if(isset($request->city_id) && strlen($request->city_id) > 0) {
            $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
            $city = $city->name;
            if($city) {
                $city_name = " ($city)";
            }
        }

        $sql = "select * from (select w.workorder_id, w.sales_tax_rate, c.name, cc.last_name, DATE_FORMAT(p.payment_date, '%d/%m/%Y') as payment_date, wp.quantity*wp.unit_price as amount_due, p.payment_amount,cp.province, (wp.quantity*wp.unit_price)-p.payment_amount as tax from workorder w, customer_parent cp, company c, customer_child cc, payment p, workorder_part wp, part pa where w.payment_received=1";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        $sql .= " and w.customer_id=cp.customer_id";
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $sql .= " and cp.billing_address_id=$request->billing_address_id";
        }
        $sql .= " and cp.company_id=c.company_id";
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $sql .= " and c.company_id=$request->company_id ";
        }
        if(isset($city) && strlen($city) > 0) {
            $sql .= " and cp.city='$city'";
        }
        $sql .= " and w.child_id=cc.child_id and w.workorder_id=p.workorder_id and w.workorder_id=wp.workorder_id and wp.part_id=pa.part_id) as temp where temp.tax > 50 or temp.payment_amount = 2";
        
        $result = DB::select($sql);

        return view('reports.tax', [
            'date' => $date,
            'city_name' => $city_name,
            'result' => $result
        ]);
    }

    public function getStat(Request $request) {
        // dd($request->from_date);
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }
        $city = "";
        $city_name = "";
        if(isset($request->city_id) && strlen($request->city_id) > 0) {
            $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
            $city = $city->name;
            if($city) {
                $city_name = " ($city)";
            }
        }
        $company = "";
        $company_name = "";
        if(isset($company_id) && strlen($company_id) > 0) {
            $company = Company::where('company_id', '=', $request->company_id)->select('name')->first();
            $company = $company->name;
            if($company) {
                $company_name = " ($company)";
            }
        }

        $sql = "select w.workorder_id, w.po_num, cp.billing_address_id, c.name, cc.last_name, w.date_received, w.report_name, w.reference_num, (select sum(wp.quantity*wp.unit_price) from workorder_part wp where wp.workorder_id=w.workorder_id) as amount_due, (select sum(p.payment_amount) from payment p where p.workorder_id=w.workorder_id) as payment_received from workorder w, customer_parent cp, company c, customer_child cc where w.customer_id=cp.customer_id and cp.company_id=c.company_id and w.child_id=cc.child_id";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        if(isset($city) && strlen($city) > 0) {
            $sql .= " and cp.city='$city'";
        }
        if(isset($company) && strlen($company) > 0) {
            $sql .= " and c.name='$company'";
        }
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $sql .= " and cp.billing_address_id=$request->billing_address_id";
        }
        
        $result = DB::select($sql);
        // dd($result);

        return view('reports.stat', [
            'date' => $date,
            'city_name' => $city_name,
            'company_name' => $company_name,
            'result' => $result
        ]);
    }

    public function getBranch(Request $request) {
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }
        $city = "";
        $city_name = "";
        if(isset($request->city_id) && strlen($request->city_id) > 0) {
            $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
            $city = $city->name;
            if($city) {
                $city_name = " ($city)";
            }
        }

        $cond = "";
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $cond = " and c.company_id=$request->company_id ";
        }
        if(isset($city) && strlen($city) > 0) {
            $cond .= " and cp.city='$city'";
        }
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $cond .= " and cp.billing_address_id='$request->billing_address_id'";
        }
        $sql = "select w.workorder_id, w.po_num, DATE_FORMAT(w.date_received, '%d/%m/%Y') as date_received, w.report_name, c.name, cc.last_name from workorder w, customer_parent cp, customer_child cc, company c where w.cancelled=0 and w.archived=0";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        $sql .= "  and w.workorder_id not in (select distinct p.workorder_id from payment p) and w.customer_id=cp.customer_id and cp.company_id=c.company_id $cond and w.child_id=cc.child_id and w.workorder_id in (select distinct wp.workorder_id from workorder_part wp) order by 1";
        
        $result = DB::select($sql);

        return view('reports.branch', [
            'date' => $date,
            'city_name' => $city_name,
            'result' => $result
        ]);
    }

    public function getOrderList(Request $request) {
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }

        $company = "";
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $company = Company::where('company_id', '=', $request->company_id)->select('name')->first();
            $company = $company->name;
        }
        $billing_address = "";
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $billing_address = BillingAddress::where('billing_address_id', '=', $request->billing_address_id)
            ->select('name')->first();
            $billing_address =$billing_address->name;
        }
        $child = "";
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $child = CustomerChild::where('child_id', '=', $request->child_id)
            ->select('last_name')->first();
            $child = $child->last_name;
        }
        $part = "";
        if(isset($request->part_id) && strlen($request->part_id) > 0) {
            $part = Part::where('part_id', '=', $request->part_id)->select('name')->first();
            if($part) {
                $part = " ($part->name)";
            }
        }
        $city = "";
        $city_name = "";
        if(isset($request->city_id) && strlen($request->city_id) > 0) {
            $city = City::where('city_id', '=', $request->city_id)->select('name')->first();
            $city = $city->name;
            if($city) {
                $city_name = " ($city)";
            }
        }

        $sql = "select DISTINCT w.customer_id, c.name as cname, b.name as bname, cp.city, cp.telephone, cp.fax from workorder w, customer_parent cp, billing_address b, company c where w.cancelled=0";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        if(isset($request->company_id) && strlen($request->company_id) > 0) {
            $sql .= " and cp.company_id=$request->company_id";
        }
        if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
            $sql .= " and cp.billing_address_id=$request->billing_address_id";
        }
        if(isset($request->child_id) && strlen($request->child_id) > 0) {
            $sql .= " and w.child_id=$request->child_id";
        }
        if(isset($city) && strlen($city) > 0) {
            $sql .= " and cp.city='$city'";
        }
        $sql .= " and w.customer_id=cp.customer_id and cp.billing_address_id=b.billing_address_id and cp.company_id=c.company_id order by 2, 3";
        $top_result = DB::select($sql);

        foreach($top_result as $key => $top) {
            $temp = "";
            if(isset($request->part_id) && strlen($request->part_id) > 0) {
                $temp = " wp.part_id=$request->part_id and ";
            }
            $sql = "select DISTINCT w.workorder_id, w.reference_num, cc.last_name, DATE_FORMAT(w.date_delivered, '%d/%m/%Y') as date_delivered, w.report_name from workorder w, customer_child cc, customer_parent cp, billing_address b, company c, workorder_part wp where w.customer_id=".$top->customer_id." and w.cancelled=0";
            if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
                $sql .= " and w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
            }
            if(isset($request->company_id) && strlen($request->company_id) > 0) {
                $sql .= " and cp.company_id=$request->company_id";
            }
            if(isset($request->billing_address_id) && strlen($request->billing_address_id) > 0) {
                $sql .= " and cp.billing_address_id=$request->billing_address_id";
            }
            if(isset($request->child_id) && strlen($request->child_id) > 0) {
                $sql .= " and w.child_id=$request->child_id";
            }
            if(isset($request->part_id) && strlen($request->part_id) > 0) {
                $sql .= " and wp.part_id=$request->part_id";
            }
            $sql .= " and w.child_id=cc.child_id and w.customer_id=cp.customer_id and cp.billing_address_id=b.billing_address_id and cp.company_id=c.company_id and w.workorder_id=wp.workorder_id order by 3, 1";
            $result[$key] = DB::select($sql);
        }
        
        
        return view('reports.orderList', [
            'date' => $date,
            'company' => $company,
            'billing_address' => $billing_address,
            'child' => $child,
            'part' => $part,
            'city_name' => $city_name,
            'top_result' => $top_result,
            'result' => $result
        ]);
    }

    public function getVendor(Request $request) {
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }

        $sql = "select w.po_num, w.report_name, w.problem_desc, w.country, v.name from workorder w, vendor v where";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql .= " w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        else {
            $sql .= " w.date_received=CURDATE()";
        }
        $sql .= " and w.vendor_id=v.vendor_id and v.name like '%Offline'";
        
        $result = DB::select($sql);
        return view('reports.vendor', [
            'date' => $date,
            'result' => $result
        ]);
    }

    public function getReportName(Request $request) {
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }

        $sql = "select w.po_num, w.report_name, date_format(w.date_received, '%d/%m/%Y') as date_received, w.financial from workorder w where report_name like '%$request->report_name%'";
        $result = DB::select($sql);
        
        return view('reports.reportName', [
            'date' => $date,
            'result' => $result
        ]);
    }

    public function getCountry(Request $request) {
        $date = "";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $from_date = Carbon::parse($request->from_date)->format('d/m/Y');
            $to_date = Carbon::parse($request->to_date)->format('d/m/Y');
            $date = "($from_date to $to_date)";
        }

        $sql = "select w.po_num, w.report_name, w.problem_desc, w.country, v.name from workorder w, vendor v where";
        if(isset($request->from_date) && strlen($request->from_date) > 0 && isset($request->to_date) && strlen($request->to_date) > 0) {
            $sql .= " w.date_received between STR_TO_DATE('$request->from_date', '%d-%m-%Y') and STR_TO_DATE('$request->to_date', '%d-%m-%Y')";
        }
        else {
            $sql .= " w.date_received=CURDATE()";
        }
        $sql .= " and w.vendor_id=v.vendor_id and v.name like '%Offline'";
        if(isset($request->country_id) && strlen($request->country_id) > 0) {
            $sqli = "select c.name from country c where c.country_id = '$request->country_id'";
            $country_name = DB::select($sqli);
            $sql .= "and w.country = '$country_name'  ";
        }
        $sql.="order by w.country asc";
        $result = DB::select($sql);

        return view('reports.country', [
            'date' => $date,
            'result' => $result
        ]);
    }
}
