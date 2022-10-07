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
         @if (count($vendors) > 0)
         <div class="table-responsive">
            <table class="text-nowrap" id="table">
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
                  @foreach ($vendors as $vendor)
                  <tr>
                     <td>
                        {{-- {{ (($vendors->currentPage() -1) * $vendors->perPage()) + $loop->index + 1 }} --}}
                     </td>
                     <td>{{ $vendor->name }}</td>
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
                              <a href="" data-toggle="modal" data-target="#vendor_edit_modal_{{ $vendor->vendor_id }}">Edit</a>
                              
                              <a href="" data-toggle="modal" data-target="#vendor_delete_modal_{{ $vendor->vendor_id }}">Delete</a>
                           </div>
                        </div>
                        <!-- End Dropdown Button -->
                     </td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="vendor_edit_modal_{{ $vendor->vendor_id }}" tabindex="-1" role="dialog" aria-labelledby="vendor_edit_label" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="vendor_edit_label">Update Vendor</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <form action="{{ url('/vendor/'.$vendor->vendor_id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">
                                 <div class="form-group">
                                    <label for="message-text" class="col-form-label">Vendor Name</label>
                                    <input class="form-control" required name="name" value="{{ $vendor->name }}">
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
                  <div class="modal fade" id="vendor_delete_modal_{{ $vendor->vendor_id }}" tabindex="-1" role="dialog" aria-labelledby="vendor_delete_label" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                           <form action="{{ url('/vendor/'.$vendor->vendor_id) }}" method="POST">
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
                  
                  @endforeach
               </tbody>
            </table>
            <!-- End Invoice List Table -->
         </div>
         @else
         <div class="px-3 pb-3 text-center">
            <p class="">No Vendor Found!</p>
         </div>
         @endif
      </div>
      
      {{-- {!! $vendors->links('pagination::bootstrap-5') !!} --}}
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
      
   </div>
</div>

@endsection

@section('pageScript')

<script>
   $(document).ready(function() {
      
      var t = $('#table').DataTable({
         columnDefs: [
         {
            searchable: false,
            orderable: false,
            targets: 0,
         },
         ],
         order: [[1, 'asc']],
      });
      
      t.on('order.dt search.dt', function () {
         let i = 1;
         
         t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
         });
      }).draw();
      
      $('#search-vendor').change(function() {
         var url = "{{url('/search-vendor')}}";
         console.log($(this).val());
         $.ajax({
            type:'GET',
            url: url,
            data: {
               v_data: $(this).val(),
            },
            success:function(data) {
               console.log(data);
            }
         });
      });
      
   });
</script>

@endsection