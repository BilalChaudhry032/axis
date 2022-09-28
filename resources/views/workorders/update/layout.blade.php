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
<input type="hidden" id="workorder_id" value="{{ $workorder_id }}">
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
     
    @yield('tabpanel')
     
     
     
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
      <form action="{{ url('/workorders/parts') }}" method="POST">
        @csrf
        <input type="hidden" name="workorder_id" value="{{ $workorder_id }}">
				<div class="modal-body">
				<div class="row">
                <div class="col-12">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label d-block">Product</label>
                  <select class="search-select-w-100" name="part_id" id="add-product">
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
                  <input class="form-control" type="number" required name="quantity" id="add-product_qty">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Unit Price</label>
                  <input class="form-control" type="number" required name="unit_price" id="add-product_up">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">US$</label>
                  <input class="form-control" type="number" required name="us_price" value="0">
                 </div>
                </div>
                <div class="col-sm-6">
                 <div class="form-group">
                  <label for="message-text" class="col-form-label">Ex. Rate</label>
                  <input class="form-control" type="number" required name="exchange_rate" value="0">
                 </div>
                </div>
               </div>
				</div>
				<div class="modal-footer">
				<button type="reset" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
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
   dropdownAutoWidth: false,
   width: '100%'
  });
  $(".search-select-w-100").select2({
   dropdownAutoWidth: false,
   width: '100%',
  });

  $('#step-parts-btn').click(function() {
    let id = $('#workorder_id').val();
    window.location.href = "/workorders/"+id+"/parts";
  });

  // $('#wo_products').change(function() {
	// $('#wo_products_qty').val('');
	// $('#wo_products_up').val('');
  // });

  // $('#part_add_modal_btn').click(function(e) {
  //   e.preventDefault();
  //   $('#part_add_modal').modal('show');
  //   $('#part_add_form').get(0).reset();
  // });

  $('#add-product').change(function() {
    $.ajax({
      type:'GET',
      url:'/get-product',
      data: {
        part_id: $(this).val(),
      },
      success:function(data) {
        $("#add-product_up").val(data.msg[0]['unit_price']);
        $('#add-product_qty').val(1);
      }
    });
  });

  $('.get-part-price').change(function() {
    let parent = $(this).closest(".edit-part-parent");

    $.ajax({
      type:'GET',
      url:'/get-product',
      data: {
        part_id: $(this).val(),
      },
      success:function(data) {
        parent.find(".get-unit_price").val(data.msg[0]['unit_price']);
      }
    });
  });

  $('#step-parts-btn').click(function() {
    console.log($('#workorder_id').val());
    $.ajax({
      type:'GET',
      url:'/get-workorder-products',
      data: {
        workorder_id: $('#workorder_id').val(),
      },
      success:function(data) {
        // parent.find(".get-unit_price").val(data.msg[0]['unit_price']);
        // $('#wo_products_qty').val(1);
        console.log(data.msg[0]['unit_price']);
      }
    });
  });
  
 });
</script>
@endsection