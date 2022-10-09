@extends('layouts.master')
@section('content')
<div class="row">
   <div class="col-xl-12">
      
      {{-- <div class="card mb-30">
         <div class="card-body">
            <div class="d-flex justify-content-between">
               <form action="{{ url('/vendor') }}" class="search-form flex-grow">
                  <div class="theme-input-group style--two">
                     <input type="text" class="theme-input-style" placeholder="Search Here" name="search" value="{{ $search }}">
                     
                     <button type="submit"><img src="{{ asset('/assets/img/svg/search-icon.svg') }}" alt="" class="svg"></button>
                  </div>
               </form>
            </div>
         </div>
      </div> --}}
      
      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between align-items-center">
               <div class="title-content">
                  <h4 class="mb-2">Vendor</h4>
               </div>
               {{-- <div class="mb-2 w-50">
                  <form action="{{ url('/vendor') }}" class="search-form flex-grow">
                     <div class="theme-input-group style--two">
                        <input type="text" class="theme-input-style" placeholder="Search Here" name="search" value="{{ $search }}" id="search-vendor">
                        
                        <button type="submit"><img src="{{ asset('/assets/img/svg/search-icon.svg') }}" alt="" class="svg"></button>
                     </div>
                  </form>
               </div> --}}
               <div>
                  <a href="" data-toggle="modal" data-target="#vendor_create_modal" type="button" class="btn btn-secondary px-3 py-2">New Vendor</a>
               </div>
            </div>
         </div>
         
         <div class="table-responsive">
            <table class="text-nowrap" id="vendors_table">
               <thead>
                  <tr>
                     <th style="width: 100px">
                        SR#
                     </th>
                     <th>Vendor Name</th>
                     <th class="text-right">Actions</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
            <!-- End Invoice List Table -->
         </div>
      </div>
      
      <!-- Modal Create -->
      <div class="modal fade" id="vendor_create_modal" tabindex="-1" role="dialog" aria-labelledby="vendor_create_label" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="vendor_create_label">Add New Vendor</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form action="{{ url('/vendor') }}" method="POST">
                  @csrf
                  <div class="modal-body">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Vendor Name</label>
                        <input class="form-control" required name="name">
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Add Vendor</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      
      <!-- Modal Edit -->
      <div class="modal fade" id="vendor_edit_modal" tabindex="-1" role="dialog" aria-labelledby="vendor_edit_label" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="vendor_edit_label">Update Vendor</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form action="" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="modal-body">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Vendor Name</label>
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
      <div class="modal fade" id="vendor_delete_modal" tabindex="-1" role="dialog" aria-labelledby="vendor_delete_label" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <form action="" method="POST">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body">
                     <h4>Are you sure, you want to Delete this Vendor?</h4>
                  </div>
                  <div class="modal-footer border-0">
                     <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary bg-danger">Delete</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      
   </div>
</div>

@endsection

@section('pageScript')

<script>
   $(document).ready(function() {
      
      $(function () {
         
         var table = $('#vendors_table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            ajax: "{{ route('vendor.list') }}",
            columns: [
               {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
               {data: 'name', name: 'vendor.name'},
               {
                  data: 'action', 
                  name: 'action', 
                  orderable: false, 
                  searchable: false
               },
            ]
         });
         
      });
      
      $('.table-responsive').on('click', '.vendor_edit_modal_btn', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');
         var url = "{{url('/get-vendor')}}";
         $.ajax({
            type:'GET',
            url: url,
            data: {
               vendor_id: id[1],
            },
            success:function(data) {
               $('#vendor_edit_modal form').attr('action', APP_URL+'/vendor/'+id[1]);
               $('#vendor_edit_modal input[name="name"]').val(data.response.name);
               $('#vendor_edit_modal').modal('show');
            }
         });
      });

      $('.table-responsive').on('click', '.vendor_delete_modal_btn', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');

         $('#vendor_delete_modal form').attr('action', APP_URL+'/vendor/'+id[1]);
         $('#vendor_delete_modal').modal('show');
      });
      
   });
</script>

@endsection