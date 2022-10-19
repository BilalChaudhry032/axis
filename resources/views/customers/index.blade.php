@extends('layouts.master')
@section('content')
<div class="row">
   <div class="col-xl-12">
      
      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between align-items-center">
               <div class="title-content">
                  <h4 class="mb-2">Customers</h4>
               </div>
               <div>
                  <a href="{{ url('/customers/create') }}" type="button" class="btn btn-secondary px-3 py-2">New Customer</a>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="" id="customers_table">
               <thead>
                  <tr>
                     <th>SR#</th>
                     <th>Company</th>
                     <th>Billing Address</th>
                     <th>Postal Address</th>
                     <th>City</th>
                     <th>Contacts Persons</th>
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

<!-- Modal Delete -->
<div class="modal fade" id="customer_delete_modal" tabindex="-1" role="dialog" aria-labelledby="customer_delete_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <form action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
               <h4>Are you sure, you want to Delete this Customer?</h4>
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

<script>
   $(document).ready(function() {
      
      $(function () {
         
         var table = $('#customers_table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            ajax: "{{ route('customers.list') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'company_name', name: 'company_name'},
            {data: 'billing_address_name', name: 'billing_address_name'},
            {data: 'postal_address', name: 'postal_address'},
            {data: 'city', name: 'city'},
            {data: 'contacts_persons', name: 'contacts_persons'},
            {
               data: 'action',
               name: 'action',
               orderable: false,
               searchable: false
            },
            ]
         });
         
      });
      
      $('.table-responsive').on('click', '.edit-customer', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');
         
         window.location.href = APP_URL+'/customers/'+id[1]+'/update';
      });
      
      $('.table-responsive').on('click', '.delete-customer', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');
         
         $('#customer_delete_modal form').attr('action', APP_URL+'/customer/'+id[1]);
         $('#customer_delete_modal').modal('show');
      });
      
   });
</script>

@endsection