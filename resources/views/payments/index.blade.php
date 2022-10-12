@extends('layouts.master')

@section('pageCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

@endsection

@section('content')
<div class="row">
   <div class="col-xl-12">
      
      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between align-items-center">
               <div class="title-content">
                  <h4 class="mb-2">Payments</h4>
               </div>
               <div>
                  <a href="" data-toggle="modal" data-target="#payment_add_modal" type="button" class="btn btn-secondary px-3 py-2">Add Payment</a>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="" id="payments_table">
               <thead>
                  <tr>
                     <th>SR#</th>
                     <th>Invoice#</th>
                     <th>Invoice Amount</th>
                     <th>Payment Method</th>
                     <th>Payment Date</th>
                     <th>Payment Amount</th>
                     <th>Bank Name</th>
                     <th>Cheque#</th>
                     <th>Cheque Date</th>
                     <th>Amount</th>
                     <th>Received</th>
                     <th>Actions</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
      
      <form action="" method="POST" style="display: none" id="form_cancel_archive" style="display: none">
         @csrf
         @method("PUT")
      </form>
   </div>
</div>

<!-- Modal Add Payment  -->
<div class="modal fade" id="payment_add_modal" tabindex="-1" role="dialog" aria-labelledby="payment_add_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="payment_add_label">Add Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form action="{{ url('/workorders/payments') }}" method="POST">
            @csrf
            <div class="modal-body">
               <div class="row edit-payment-parent">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Invoice#</label>
                        <input type="number" class="form-control" required name="invoice_num" id="invoice_num">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Amount Due</label>
                        <input type="number" class="form-control" required name="amount_due">
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label d-block">Payment Method</label>
                        <select class="search-select-w-100 get-payment-price" name="payment_method_id" required>
                           <option value="">Select Payment Method</option>
                           @if (isset($payment_method_list))
                           @foreach ($payment_method_list as $payment_method)
                           <option value="{{ $payment_method->payment_method_id }}">
                              {{ $payment_method->name }}
                           </option>
                           
                           @endforeach
                           @endif
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Payment Date</label>
                        <!-- Date Picker -->
                        <div class="dashboard-date style--four">
                           <span class="input-group-addon">
                              <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
                           </span>
                           <input type="text" class="simple-date-picker" placeholder="Select Date" autocomplete="off" name="payment_date"/>
                        </div>
                        <!-- End Date Picker -->
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Payment Amount</label>
                        <input type="number" class="form-control" required name="payment_amount" value="">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Bank Name</label>
                        <input type="text" class="form-control" name="bank_name">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Invoice Amount</label>
                        <input type="text" class="form-control" name="incoice_amount">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Cheque Date</label>
                        <!-- Date Picker -->
                        <div class="dashboard-date style--four">
                           <span class="input-group-addon">
                              <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
                           </span>
                           <input type="text" class="simple-date-picker" placeholder="Select Date" autocomplete="off" name="cheque_date"/>
                        </div>
                        <!-- End Date Picker -->
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Tax Amount(Provisional)</label>
                        <input type="number" class="form-control" name="tax_amount">
                     </div>
                  </div>
                  
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Cheque#</label>
                        <input type="text" class="form-control" name="cheque_num">
                     </div>
                  </div>
                  
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="message-text" class="col-form-label">Cheque Amount</label>
                        <input type="number" class="form-control" name="cheque_amount">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <label for="message-text" class="col-form-label">Received</label>
                     <!-- Switch -->
                     <label class="switch with-icon">
                        <input type="checkbox" name="received">
                        <span class="control">
                           <span class="check"></span>
                        </span>
                     </label>
                     <!-- End Switch -->
                  </div>
               </div>
               
            </div>
            <div class="modal-footer">
               <button type="reset" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Add Payment</button>
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
      
      $(function () {
         
         var table = $('#payments_table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            ajax: "{{ route('payments.list') }}",
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'workorder_id', name: 'workorder_id'},
            {data: 'invoice_amount', name: 'invoice_amount'},
            {data: 'name', name: 'name'},
            {data: 'payment_date', name: 'payment_date'},
            {data: 'payment_amount', name: 'payment_amount'},
            {data: 'bank_name', name: 'bank_name'},
            {data: 'cheque_num', name: 'cheque_num'},
            {data: 'cheque_date', name: 'cheque_date'},
            {data: 'cheque_amount', name: 'cheque_amount'},
            {data: 'received', name: 'received'},
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
         // $(this).attr('href', APP_URL+'/vendor/'+id[1]);
         // $('#vendor_delete_modal').modal('show');
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