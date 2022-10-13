@extends('layouts.master')

@section('content')
<div class="row">
   <div class="col-xl-12">
      
      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between align-items-center">
               <div class="title-content">
                  <h4 class="mb-2">Archived</h4>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="" id="archive_table">
               <thead>
                  <tr>
                     <th>SR#</th>
                     <th>Company</th>
                     <th>Invoice#</th>
                     <th>Report Name</th>
                     <th>Date Received</th>
                     <th>Date Required</th>
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
         
         var table = $('#archive_table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            ajax: "{{ route('archived.list') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'company.name'},
            {data: 'workorder_id', name: 'workorder.workorder_id'},
            {data: 'report_name', name: 'workorder.report_name'},
            {data: 'date_received', name: 'date_received'},
            {data: 'date_delivered', name: 'date_delivered'},
            {
               data: 'action', 
               name: 'action', 
               orderable: false, 
               searchable: false
            },
            ]
         });
      });

      
      $('#archive_table').on('click', '.activate-archive', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');
         
         $('#form_cancel_archive').attr('action', APP_URL+'/workorder/'+id[1]+'/un-archived').submit();
      });

      $('#archive_table').on('click', '.detail-archive', function(e) {
         e.preventDefault();
         const APP_URL = {!! json_encode(url('/')) !!};
         let id = $(this).attr('id').split('_');
         let url = APP_URL+'/workorder/'+id[1]+'/invoice';
         window.open(url);
      });
      
   });
</script>

@endsection