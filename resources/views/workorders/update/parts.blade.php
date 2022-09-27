@extends('workorders.update.layout')
@section('tabpanel')

<div id="step-parts" class="tab-pane" role="tabpanel">
 <div class="card-body">
  <h4 class="font-20 mb-30">Parts</h4>
  
  <div class="table-responsive">
   <table class="text-nowrap">
    <thead>
     <tr>
      <th>SR#</th>
      <th>Product</th>
      <th>Quantity</th>
      <th>Unit Price</th>
      <th>US$</th>
      <th>Ex. Rate</th>
      <th>Actions</th>
     </tr>
    </thead>
    <tbody>
     <tr>
      <td>
       {{-- {{ (($workOrders->currentPage() -1) * $workOrders->perPage()) + $loop->index + 1 }} --}}
       1
      </td>
      <td>product name</td>
      <td>Quantity</td>
      <td>Unit Price</td>
      <td>US$</td>
      <td>Ex. Rate</td>
      <td>Actions</td>
     </tr>
    </tbody>
   </table>
  </div>
 </div>
</div> 

@endsection