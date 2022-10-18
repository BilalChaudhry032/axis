@extends('layouts.master')
@section('content')
<div class="row">
   <div class="col-xl-12">
      
      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between align-items-center">
               <div class="title-content">
                  <h4 class="mb-2">Billing Address</h4>
               </div>
               <div>
                  <a href="" data-toggle="modal" data-target="#billing_address_create_modal" type="button" class="btn btn-secondary px-3 py-2">New Billing Address</a>
               </div>
            </div>
         </div>
         
         <div class="table-responsive">
            <table class="text-nowrap" id="bill_addr_table">
               <thead>
                  <tr>
                     <th style="width: 100px">
                        SR#
                     </th>
                     <th>Billing Address</th>
                     <th>Actions</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
            <!-- End Invoice List Table -->
         </div>
      </div>
      
      
   </div>
</div>
<!-- Modal Create -->
<div class="modal fade" id="billing_address_create_modal" tabindex="-1" role="dialog" aria-labelledby="billing_address_create_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="billing_address_create_label">Add New Billing Address</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ url('/billing-address') }}" method="POST">
            @csrf
            <div class="modal-body">
               <div class="form-group">
                  <label for="message-text" class="col-form-label">Billing Address</label>
                  <input class="form-control" required name="name">
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Add Billing Address</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="billing_address_edit_modal" tabindex="-1" role="dialog" aria-labelledby="billing_address_edit_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="billing_address_edit_label">Update Billing Address</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
               <div class="form-group">
                  <label for="message-text" class="col-form-label">Billing Address</label>
                  <input class="form-control" required name="name">
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
<div class="modal fade" id="billing_address_delete_modal" tabindex="-1" role="dialog" aria-labelledby="billing_address_delete_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <form action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
               <h4>Are you sure, you want to Delete this Billing Address?</h4>
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
         
         var table = $('#bill_addr_table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            order: [[1, 'asc']],
            ajax: "{{ route('billingAddress.list') }}",
            columns: [
               {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
               {data: 'name', name: 'name'},
               {
                  data: 'action', 
                  name: 'action', 
                  orderable: false, 
                  searchable: false
               },
            ]
         });
         
      });
      
      $('.table-responsive').on('click', '.bill_addr_edit_modal_btn', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');
         var url = "{{url('/get-billing-address')}}";
         $.ajax({
            type:'GET',
            url: url,
            data: {
               billing_address_id: id[1],
            },
            success:function(data) {
               $('#billing_address_edit_modal form').attr('action', APP_URL+'/billing-address/'+id[1]);
               $('#billing_address_edit_modal input[name="name"]').val(data.response.name);
               $('#billing_address_edit_modal').modal('show');
            }
         });
      });

      $('.table-responsive').on('click', '.bill_addr_delete_modal_btn', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');

         $('#billing_address_delete_modal form').attr('action', APP_URL+'/billing-address/'+id[1]);
         $('#billing_address_delete_modal').modal('show');
      });
      
   });
</script>

@endsection