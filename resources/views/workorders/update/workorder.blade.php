@extends('workorders.update.layout')
@section('tabpanel')

<div id="step-workorder" class="tab-pane " role="tabpanel">
      
      <div class="card-body">
       <h4 class="font-20 mb-30">Workorder</h4>
       <form action="{{ url('/workorders/workorder/'.$workorder_id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
         <div class="col-lg-6 border-right">
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">Workorder ID</label>
           </div>
           <div class="col-sm-9">
            <input type="number" class="theme-input-style" readonly name="workorder_id" value="{{ $workorder_id }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold" for="billing_add">Billing Address</label>
           </div>
           <div class="col-sm-9">
            <select class="search-select" name="billing_address">
             <option value="">Select Billing Address</option>
             @if (isset($all_billing_address))
             @foreach ($all_billing_address as $billing_address)
             <option value="{{ $billing_address->billing_address_id }}" 
              {{ $woBilling_address == $billing_address->billing_address_id ? 'selected' : '' }}>
              {{ $billing_address->name }}
             </option>
             @endforeach
             @endif
            </select>
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">Order Date</label>
           </div>
           <div class="col-sm-9">
            <!-- Date Picker -->
            <div class="dashboard-date style--four">
             <span class="input-group-addon">
              <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
             </span>
             <input type="text" class="simple-date-picker" placeholder="Select Date" name="date_received" value="{{ $date_received }}"/>
            </div>
            <!-- End Date Picker -->
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">PO#</label>
           </div>
           <div class="col-sm-9">
            <input type="number" class="theme-input-style" name="po_num" value="{{ $po_num }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">Reference#</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="reference_num" value="{{ $reference_num }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">Branch</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="branch" value="{{ $branch }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">Country</label>
           </div>
           <div class="col-sm-9">
            <select class="search-select" name="country">
             <option value="">Select Country</option>
             @if (isset($countries))
             @foreach ($countries as $country)
             <option value="{{ $country->name }}" {{ $country->name == $woCountry ? 'selected' : '' }}>
              {{ $country->name }}
             </option>
             @endforeach
             @endif
            </select>
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">SECP# (If Any)</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="serial_num" value="{{ $serial_num }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold" for="address">Address</label>
           </div>
           <div class="col-sm-9">
            <textarea id="address" class="theme-input-style style--three" name="problem_desc">{{ $problem_desc }}</textarea>
           </div>
          </div>
          
          <div class="form-row mb-2"> 
           <div class="col-sm-3">
            <label class="font-14 bold">Deliver Date</label>
           </div>
           <div class="col-sm-9">
            <!-- Date Picker -->
            <div class="dashboard-date style--four">
             <span class="input-group-addon">
              <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
             </span>
             <input type="text" class="simple-date-picker" placeholder="Select Date" name="date_delivered" value="{{ $date_delivered }}"/>
            </div>
            <!-- End Date Picker -->
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">Amount Due</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="amount_due" readonly value="{{ $amount_due }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-9 offset-sm-3">
            <div class="d-flex align-items-center">
             <label class="custom-checkbox position-relative mr-2">
              <input type="checkbox" id="hard_copy" name="hardcopy_delivered" {{ $hardcopy_delivered ? 'checked' : '' }} >
              <span class="checkmark"></span>
             </label>
             <label for="hard_copy">Hard Copy Delivered</label>
            </div>
           </div>
          </div>
          
         </div>
         
         <div class="col-lg-6">
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold">Company</label>
           </div>
           <div class="col-sm-9">
            <select class="search-select" name="company_id">
             <option value="">Select Company</option>
             @if (isset($company))
             @foreach ($company as $com)
             <option value="{{ $com->company_id }}" {{ $com->company_id == $company_id ? 'selected' : '' }}>
              {{ $com->name }}
             </option>
             @endforeach
             @endif
            </select>
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Contact Person</label>
           </div>
           <div class="col-sm-9">
            <select class="search-select" name="contact_person">
             <option value="">Select Contact Person</option>
             @if (isset($customer_info))
             @foreach ($customer_info as $contact)
             <option value="{{ $contact->child_id }}" {{ $contact->child_id == $contact_person ? 'selected' : '' }}>
              {{ $contact->first_name.''.$contact->last_name }}
             </option>
             @endforeach
             @endif
            </select>
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3" for="postal_address">Postal Address</label>
           </div>
           <div class="col-sm-9">
            <textarea id="postal_address" class="theme-input-style style--three" name="postal_address">{{ $postal_address }}</textarea>
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Report Name</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="report_name" value="{{ $report_name }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Vendor</label>
           </div>
           <div class="col-sm-9">
            <select class="search-select" name="vendor_id">
             <option value="">Select Vendor</option>
             @if (isset($vendor))
             @foreach ($vendor as $ven)
             <option value="{{ $ven->vendor_id }}" {{ $ven->vendor_id == $vendor_id ? 'selected' : '' }}>
              {{ $ven->name }}
             </option>
             @endforeach
             @endif
            </select>
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Subtotal</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" readonly name="subtotal" 
            value="{{ $sub_total }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Discount %</label>
           </div>
           <div class="col-sm-9">
            <input type="number" class="theme-input-style" name="discount" 
            value="{{ $discount }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-9 offset-sm-3">
            <div class="d-flex align-items-center">
             <label class="custom-checkbox position-relative mr-2">
              <input type="checkbox" id="taxable_invoice" {{ $sales_tax_rate > 0 ? 'checked' : '' }}>
              <span class="checkmark"></span>
             </label>
             <label for="taxable_invoice">Taxable Invoice</label>
            </div>
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Sales Tax %</label>
           </div>
           <div class="col-sm-9">
            <input type="number" class="theme-input-style" name="sales_tax_rate" readonly 
            value="{{ $sales_tax_rate }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Sales Tax</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" readonly name="sales_tax" readonly 
            value="{{ $sales_tax }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Order Total</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="order_total" readonly 
            value="{{ $order_total }}">
           </div>
          </div>
          
          <div class="form-row mb-2">
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Payments</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="" readonly value="{{ $payments }}">
           </div>
          </div>
          
          <div class="form-row mb-2"> 
           <div class="col-sm-3">
            <label class="font-14 bold mb-3">Financial</label>
           </div>
           <div class="col-sm-9">
            <input type="text" class="theme-input-style" name="financial" value="{{ $financial }}">
           </div>
          </div>
          
         </div>
         
         <div class="col-12">
          <div class="form-row">
           <div class="col-12 text-right py-3">
            <button type="submit" class="btn long">Update</button>
           </div>
          </div>
         </div>
         
        </div>
       </form>
      </div>
     </div>

@endsection