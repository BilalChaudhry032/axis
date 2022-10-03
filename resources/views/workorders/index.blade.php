@extends('layouts.master')
@section('content')
<div class="row">
   <div class="col-xl-12">
      
      {{-- <div class="card mb-30">
         <div class="card-body">
            <div class="d-flex justify-content-between">
               <form action="{{ url('/workorders') }}" class="search-form flex-grow">
                  <div class="theme-input-group style--two">
                     <input type="text" class="theme-input-style" placeholder="Search Here" name="search">
                     
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
                  <h4 class="mb-2">Workorders</h4>
               </div>
               <div class="mb-2 w-50">
                  <form action="{{ url('/workorders') }}" class="search-form flex-grow">
                     <div class="theme-input-group style--two">
                        <input type="text" class="theme-input-style" placeholder="Search Here" name="search">
                        
                        <button type="submit"><img src="{{ asset('/assets/img/svg/search-icon.svg') }}" alt="" class="svg"></button>
                     </div>
                  </form>
               </div>
               <div>
                  <a href="{{ url('/workorders/create') }}" type="button" class="btn btn-secondary px-3 py-2">New Workorder</a>
               </div>
            </div>
         </div>
         <div class="table-responsive">
            <table class="text-nowrap invoice-list">
               <thead>
                  <tr>
                     <th>
                        {{-- <!-- Custom Checkbox -->
                        <label class="custom-checkbox">
                           <input type="checkbox">
                           <span class="checkmark"></span>
                        </label>
                        <!-- End Custom Checkbox --> --}}
                        SR#
                     </th>
                     <th>Company</th>
                     <th>Invoice#</th>
                     <th>PO#</th>
                     <th>Report Name</th>
                     <th>Date Received</th>
                     <th>Date Delivered</th>
                     <th>Actions</th>
                  </tr>
               </thead>
               <tbody>
                  
                  @foreach ($workOrders as $workOrder)
                  <tr>
                     <td>
                        {{-- <!-- Custom Checkbox -->
                        <label class="custom-checkbox">
                           <input type="checkbox">
                           <span class="checkmark"></span>
                        </label>
                        <!-- End Custom Checkbox --> --}}
                        {{ (($workOrders->currentPage() -1) * $workOrders->perPage()) + $loop->index + 1 }}
                     </td>
                     <td>{{ $workOrder->name }}</td>
                     <td>{{ $workOrder->workorder_id }}</td>
                     <td>{{ $workOrder->po_num }}</td>
                     <td>{{ $workOrder->report_name }}</td>
                     <td>{{ \Carbon\Carbon::parse($workOrder->date_received)->format('d-m-Y') }}</td>
                     <td>{{ \Carbon\Carbon::parse($workOrder->date_delivered)->format('d-m-Y') }}</td>
                     <td>
                        <!-- Dropdown Button -->
                        <div class="dropdown-button">
                           <a href="#" class="d-flex align-items-center justify-content-end" data-toggle="dropdown">
                              <div class="menu-icon mr-0">
                                 <span></span>
                                 <span></span>
                                 <span></span>
                              </div>
                           </a>
                           <div class="dropdown-menu dropdown-menu-right">
                              <a href="{{ url('/workorders/workorder/'.$workOrder->workorder_id) }}">Edit</a>
                              <a href="#">Cancel</a>
                              <a href="#">Archive</a>
                           </div>
                        </div>
                        <!-- End Dropdown Button -->
                     </td>
                  </tr>
                  @endforeach
                  
               </tbody>
            </table>
            <!-- End Invoice List Table -->
         </div>
      </div>
      
      {!! $workOrders->links('pagination::bootstrap-5') !!}
   </div>
</div>
@endsection