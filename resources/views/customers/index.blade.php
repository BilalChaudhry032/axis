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
      
      <form action="" method="POST" style="display: none" id="form_cancel_archive">
         @csrf
         @method("PUT")
      </form>
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
               {data: 'company_name', name: 'company.name'},
               {data: 'billing_address_name', name: 'billing_address.name'},
               {data: 'postal_address', name: 'customer_parent.postal_address'},
               {data: 'city', name: 'customer_parent.city'},
               {data: 'contacts_persons', name: 'contacts_persons', searchable: true},
               {
                  data: 'action', 
                  name: 'action', 
                  orderable: false, 
                  searchable: false
               },
            ]
         });
         
      });

      $('.table-responsive').on('click', '.edit-workorder', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');

         window.location.href = APP_URL+'/workorders/workorder/'+id[1];
      });
      
      $('.table-responsive').on('click', '.cancel-workorder', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');

         $('#form_cancel_archive').attr('action', APP_URL+'/workorder/'+id[1]+'/cancelled').submit();
      });

      $('.table-responsive').on('click', '.archive-workorder', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');

         $('#form_cancel_archive').attr('action', APP_URL+'/workorder/'+id[1]+'/archived').submit();
      });
      
   });
</script>

@endsection