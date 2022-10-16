@extends('layouts.master')

@section('pageCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
@endsection

@section('content')

<div class="d-flex flex-column flex-md-row">
 <div class="mb-30">
  <!-- Tasks Aside -->
  <div class="aside">
   <!-- Aside Body -->
   <nav class="aside-body">
    <h4 class="mb-3">Reports</h4>
    
    <ul class="nav flex-column">
     <li><a class="active" data-toggle="tab" href="#Monthly_Sale_tab" id="Monthly_Sale_btn">Monthly Sale</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Receivable_btn">Receivable</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Pending_Workorders_btn">Pending Workorders</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Product-Wise_btn">Product Wise</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Tax_btn">Tax</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Stat_btn">Stat</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Branch_Wise_btn">Branch Wise</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Order_List_btn">Order List</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Vendor_btn">Vendor</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Report_Name_btn">Report Name</a></li>
     <li><a data-toggle="tab" href="#Monthly_Sale_tab" id="Country-Wise_btn">Country Wise</a></li>
    </ul>
   </nav>
   <!-- End Aside Body -->
  </div>
  <!-- End Tasks Aside -->
 </div>
 <div class="container-fluid">
  <div class="row">
   
   <div class="col-xl-12 mb-30 mb-xl-0">
    <!-- Card -->
    <div class="card h-100">
     <div class="card-body p-30">
      <div class="tab-content">
       <div class="tab-pane fade show active" id="Monthly_Sale_tab">
        <h4 class="mb-4" id="form_title">Monthly Sale</h4>
        
        <form action="{{ url('/reports/monthly-sale') }}"  target="_blank" id="report_form">
         @csrf
         <div class="row">
          <div class="col-lg-6">
           <!-- Form Group -->
           <div class="form-row">
            <div class="col-sm-3">
             <label class="font-14 bold">From Date</label>
            </div>
            <div class="col-sm-9">
             <!-- Date Picker -->
             <div class="dashboard-date style--four">
              <span class="input-group-addon">
               <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
              </span>
              <input type="text" class="simple-date-picker" placeholder="Select Date" name="from_date" autocomplete="off" required/>
             </div>
             <!-- End Date Picker -->
            </div>
           </div>
          </div>
          <div class="col-lg-6">
           <!-- Form Group -->
           <div class="form-row">
            <div class="col-sm-3">
             <label class="font-14 bold">To Date</label>
            </div>
            <div class="col-sm-9">
             <!-- Date Picker -->
             <div class="dashboard-date style--four">
              <span class="input-group-addon">
               <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
              </span>
              <input type="text" class="simple-date-picker" placeholder="Select Date" name="to_date" autocomplete="off" required/>
             </div>
             <!-- End Date Picker -->
            </div>
           </div>
          </div>
          <div class="col-12"><hr></div>
          <div class="col-lg-6">
           <div class="form-row mb-3">
            <div class="col-sm-3">
             <label class="font-14 bold">Company</label>
            </div>
            <div class="col-sm-9">
             <select class="search-select" name="company_id">
              <option value="">Select Company</option>
              @if (isset($company_list) && strlen($company_list) > 0)
              @foreach ($company_list as $company)
              <option value="{{ $company->company_id }}">{{ $company->name }}</option>
              @endforeach
              @endif
             </select>
            </div>
           </div>
          </div>
          <div class="col-lg-6">
           <div class="form-row mb-3">
            <div class="col-sm-3">
             <label class="font-14 bold">Billing Address</label>
            </div>
            <div class="col-sm-9">
             <select class="search-select" name="billing_address_id">
              <option value="">Select Billing Address</option>
             </select>
            </div>
           </div>
          </div>
          <div class="col-lg-6">
           <div class="form-row mb-0">
            <div class="col-sm-3">
             <label class="font-14 bold">Contact Person</label>
            </div>
            <div class="col-sm-9">
             <select class="search-select" name="child_id">
              <option value="">Select Contact Person</option>
             </select>
            </div>
           </div>
          </div>
          <div class="col-lg-6">
           <div class="form-row mb-0">
            <div class="col-sm-3">
             <label class="font-14 bold">Country</label>
            </div>
            <div class="col-sm-9">
             <select class="search-select" name="country_id">
              <option value="">Select Country</option>
              @if (isset($country_list) && strlen($country_list) > 0)
              @foreach ($country_list as $country)
              <option value="{{ $country->country_id }}">{{ $country->name }}</option>
              @endforeach
              @endif
             </select>
            </div>
           </div>
          </div>
          <div class="col-12"><hr></div>
          <div class="col-lg-6">
           <div class="form-row mb-0">
            <div class="col-sm-3">
             <label class="font-14 bold">Part Name</label>
            </div>
            <div class="col-sm-9">
             <select class="search-select" name="part_id">
              <option value="">Select Part Name</option>
              @if (isset($part_list) && strlen($part_list) > 0)
              @foreach ($part_list as $part)
              <option value="{{ $part->part_id }}">{{ $part->name }}</option>
              @endforeach
              @endif
             </select>
            </div>
           </div>
          </div>
          <div class="col-lg-6">
           <div class="form-row mb-0">
            <div class="col-sm-3">
             <label class="font-14 bold">City</label>
            </div>
            <div class="col-sm-9">
             <select class="search-select" name="city_id">
              <option value="">Select City</option>
              @if (isset($city_list) && strlen($city_list) > 0)
              @foreach ($city_list as $city)
              <option value="{{ $city->city_id }}">{{ $city->name }}</option>
              @endforeach
              @endif
             </select>
            </div>
           </div>
          </div>
          <div class="col-12"><hr></div>
          <div class="col-lg-12">
           <div class="form-row mb-3">
            <div class="col-sm-2">
             <label class="font-14 bold">Report Name</label>
            </div>
            <div class="col-sm-10">
             <input type="text" class="theme-input-style" name="report_name">
            </div>
           </div>
          </div>
          <div class="col-lg-12">
           <div class="button-group mt-30 mt-xl-n5">
            <button type="submit" class="btn long">Generate Report</button>
           </div>
          </div>
         </div>
        </form>
       </div>
       
       
      </div>
     </div>
    </div>
    <!-- End Card -->
   </div>
   
  </div>
 </div>
</div>

@endsection

@section('pageScript')
<script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>

<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
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
  
  $('select[name="company_id"]').change(function() {
   var url = "{{url('/get-company-addresses')}}";
   $.ajax({
    type:'GET',
    url: url,
    data: {
     wo_company_id: $(this).val(),
    },
    success:function(data) {
     $('select[name="billing_address_id"]').empty();
     $('select[name="child_id"]').empty();
     
     var defaultOption1 = new Option('Select Billing Address', '', false, false);
     $('select[name="billing_address_id"]').append(defaultOption1).trigger('change');
     
     var defaultOption2 = new Option('Select Contact Person', '', false, false);
     $('select[name="child_id"]').append(defaultOption2).trigger('change');
     
     $(data.response).each(function(i) {
      var newOption = new Option(data.response[i]['name'], data.response[i]['billing_address_id'], false, false);
      $('select[name="billing_address_id"]').append(newOption).trigger('change');
     });
    }
   });
  });
  
  $('select[name="billing_address_id"]').change(function() {
   if($(this).val() != '') {
    var url = "{{url('/get-company-persons')}}";
    $.ajax({
     type:'GET',
     url: url,
     data: {
      wo_company_id: $('select[name="company_id"]').val(),
      wo_billing_address_id: $(this).val(),
     },
     success:function(data) {
      $('select[name="child_id"]').empty();
      var defaultOption = new Option('Select Contact Person', '', false, false);
      $('select[name="child_id"]').append(defaultOption).trigger('change');
      $(data.response).each(function(i) {
       var newOption = new Option(
       ((data.response[i]['first_name']) == null || (data.response[i]['first_name']) == '' ? '' : data.response[i]['first_name'])+' '+((data.response[i]['last_name']) == null || (data.response[i]['last_name']) == '' ? '' : data.response[i]['last_name']), 
       data.response[i]['child_id'], 
       false, 
       false
       );
       $('select[name="child_id"]').append(newOption).trigger('change');
      });
     }
    });
   }
  });
  
  $('#Monthly_Sale_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/monthly-sale')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Monthly Sale');
   
   $('input[name="from_date"]').prop('required',true);
   $('input[name="to_date"]').prop('required',true);
   $('select[name="company_id"]').prop('required',false).trigger('change');
   // $('select[name="billing_address_id"]').prop('required',false).trigger('change');
   // $('select[name="child_id"]').prop('required',false).trigger('change');
   // $('select[name="country_id"]').prop('required',false).trigger('change');
   // $('select[name="part_id"]').prop('required',false).trigger('change');
   // $('select[name="city_id"]').prop('required',false).trigger('change');
   // $('input[name="report_name"]').prop('required',false);
   
  });
  
  $('#Receivable_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/receivable')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Receivable');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Pending_Workorders_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/pending')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Pending Workorders');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Product-Wise_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/product')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Product Wise');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Tax_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/tax')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Tax');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Stat_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/stat')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Stat');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Branch_Wise_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/branch')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Branch Wise');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Order_List_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/order-list')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Order List');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',true).trigger('change');
  });

  $('#Vendor_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/vendor')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Vendor');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Report_Name_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/report-name')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Report Name');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });

  $('#Country-Wise_btn').on('click', function(e) {
   e.preventDefault();
   var url = "{{url('/reports/country')}}";
   
   $('#report_form').attr('action', url);
   $('#form_title').text('Country Wise');
   
   $('input[name="from_date"]').prop('required',false);
   $('input[name="to_date"]').prop('required',false);
   $('select[name="company_id"]').prop('required',false).trigger('change');
  });
  
 });
</script>

@endsection