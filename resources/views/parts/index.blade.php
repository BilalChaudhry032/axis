@extends('layouts.master')
@section('content')

<div class="row">
   <div class="col-xl-12">
      
      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between align-items-center">
               <div class="title-content">
                  <h4 class="mb-2">Part</h4>
               </div>
               <div>
                  <a href="" data-toggle="modal" data-target="#part_create_modal" type="button" class="btn btn-secondary px-3 py-2">New Part</a>
               </div>
            </div>
         </div>
         
         <div class="table-responsive">
            <table class="" id="parts_table">
               <thead>
                  <tr>
                     <th style="width: 100px">
                        SR#
                     </th>
                     <th>Part Name</th>
                     <th>Unit Price</th>
                     <th>Description</th>
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
<div class="modal fade" id="part_create_modal" tabindex="-1" role="dialog" aria-labelledby="part_create_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="part_create_label">Add New Part</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ url('/parts') }}" method="POST">
            @csrf
            <div class="modal-body">
               <div class="row">
                  <div class="col-lg-8">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Part Name</label>
                        <input class="form-control" required name="name">
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Unit Price</label>
                        <input type="number" class="form-control" required name="unit_price">
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
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

<!-- Modal Edit -->
<div class="modal fade" id="part_edit_modal" tabindex="-1" role="dialog" aria-labelledby="part_edit_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="part_edit_label">Update Part</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
               <div class="row">
                  <div class="col-lg-8">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Part Name</label>
                        <input class="form-control" required name="name" >
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Unit Price</label>
                        <input type="number" class="form-control" required name="unit_price" >
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
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
<div class="modal fade" id="part_delete_modal" tabindex="-1" role="dialog" aria-labelledby="part_delete_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <form action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
               <h4>Are you sure, you want to Delete this Part?</h4>
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
         
         var table = $('#parts_table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            order: [[1, 'asc']],
            ajax: "{{ route('parts.list') }}",
            columns: [
               {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
               {data: 'name', name: 'name'},
               {data: 'unit_price', name: 'unit_price'},
               {data: 'description', name: 'description'},
               {
                  data: 'action', 
                  name: 'action', 
                  orderable: false, 
                  searchable: false
               },
            ]
         });
         
      });
      
      $('.table-responsive').on('click', '.part_edit_modal_btn', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');
         var url = "{{url('/get-part')}}";
         $.ajax({
            type:'GET',
            url: url,
            data: {
               part_id: id[1],
            },
            success:function(data) {
               $('#part_edit_modal form').attr('action', APP_URL+'/parts/'+id[1]);
               $('#part_edit_modal input[name="name"]').val(data.response.name);
               $('#part_edit_modal input[name="unit_price"]').val(data.response.unit_price);
               $('#part_edit_modal textarea[name="description"]').text(data.response.description);
               $('#part_edit_modal').modal('show');
            }
         });
      });

      $('.table-responsive').on('click', '.part_delete_modal_btn', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');

         $('#part_delete_modal form').attr('action', APP_URL+'/parts/'+id[1]);
         $('#part_delete_modal').modal('show');
      });
      
   });
</script>

@endsection