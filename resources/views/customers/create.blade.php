@extends('layouts.master')

@section('pageCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

<style>
 input[readonly] {
  cursor: not-allowed;
 }
</style>

@endsection

@section('content')
<div class="row">
 <div class="col-xl-12">
  <div class="card mb-30">
   <h4 class="font-20 mb-30 mt-30 mx-4">New Customer</h4>
   <div class="card-body">
    <form action="{{ url('/customers/store') }}" method="post" id="customer_store_form">
     @csrf
     <div class="row">
      <div class="col-lg-6 border-right">
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Customer ID</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" readonly placeholder="Customer ID will be generated by the system">
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold mb-3" for="postal_address">Postal Address</label>
        </div>
        <div class="col-sm-9">
         <textarea id="postal_address" class="theme-input-style style--three" name="postal_address">{{ Session::get('postal_address') }}</textarea>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Postal Code</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="postal_code" value="{{ Session::get('postal_code') }}">
        </div>
       </div>

       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold mb-3">Fax</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="fax" value="{{ Session::get('fax') }}">
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Extension</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="extension" value="{{ Session::get('extension') }}">
        </div>
       </div>
       
      </div>
      
      <div class="col-lg-6">

       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Company</label>
        </div>
        <div class="col-sm-9">
         <select class="search-select" name="company_id" required>
          <option value="">Select Company</option>
          @foreach ($company as $com)
           <option value="{{ $com->company_id }}" {{ Session::get('company_id') == $com->company_id ? 'selected' : '' }}>{{ $com->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Billing Address</label>
        </div>
        <div class="col-sm-9">
         <select class="search-select" name="billing_address_id" required>
          <option value="">Select Billing Address</option>
          @foreach ($billing_address as $ba)
           <option value="{{ $ba->billing_address_id }}">{{ $ba->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Country</label>
        </div>
        <div class="col-sm-9">
         <select class="search-select" name="country" id="">
          <option value="">Select Country</option>
          @foreach ($country as $con)
           <option value="{{ $con->name }}" {{ Session::get('country') == $con->name ? 'selected' : '' }}>{{ $con->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Province</label>
        </div>
        <div class="col-sm-9">
         <select class="search-select" name="province" id="">
          <option value="">Select Province</option>
          @foreach ($province as $pro)
           <option value="{{ $pro->name }}" {{ Session::get('province') == $pro->name ? 'selected' : '' }}>{{ $pro->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">City</label>
        </div>
        <div class="col-sm-9">
         <select class="search-select" name="city" id="">
          <option value="">Select City</option>
          @foreach ($city as $cty)
           <option value="{{ $cty->name }}" {{ Session::get('city') == $cty->name ? 'selected' : '' }}>{{ $cty->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold mb-3">Telephone</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="telephone" value="{{ Session::get('telephone') }}">
        </div>
       </div>
       
      </div>
      
      <div class="col-12">
       <div class="form-row">
        <div class="col-12 text-right py-3">
         <button type="submit" class="btn long">Save Customer</button>
        </div>
       </div>
      </div>
      
     </div>
    </form>
   </div>
   
  </div>
  
 </div>
 
</div>

</div>
</div>


@endsection

@section('pageScript')

<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>



<script>
 $(document).ready(function() {
  $(".search-select").select2({
   dropdownAutoWidth: false,
   width: '100%'
  });
 });
</script>
@endsection