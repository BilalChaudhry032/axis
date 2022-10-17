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
   <h4 class="font-20 mb-30 mt-30 mx-4">Edit Customer</h4>
   <div class="card-body">
    <form action="{{ url('/customers/'.$customer->customer_id.'/update') }}" method="post" id="customer_store_form">
     @csrf
     @method('PUT')
     <div class="row">
      <div class="col-lg-6 border-right">
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Customer ID</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" readonly value="{{ $customer->customer_id }}" id="customer_id">
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold mb-3" for="postal_address">Postal Address</label>
        </div>
        <div class="col-sm-9">
         <textarea id="postal_address" class="theme-input-style style--three" name="postal_address">{{ $customer->postal_address }}</textarea>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Postal Code</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="postal_code" value="{{ $customer->postal_code }}">
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold mb-3">Fax</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="fax" value="{{ $customer->fax }}">
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Extension</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="extension" value="{{ $customer->extension }}">
        </div>
       </div>
       
      </div>
      
      <div class="col-lg-6">
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Company</label>
        </div>
        <div class="col-sm-9">
         <select class="search-select" name="company_id" required id="company_id">
          <option value="">Select Company</option>
          @foreach ($company as $com)
          <option value="{{ $com->company_id }}" {{ $customer->company_id == $com->company_id ? 'selected' : '' }}>{{ $com->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold">Billing Address</label>
        </div>
        <div class="col-sm-9">
         <select class="search-select" name="billing_address_id" required id="billing_address_id">
          <option value="">Select Billing Address</option>
          @foreach ($billing_address as $ba)
          <option value="{{ $ba->billing_address_id }}" {{ $customer->billing_address_id == $ba->billing_address_id ? 'selected' : '' }}>{{ $ba->name }}</option>
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
          <option value="{{ $con->name }}" {{ $customer->country == $con->name ? 'selected' : '' }}>{{ $con->name }}</option>
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
          <option value="{{ $pro->name }}" {{ $customer->province == $pro->name ? 'selected' : '' }}>{{ $pro->name }}</option>
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
          <option value="{{ $cty->name }}" {{ $customer->city == $cty->name ? 'selected' : '' }}>{{ $cty->name }}</option>
          @endforeach
         </select>
        </div>
       </div>
       
       <div class="form-row mb-2">
        <div class="col-sm-3">
         <label class="font-14 bold mb-3">Telephone</label>
        </div>
        <div class="col-sm-9">
         <input type="text" class="theme-input-style" name="telephone" value="{{ $customer->telephone }}">
        </div>
       </div>
       
      </div>
      
      <div class="col-12">
       <div class="form-row">
        <div class="col-12 text-right pt-3">
         <button type="submit" class="btn long">Save Customer</button>
        </div>
       </div>
      </div>
      
     </div>
    </form>
   </div>
   <hr>
   <div class="card-body pb-0">
    <div class="d-flex justify-content-between align-items-center">
     <div class="title-content">
      <h4 class="mb-2">Contacts</h4>
     </div>
     <div>
      <a href="" data-toggle="modal" data-target="#contact_create_modal" type="button" class="btn btn-secondary px-3 py-2">Add Contact</a>
     </div>
    </div>
   </div>
   <div class="table-responsive">
    <table class="" id="contacts_table">
     <thead>
      <tr>
       {{-- <th>SR#</th> --}}
       <th>Contact Title</th>
       <th>First Name</th>
       <th>Last Name</th>
       <th>Direct</th>
       <th>Cell</th>
       <th>Email</th>
       <th>Notes</th>
       <th>Actions</th>
      </tr>
     </thead>
     <tbody>
     </tbody>
    </table>
   </div>
   
  </div>
  
 </div>
 
</div>

</div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="contact_create_modal" tabindex="-1" role="dialog" aria-labelledby="contact_create_label" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="contact_create_label">Add Contact</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <form action="{{ url('/contacts/store') }}" method="POST">
    @csrf
    <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">
    <div class="modal-body">
     <div class="row">
      <div class="col-sm-12">
       <div class="form-group m-0">
       <label for="message-text" class="col-form-label">Contact Title</label>
       <input class="form-control" required name="contact_title">
      </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">First Name</label>
        <input class="form-control" name="first_name">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Last Name</label>
        <input class="form-control" name="last_name">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Direct</label>
        <input class="form-control" name="direct">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Cell</label>
        <input class="form-control" name="cell">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Email</label>
        <input class="form-control" name="email">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Notes</label>
        <input class="form-control" name="notes">
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

<!-- Modal Edit -->
<div class="modal fade" id="contact_edit_modal" tabindex="-1" role="dialog" aria-labelledby="contact_edit_label" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="contact_edit_label">Update Contact</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <form action="" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-body">
     <div class="row">
      <div class="col-sm-12">
       <div class="form-group m-0">
       <label for="message-text" class="col-form-label">Contact Title</label>
       <input class="form-control" required name="contact_title">
      </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">First Name</label>
        <input class="form-control" name="first_name">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Last Name</label>
        <input class="form-control" name="last_name">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Direct</label>
        <input class="form-control" name="direct">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Cell</label>
        <input class="form-control" name="cell">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Email</label>
        <input class="form-control" name="email">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group m-0">
        <label for="message-text" class="col-form-label">Notes</label>
        <input class="form-control" name="notes">
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

<!-- Modal Delete -->
<div class="modal fade" id="contact_delete_modal" tabindex="-1" role="dialog" aria-labelledby="contact_delete_label" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <form action="" method="POST">
    @csrf
    @method('DELETE')
    <div class="modal-body">
     <h4>Are you sure, you want to Delete this Contact?</h4>
    </div>
    <div class="modal-footer border-0">
     <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
     <button type="submit" class="btn btn-primary bg-danger">Delete</button>
    </div>
   </form>
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
  
  $(function () {
   
   var table = $('#contacts_table').DataTable({
    processing: true,
    serverSide: true,
    paging: true,
    pageLength: 10,
    ajax: {
     url: "{{ route('contacts.list') }}",
     data: {
      customer_id: $('#customer_id').val()
     },
    },
    columns: [
    // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
    {data: 'contact_title', name: 'contact_title'},
    {data: 'first_name', name: 'first_name'},
    {data: 'last_name', name: 'last_name'},
    {data: 'direct', name: 'direct'},
    {data: 'cell', name: 'cell'},
    {data: 'email', name: 'email'},
    {data: 'notes', name: 'notes'},
    {
     data: 'action', 
     name: 'action', 
     orderable: false, 
     searchable: false
    },
    ]
   });
   
  });
  
  $('.table-responsive').on('click', '.edit-contact', function(e) {
   e.preventDefault();
   const APP_URL = {!! json_encode(url('/')) !!};
   let id = $(this).attr('id').split('_');
   var url = "{{url('/get-contact')}}";
   $.ajax({
    type:'GET',
    url: url,
    data: {
     contact_id: id[1],
    },
    success:function(data) {
     // console.log(data.response);
     $('#contact_edit_modal form').attr('action', APP_URL+'/contacts/contact/'+id[1]);
     $('#contact_edit_modal input[name="contact_title"]').val(data.response.contact_title);
     $('#contact_edit_modal input[name="first_name"]').val(data.response.first_name);
     $('#contact_edit_modal input[name="last_name"]').val(data.response.last_name);
     $('#contact_edit_modal input[name="direct"]').val(data.response.direct);
     $('#contact_edit_modal input[name="cell"]').val(data.response.cell);
     $('#contact_edit_modal input[name="email"]').val(data.response.email);
     $('#contact_edit_modal input[name="notes"]').val(data.response.notes);
     $('#contact_edit_modal').modal('show');
    }
   });
  });
  
  $('.table-responsive').on('click', '.delete-contact', function(e) {
   e.preventDefault();
   const APP_URL = {!! json_encode(url('/')) !!};
   let id = $(this).attr('id').split('_');
   
   $('#contact_delete_modal form').attr('action', APP_URL+'/contact/'+id[1]);
   $('#contact_delete_modal').modal('show');
  });
  
 });
</script>
@endsection