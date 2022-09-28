@extends('workorders.update.layout')
@section('tabpanel')

<div id="step-parts" class="tab-pane" role="tabpanel">
  <div class="card-body">
    <div class="d-flex justify-content-between">
      <div class="title-content">
        <h4 class="font-20 mb-2">Parts</h4>
      </div>
      <div>
        <a href="" data-toggle="modal" data-target="#part_add_modal" type="button" class="btn btn-secondary px-3 py-2">Add Part</a>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="text-nowrap invoice-list">
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
          @if (isset($workorder_parts))
          @foreach ($workorder_parts as $workorder_part)
          <tr>
            <td>
              {{ (($workorder_parts->currentPage() -1) * $workorder_parts->perPage()) + $loop->index + 1 }}
            </td>
            <td>{{ $workorder_part->name }}</td>
            <td>{{ $workorder_part->quantity }}</td>
            <td>{{ $workorder_part->unit_price }}</td>
            <td>{{ $workorder_part->us_price }}</td>
            <td>{{ $workorder_part->exchange_rate }}</td>
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
                  <a href="" data-toggle="modal" data-target="#part_edit_modal_{{ $workorder_part->wo_part_id }}">Edit</a>
                  
                  <a href="" data-toggle="modal" data-target="#part_delete_modal_{{ $workorder_part->wo_part_id }}">Delete</a>
                </div>
              </div>
              <!-- End Dropdown Button -->
            </td>
          </tr>
          <!-- Modal Edit Part -->
          <div class="modal fade" id="part_edit_modal_{{ $workorder_part->wo_part_id }}" tabindex="-1" role="dialog" aria-labelledby="part_edit_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="part_edit_label">Update Part</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ url('/workorders/part/'.$workorder_part->wo_part_id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="workorder_id" value="{{ $workorder_id }}">
                  <div class="modal-body">
                    <div class="row edit-part-parent">
                      <div class="col-12">
                        <div class="form-group">
                          <label for="message-text" class="col-form-label d-block">Product</label>
                          <select class="search-select-w-100 get-part-price" name="part_id">
                            <option value="">Select Product</option>
                            @if (isset($parts_list))
                            @foreach ($parts_list as $part)
                            <option value="{{ $part->part_id }}" {{ ($workorder_part->part_id == $part->part_id) ? 'selected' : '' }} >
                              {{ $part->name }}
                            </option>
                            
                            @endforeach
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Quantity</label>
                          <input type="number" class="form-control" required name="quantity" value="{{ $workorder_part->quantity }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Unit Price</label>
                          <input type="number" class="form-control get-unit_price" required name="unit_price" value="{{ $workorder_part->unit_price }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">US$</label>
                          <input type="number" class="form-control" required name="us_price" value="{{ $workorder_part->us_price }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Ex. Rate</label>
                          <input type="number" class="form-control" required name="exchange_rate" value="{{ $workorder_part->exchange_rate }}">
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
          <div class="modal fade" id="part_delete_modal_{{ $workorder_part->wo_part_id }}" tabindex="-1" role="dialog" aria-labelledby="vendor_delete_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="{{ url('/workorders/part/'.$workorder_part->wo_part_id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body">
                    <h4>Are you sure, you want to Delete this Product?</h4>
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
          @endif
        </tbody>
      </table>
    </div>
  </div>
  {!! $workorder_parts->links('pagination::bootstrap-5') !!}
</div> 

@endsection