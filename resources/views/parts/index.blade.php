@extends('layouts.master')
@section('content')

<div class="row">
   <div class="col-xl-12">

      <div class="card mb-30">
         <div class="card-body">
            <div class="d-flex justify-content-between">
               <form action="{{ url('/parts') }}" class="search-form flex-grow">
                  <div class="theme-input-group style--two">
                     <input type="text" class="theme-input-style" placeholder="Search Here" name="search" value="{{ $search }}">

                     <button type="submit"><img src="{{ asset('/assets/img/svg/search-icon.svg') }}" alt="" class="svg"></button>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
               <div class="title-content">
                  <h4 class="mb-2">Part</h4>
               </div>
               <div>
                  <a href="" data-toggle="modal" data-target="#part_create_modal" type="button" class="btn btn-secondary px-3 py-2">New Part</a>
               </div>
            </div>
         </div>
         @if (count($parts) > 0)
         <div class="table-responsive">
            <table class="invoice-list">
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
                     @foreach ($parts as $part)
                     <tr>
                        <td>
                           {{ (($parts->currentPage() -1) * $parts->perPage()) + $loop->index + 1 }}
                        </td>
                        <td>{{ $part->name }}</td>
                        <td>{{ $part->unit_price }}</td>
                        <td>{{ $part->description }}</td>
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
                                    <a href="" data-toggle="modal" data-target="#part_edit_modal_{{ $part->part_id }}">Edit</a>
                                    
                                    <a href="" data-toggle="modal" data-target="#part_delete_modal_{{ $part->part_id }}">Delete</a>
                                 </div>
                              </div>
                              <!-- End Dropdown Button -->
                        </td>
                     </tr>

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
                     <div class="modal fade" id="part_edit_modal_{{ $part->part_id }}" tabindex="-1" role="dialog" aria-labelledby="part_edit_label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                              <h5 class="modal-title" id="part_edit_label">Update Part</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                              </div>
                              <form action="{{ url('/parts/'.$part->part_id) }}" method="POST">
                                 @csrf
                                 @method('PUT')
                                 <div class="modal-body">
                                    <div class="row">
                                       <div class="col-lg-8">
                                          <div class="form-group">
                                             <label for="message-text" class="col-form-label">Part Name</label>
                                             <input class="form-control" required name="name" value="{{ $part->name }}">
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
                                          <div class="form-group">
                                             <label for="message-text" class="col-form-label">Unit Price</label>
                                             <input type="number" class="form-control" required name="unit_price" value="{{ $part->unit_price }}">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <div class="form-group">
                                             <label for="message-text" class="col-form-label">Description</label>
                                             <textarea class="form-control" name="description" rows="3">{{ $part->description }}</textarea>
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
                     <div class="modal fade" id="part_delete_modal_{{ $part->part_id }}" tabindex="-1" role="dialog" aria-labelledby="part_delete_label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                           <div class="modal-content">
                              <form action="{{ url('/parts/'.$part->part_id) }}" method="POST">
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

                     @endforeach
                  </tbody>
            </table>
            <!-- End Invoice List Table -->
         </div>
         @else
            <div class="px-3 pb-3 text-center">
               <p class="">No Part Found!</p>
            </div>
         @endif
      </div>
      
      {!! $parts->links('pagination::bootstrap-5') !!}


   </div>
</div>

@endsection