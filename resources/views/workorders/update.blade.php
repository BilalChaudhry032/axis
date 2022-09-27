@extends('layouts.master')

@section('pageCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
<link href="{{ asset('assets/plugins/jquery-smartwizard/smart_wizard_all.min.css') }}" rel="stylesheet" type="text/css" />

<style>
 .main-content #smartwizard .nav li a {
  height: 50px;
 }
 .sw-theme-arrows>.nav .nav-link {
  color: #aeaeae;
  border-color: #f8f8f8;
  background: #fafafa;
  background: -moz-linear-gradient(left,#fafafa 0,#dbf7e8 100%);
  background: -webkit-linear-gradient(left,#fafafa 0,#dbf7e8 100%);
  background: linear-gradient(to right,#fafafa 0,#dbf7e8 100%);
  /* cursor: not-allowed; */
 }
 input[readonly] {
  cursor: not-allowed;
 }
</style>

@endsection

@section('content')
<div class="row">
 <div class="col-xl-12">
  <div class="card mb-30">
   <h4 class="font-20 mb-30 mt-30 mx-4">Edit Workorder</h4>
   
   <div id="smartwizard">
    <ul class="nav">
     <li>
      <a class="nav-link" href="#step-workorder" id="step-workorder-btn">
       Workorder
      </a>
     </li>
     <li>
      <a class="nav-link" href="#step-parts" id="step-parts-btn">
       Parts
      </a>
     </li>
     <li>
      <a class="nav-link" href="#step-report" id="step-report-btn">
       Report
      </a>
     </li>
     <li>
      <a class="nav-link" href="#step-labor" id="step-labor-btn">
       Labor
      </a>
     </li>
     <li>
      <a class="nav-link" href="#step-payment" id="step-payment-btn">
       Payment
      </a>
     </li>
     <li>
      <a class="nav-link" href="#step-history" id="step-history-btn">
       History
      </a>
     </li>
     <li></li>
    </ul>
    
    <div class="tab-content">
     
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
            <label class="font-14 bold">Company {{$company_id}}</label>
           </div>
           <div class="col-sm-9">
            <select class="search-select" name="company">
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
            <select class="search-select" name="company">
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
     
     <div id="step-parts" class="tab-pane" role="tabpanel">
      <div class="card-body">
	   <div class="d-flex justify-content-between">
			<div class="title-content">
				<h4 class="font-20 mb-2">Parts</h4>
			</div>
			<div>
				<a href="" data-toggle="modal" data-target="#part_add_modal" type="button" class="btn btn-secondary px-3 py-2">Add Part</a>
			</div>
		</div>
       
       <div class="table-responsive">
        <table class="text-nowrap">
         <thead>
          <tr>
           <th>SR#</th>
           <th>Product</th>
           <th>Quantity</th>
           <th>Unit Price</th>
           <th>US$</th>
           <th>Ex. Rate</th>
           <th>Actions</th>
          </tr>
         </thead>
         <tbody>
          @if (isset($workorder_parts))
          @foreach ($workorder_parts as $workorder_part)
          <tr>
           <td>
            {{ (($workorder_parts->currentPage() -1) * $workorder_parts->perPage()) + $loop->index + 1 }}
           </td>
           <td>{{ $workorder_part->name }}</td>
           <td>{{ $workorder_part->quantity }}</td>
           <td>{{ $workorder_part->unit_price }}</td>
           <td>{{ $workorder_part->us_price }}</td>
           <td>{{ $workorder_part->exchange_rate }}</td>
           <td>
            <a href="" data-toggle="modal" data-target="#part_edit_modal_{{ $workorder_part->wo_part_id }}">Edit</a>
           </td>
          </tr>
          <!-- Modal Edit Part -->
          <div class="modal fade" id="part_edit_modal_{{ $workorder_part->wo_part_id }}" tabindex="-1" role="dialog" aria-labelledby="part_edit_label" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
             <div class="modal-header">
              <h5 class="modal-title" id="part_edit_label">Update Part</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
              </button>
             </div>
             <form action="{{ url('/workorders/parts/'.$workorder_id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="modal-body">
               <div class="row">
                <div class="col-12">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label d-block">Product</label>
                  <select class="search-select-w-100" name="name" id="wo_products">
					<option value="">Select Product</option>
					@if (isset($parts_list))
					@foreach ($parts_list as $part)
					<option value="{{ $part->part_id }}" {{ ($workorder_part->part_id == $part->part_id) ? 'selected' : '' }} >
					{{ $part->name }}
					</option>

					@endforeach
					@endif
				  </select>
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Quantity</label>
                  <input class="form-control" required name="quantity" id="wo_products_qty" value="{{ $workorder_part->quantity }}">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Unit Price</label>
                  <input class="form-control" required name="unit_price" id="wo_products_up" value="{{ $workorder_part->unit_price }}">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">US$</label>
                  <input class="form-control" required name="us_price" value="{{ $workorder_part->us_price }}">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Ex. Rate</label>
                  <input class="form-control" required name="exchange_rate" value="{{ $workorder_part->exchange_rate }}">
                 </div>
                </div>
               </div>
               
              </div>
              <div class="modal-footer">
               <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
             </form>
            </div>
           </div>
          </div>
          @endforeach
          @endif
         </tbody>
        </table>
       </div>
      </div>
      {!! $workorder_parts->links('pagination::bootstrap-5') !!}
     </div> 
     
     <div id="step-report" class="tab-pane" role="tabpanel">
      <div class="card-body">
       <h4 class="font-20 mb-30">Report</h4>
       
      </div>
     </div>
     
     <div id="step-labor" class="tab-pane" role="tabpanel">
      <div class="card-body">
       <h4 class="font-20 mb-30">Labor</h4>
       
      </div>
     </div>
     
     <div id="step-payment" class="tab-pane" role="tabpanel">
      <div class="card-body">
       <h4 class="font-20 mb-30">Payment</h4>
       
      </div>
     </div>
     
     <div id="step-history" class="tab-pane" role="tabpanel">
      <div class="card-body">
       <h4 class="font-20 mb-30">History</h4>
       
      </div>
     </div>
     
    </div>
    
   </div>
   
  </div>
  
 </div>
</div>

<!-- Modal Add Part  -->
<div class="modal fade" id="part_add_modal" tabindex="-1" role="dialog" aria-labelledby="part_add_label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="part_add_label">Add Part In Workorder</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			</div>
			<form action="{{ url('/parts') }}" method="POST">
				@csrf
				<div class="modal-body">
				<div class="row">
                <div class="col-12">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label d-block">Product</label>
                  <select class="search-select-w-100" name="name" id="add-product">
					<option value="">Select Product</option>
					@if (isset($parts_list))
					@foreach ($parts_list as $part)
					<option value="{{ $part->part_id }}">
					{{ $part->name }}
					</option>

					@endforeach
					@endif
				  </select>
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Quantity</label>
                  <input class="form-control" type="number" min="1" required name="quantity">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Unit Price</label>
                  <input class="form-control" required name="unit_price" id="unit_price">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">US$</label>
                  <input class="form-control" required name="us_price">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Ex. Rate</label>
                  <input class="form-control" required name="exchange_rate">
                 </div>
                </div>
               </div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Add Part</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@section('pageScript')
<script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>

<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>

<script src="{{ asset('assets/plugins/jquery-smartwizard/jquery.smartWizard.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-smartwizard/custom-smartWizard.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.steps/custom-jquery-step.js') }}"></script>

<script>
 $(document).ready(function() {
  
  $('.simple-date-picker').datepicker({
   language: 'en',
   dateFormat: 'dd-mm-yyyy',
  });
  
  $(".search-select").select2({
   dropdownAutoWidth: true,
  });
  $(".search-select-w-100").select2({
   dropdownAutoWidth: false,
   width: '100%',
  });

  $('#wo_products').change(function() {
	$('#wo_products_qty').val('');
	$('#wo_products_up').val('');
  });

  $('#add-product').change(function() {
	$.ajax({
		type:'GET',
		url:'/get-product',
		data: {
			part_id: $(this).val(),
		},
		success:function(data) {
			$("#unit_price").val(data.msg[0]['unit_price']);
		}
	});
  });
  
 });
</script>
@endsection