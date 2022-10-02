@extends('layouts.master')

@section('pageCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
<link href="{{ asset('assets/plugins/jquery-smartwizard/smart_wizard_all.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}">

<style>
  .main-content #smartwizard .nav li a {
    height: 50px;
  }
  .sw-theme-arrows>.nav .nav-link {
    color: #aeaeae;
    border-color: #f8f8f8;
    background: #fafafa;
    background: -moz-linear-gradient(left,#fafafa 0,#dbf7e8 100%);
    background: -webkit-linear-gradient(left,#fafafa 0,#dbf7e8 100%);
    background: linear-gradient(to right,#fafafa 0,#dbf7e8 100%);
    /* cursor: not-allowed; */
  }
  input[readonly] {
    cursor: not-allowed;
  }
</style>

@endsection

@section('content')
<input type="hidden" id="workorder_id" value="{{ $workorder_id }}">
<div class="row">
  <div class="col-xl-12">
    <div class="card mb-30">
      <h4 class="font-20 mb-30 mt-30 mx-4">Edit Workorder</h4>
      
      <div id="smartwizard">
        <ul class="nav">
          <li>
            <a class="nav-link" href="#step-workorder" id="step-workorder-btn">
              Workorder
            </a>
          </li>
          <li>
            <a class="nav-link" href="#step-parts" id="step-parts-btn">
              Parts
            </a>
          </li>
          <li>
            <a class="nav-link" href="#step-report" id="step-report-btn">
              Report
            </a>
          </li>
          <li>
            <a class="nav-link" href="#step-labor" id="step-labor-btn">
              Labor
            </a>
          </li>
          <li>
            <a class="nav-link" href="#step-payment" id="step-payment-btn">
              Payment
            </a>
          </li>
          <li>
            <a class="nav-link" href="#step-history" id="step-history-btn">
              History
            </a>
          </li>
          <li></li>
        </ul>
        
        <div class="tab-content">
          
          <div id="step-workorder" class="tab-pane " role="tabpanel">
            
            <div class="card-body">
              <h4 class="font-20 mb-30">Workorder</h4>
              <form action="{{ url('/workorders/workorder/'.$workorder_id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-lg-6 border-right">
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">Workorder ID</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="number" class="theme-input-style" readonly name="workorder_id" value="{{ $workorder_id }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold" for="billing_add">Billing Address</label>
                      </div>
                      <div class="col-sm-9">
                        <select class="search-select" name="billing_address" id="wo_billing_address">
                          <option value="">Select Billing Address</option>
                          @if (isset($all_billing_address))
                          @foreach ($all_billing_address as $billing_address)
                          <option value="{{ $billing_address->billing_address_id }}" 
                            {{ $woBilling_address == $billing_address->billing_address_id ? 'selected' : '' }}>
                            {{ $billing_address->name }}
                          </option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">Order Date</label>
                      </div>
                      <div class="col-sm-9">
                        <!-- Date Picker -->
                        <div class="dashboard-date style--four">
                          <span class="input-group-addon">
                            <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
                          </span>
                          <input type="text" class="simple-date-picker" placeholder="Select Date" name="date_received" value="{{ $date_received }}"/>
                        </div>
                        <!-- End Date Picker -->
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">PO#</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="number" class="theme-input-style" name="po_num" value="{{ $po_num }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">Reference#</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="reference_num" value="{{ $reference_num }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">Branch</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="branch" value="{{ $branch }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">Country</label>
                      </div>
                      <div class="col-sm-9">
                        <select class="search-select" name="country">
                          <option value="">Select Country</option>
                          @if (isset($countries))
                          @foreach ($countries as $country)
                          <option value="{{ $country->name }}" {{ $country->name == $woCountry ? 'selected' : '' }}>
                            {{ $country->name }}
                          </option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">SECP# (If Any)</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="serial_num" value="{{ $serial_num }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold" for="address">Address</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea id="address" class="theme-input-style style--three" name="problem_desc">{{ $problem_desc }}</textarea>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2"> 
                      <div class="col-sm-3">
                        <label class="font-14 bold">Deliver Date</label>
                      </div>
                      <div class="col-sm-9">
                        <!-- Date Picker -->
                        <div class="dashboard-date style--four">
                          <span class="input-group-addon">
                            <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg">
                          </span>
                          <input type="text" class="simple-date-picker" placeholder="Select Date" name="date_delivered" value="{{ $date_delivered }}"/>
                        </div>
                        <!-- End Date Picker -->
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">Amount Due</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="amount_due" readonly value="{{ $amount_due }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-9 offset-sm-3">
                        <div class="d-flex align-items-center">
                          <label class="custom-checkbox position-relative mr-2">
                            <input type="checkbox" id="hard_copy" name="hardcopy_delivered" {{ $hardcopy_delivered ? 'checked' : '' }} >
                            <span class="checkmark"></span>
                          </label>
                          <label for="hard_copy">Hard Copy Delivered</label>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  
                  <div class="col-lg-6">
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold">Company</label>
                      </div>
                      <div class="col-sm-9">
                        <select class="search-select" name="company_id" id="wo_company_id">
                          <option value="">Select Company</option>
                          @if (isset($company))
                          @foreach ($company as $com)
                          <option value="{{ $com->company_id }}" {{ $com->company_id == $company_id ? 'selected' : '' }}>
                            {{ $com->name }}
                          </option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Contact Person</label>
                      </div>
                      <div class="col-sm-9">
                        <select class="search-select" name="contact_person" id="wo_contact_person">
                          <option value="">Select Contact Person</option>
                          @if (isset($customer_info))
                          @foreach ($customer_info as $contact)
                          <option value="{{ $contact->child_id }}" {{ $contact->child_id == $contact_person ? 'selected' : '' }}>
                            {{ $contact->first_name.''.$contact->last_name }}
                          </option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3" for="postal_address">Postal Address</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea id="postal_address" class="theme-input-style style--three" name="postal_address">{{ $postal_address }}</textarea>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Report Name</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="report_name" value="{{ $report_name }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Vendor</label>
                      </div>
                      <div class="col-sm-9">
                        <select class="search-select" name="vendor_id">
                          <option value="">Select Vendor</option>
                          @if (isset($vendor))
                          @foreach ($vendor as $ven)
                          <option value="{{ $ven->vendor_id }}" {{ $ven->vendor_id == $vendor_id ? 'selected' : '' }}>
                            {{ $ven->name }}
                          </option>
                          @endforeach
                          @endif
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Subtotal</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" readonly name="subtotal" 
                        value="{{ $sub_total }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Discount %</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="number" class="theme-input-style" name="discount" 
                        value="{{ $discount }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-9 offset-sm-3">
                        <div class="d-flex align-items-center">
                          <label class="custom-checkbox position-relative mr-2">
                            <input type="checkbox" id="taxable_invoice" {{ $sales_tax_rate > 0 ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                          </label>
                          <label for="taxable_invoice">Taxable Invoice</label>
                        </div>
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Sales Tax %</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="number" class="theme-input-style" name="sales_tax_rate" readonly 
                        value="{{ $sales_tax_rate }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Sales Tax</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" readonly name="sales_tax" readonly 
                        value="{{ $sales_tax }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Order Total</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="order_total" readonly 
                        value="{{ $order_total }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2">
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Payments</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="" readonly value="{{ $payments }}">
                      </div>
                    </div>
                    
                    <div class="form-row mb-2"> 
                      <div class="col-sm-3">
                        <label class="font-14 bold mb-3">Financial</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="theme-input-style" name="financial" value="{{ $financial }}">
                      </div>
                    </div>
                    
                  </div>
                  
                  <div class="col-12">
                    <div class="form-row">
                      <div class="col-12 text-right py-3">
                        <button type="submit" class="btn long">Update</button>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </form>
            </div>
          </div>
          
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
              @if (count($workorder_parts) > 0)
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
                  </tbody>
                </table>
              </div>
              @endif
            </div>
            {!! $workorder_parts->links('pagination::bootstrap-5') !!}
          </div> 
          
          <div id="step-report" class="tab-pane" role="tabpanel">
            <div class="card-body px-0">
              <div class="d-flex justify-content-between px-3">
                <div class="title-content">
                  <h4 class="font-20 mb-2">Report</h4>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <!-- Dropzone Start -->
                  <form action="#" id="dropzone01" class="dropzone" method="post" enctype="multipart/form-data">
                    <div class="d-flex justify-content-center flex-column align-items-center align-self-center" data-dz-message>
                      <div class="dz-message bold c2 font-20 mb-3">Click or Drop files here to upload.</div>
                      <div class="upload-icon">
                        <img src="{{ asset('assets/img/svg/upload-down.svg') }}" alt="" class="svg">
                      </div>
                    </div>
                  </form>
                  <!-- Dropzone End -->
                </div>
                <div class="col-">
                  
                </div>
              </div>
            </div>
          </div>
          
          <div id="step-labor" class="tab-pane" role="tabpanel">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="title-content">
                  <h4 class="font-20 mb-2">Labor</h4>
                </div>
                <div>
                  <a href="" data-toggle="modal" data-target="#labor_add_modal" type="button" class="btn btn-secondary px-3 py-2">Add Labor</a>
                </div>
              </div>
              @if (count($workorder_labors) > 0)
              <div class="table-responsive">
                <table class="text-nowrap invoice-list">
                  <thead>
                    <tr>
                      <th>SR#</th>
                      <th>Technician</th>
                      <th>Billable Hours</th>
                      <th>Billing Rate</th>
                      <th>Comments</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($workorder_labors as $workorder_labor)
                    <tr>
                      <td>
                        {{ (($workorder_labors->currentPage() -1) * $workorder_labors->perPage()) + $loop->index + 1 }}
                      </td>
                      <td>{{ $workorder_labor->first_name.' '.$workorder_labor->last_name }}</td>
                      <td>{{ $workorder_labor->billable_hours }}</td>
                      <td>{{ $workorder_labor->hourly_rate }}</td>
                      <td>{{ $workorder_labor->comments }}</td>
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
                            <a href="" data-toggle="modal" data-target="#labor_edit_modal_{{ $workorder_labor->wo_labor_id }}">Edit</a>
                            
                            <a href="" data-toggle="modal" data-target="#labor_delete_modal_{{ $workorder_labor->wo_labor_id }}">Delete</a>
                          </div>
                        </div>
                        <!-- End Dropdown Button -->
                      </td>
                    </tr>
                    <!-- Modal Edit Labor -->
                    <div class="modal fade" id="labor_edit_modal_{{ $workorder_labor->wo_labor_id }}" tabindex="-1" role="dialog" aria-labelledby="labor_edit_label" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="labor_edit_label">Update Labor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="{{ url('/workorders/labor/'.$workorder_labor->wo_labor_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="workorder_id" value="{{ $workorder_id }}">
                            <div class="modal-body">
                              <div class="row edit-labor-parent">
                                <div class="col-12">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label d-block">Technician</label>
                                    <select class="search-select-w-100 get-labor-price" name="technician_id">
                                      <option value="">Select Technician</option>
                                      @if (isset($employee_list))
                                      @foreach ($employee_list as $employee)
                                      <option value="{{ $employee->employee_id }}" {{ ($workorder_labor->employee_id == $employee->employee_id) ? 'selected' : '' }} >
                                        {{ $employee->first_name.' '.$employee->last_name }}
                                      </option>
                                      
                                      @endforeach
                                      @endif
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Billable Hours</label>
                                    <input type="number" class="form-control" required name="billable_hours" value="{{ $workorder_labor->billable_hours }}">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Billing Rate</label>
                                    <input type="number" class="form-control get-unit_price" required name="hourly_rate" value="{{ $workorder_labor->hourly_rate }}">
                                  </div>
                                </div>
                                <div class="col-sm-12">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Comments</label>
                                    <textarea class="theme-input-style style--three" name="comments">{{ $workorder_labor->comments }}</textarea>
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
                    <div class="modal fade" id="labor_delete_modal_{{ $workorder_labor->wo_labor_id }}" tabindex="-1" role="dialog" aria-labelledby="vendor_delete_label" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <form action="{{ url('/workorders/labor/'.$workorder_labor->wo_labor_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                              <h4>Are you sure, you want to Delete this Labor?</h4>
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
              </div>
              @endif
            </div>
            {!! $workorder_labors->links('pagination::bootstrap-5') !!}
          </div>
          
          <div id="step-payment" class="tab-pane" role="tabpanel">
            <div class="card-body px-0">
              <div class="d-flex justify-content-between px-3">
                <div class="title-content">
                  <h4 class="font-20 mb-2">Payment</h4>
                </div>
                <div>
                  <a href="" data-toggle="modal" data-target="#payment_add_modal" type="button" class="btn btn-secondary px-3 py-2">Add Payment</a>
                </div>
              </div>
              @if (count($workorder_payments) > 0)
              <div class="table-responsive">
                <table class="text-nowrap invoice-list">
                  <thead>
                    <tr>
                      <th style="padding-left: 30px;">SR#</th>
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
                    @foreach ($workorder_payments as $workorder_payment)
                    <tr>
                      <td style="padding-left: 30px;">
                        {{ (($workorder_payments->currentPage() -1) * $workorder_payments->perPage()) + $loop->index + 1 }}
                      </td>
                      <td>{{ $workorder_payment->name }}</td>
                      <td>{{ \Carbon\Carbon::parse($workorder_payment->payment_date)->format('d-m-Y') }}</td>
                      <td>{{ $workorder_payment->payment_amount }}</td>
                      <td>{{ $workorder_payment->bank_name }}</td>
                      <td>{{ $workorder_payment->cheque_num }}</td>
                      <td>{{ \Carbon\Carbon::parse($workorder_payment->cheque_date)->format('d-m-Y') }}</td>
                      <td>{{ $workorder_payment->cheque_amount }}</td>
                      <td class="font-weight-bold {{ $workorder_payment->received == 1 ? 'text-success' : 'text-danger' }}">
                        {{ $workorder_payment->received == 1 ? 'Yes' : 'No' }}
                      </td>
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
                            <a href="" data-toggle="modal" data-target="#payment_edit_modal_{{ $workorder_payment->payment_id }}">Edit</a>
                            
                            <a href="" data-toggle="modal" data-target="#payment_delete_modal_{{ $workorder_payment->payment_id }}">Delete</a>
                          </div>
                        </div>
                        <!-- End Dropdown Button -->
                      </td>
                    </tr>
                    <!-- Modal Edit Payment -->
                    <div class="modal fade" id="payment_edit_modal_{{ $workorder_payment->payment_id }}" tabindex="-1" role="dialog" aria-labelledby="payment_edit_label" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="payment_edit_label">Update Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="{{ url('/workorders/payment/'.$workorder_payment->payment_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="workorder_id" value="{{ $workorder_id }}">
                            <div class="modal-body">
                              <div class="row edit-payment-parent">
                                <div class="col-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label d-block">Payment Method</label>
                                    <select class="search-select-w-100 get-payment-price" name="payment_method_id">
                                      <option value="">Select Payment Method</option>
                                      @if (isset($payment_method_list))
                                      @foreach ($payment_method_list as $payment_method)
                                      <option value="{{ $payment_method->payment_method_id }}" {{ ($payment_method->payment_method_id == $workorder_payment->payment_method_id) ? 'selected' : '' }} >
                                        {{ $payment_method->name }}
                                      </option>
                                      
                                      @endforeach
                                      @endif
                                    </select>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Payment Amount</label>
                                    <input type="number" class="form-control" required name="payment_amount" 
                                    value="{{ $workorder_payment->payment_amount }}">
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
                                      <input type="text" class="simple-date-picker" placeholder="Select Date" autocomplete="off" name="payment_date" 
                                      value="{{ \Carbon\Carbon::parse($workorder_payment->payment_date)->format('d-m-Y') }}"/>
                                    </div>
                                    <!-- End Date Picker -->
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
                                      <input type="text" class="simple-date-picker" placeholder="Select Date" autocomplete="off" name="cheque_date" 
                                      value="{{ \Carbon\Carbon::parse($workorder_payment->cheque_date)->format('d-m-Y') }}"/>
                                    </div>
                                    <!-- End Date Picker -->
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" value="{{ $workorder_payment->bank_name }}">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Cheque#</label>
                                    <input type="text" class="form-control" name="cheque_num" value="{{ $workorder_payment->cheque_num }}">
                                  </div>
                                </div>
                                
                                <div class="col-sm-6">
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Amount</label>
                                    <input type="number" class="form-control" name="cheque_amount" value="{{ $workorder_payment->cheque_amount }}">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <label for="message-text" class="col-form-label">Received</label>
                                  <!-- Switch -->
                                  <label class="switch with-icon">
                                    <input type="checkbox" name="received" {{ $workorder_payment->received == 1 ? 'checked' : '' }}>
                                    <span class="control">
                                      <span class="check"></span>
                                    </span>
                                  </label>
                                  <!-- End Switch -->
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
                    <div class="modal fade" id="payment_delete_modal_{{ $workorder_payment->payment_id }}" tabindex="-1" role="dialog" aria-labelledby="payment_delete_label" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <form action="{{ url('/workorders/payment/'.$workorder_payment->payment_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                              <h4>Are you sure, you want to Delete this Payment?</h4>
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
              </div>
              @endif
            </div>
            {!! $workorder_labors->links('pagination::bootstrap-5') !!}
          </div>
          
          <div id="step-history" class="tab-pane" role="tabpanel">
            <div class="card-body px-0">
              <div class="d-flex justify-content-between px-3">
                <div class="title-content">
                  <h4 class="font-20 mb-2">History</h4>
                </div>
              </div>
              @if (strlen($company_id) > 0)
              <div class="table-responsive">
                <table class="">
                  <thead>
                    <tr>
                      <th>SR#</th>
                      <th>Company</th>
                      <th>PO#</th>
                      <th>Report Name</th>
                      <th>Date Received</th>
                      <th>Date Required</th>
                    </tr>
                  </thead>
                  <tbody id="history_wrap">
                  </tbody>
                </table>
              </div>
              @endif
            </div>
          </div>
          
        </div>
        
      </div>
      
    </div>
    
  </div>
</div>

<!-- Modal Add Part  -->
<div class="modal fade" id="part_add_modal" tabindex="-1" role="dialog" aria-labelledby="part_add_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="part_add_label">Add Part In Workorder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/workorders/parts') }}" method="POST">
        @csrf
        <input type="hidden" name="workorder_id" value="{{ $workorder_id }}">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="message-text" class="col-form-label d-block">Product</label>
                <select class="search-select-w-100" name="part_id" id="add-product">
                  <option value="">Select Product</option>
                  @if (isset($parts_list))
                  @foreach ($parts_list as $part)
                  <option value="{{ $part->part_id }}">
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
                <input class="form-control" type="number" required name="quantity" id="add-product_qty">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="message-text" class="col-form-label">Unit Price</label>
                <input class="form-control" type="number" required name="unit_price" id="add-product_up">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="message-text" class="col-form-label">US$</label>
                <input class="form-control" type="number" required name="us_price" value="0">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="message-text" class="col-form-label">Ex. Rate</label>
                <input class="form-control" type="number" required name="exchange_rate" value="0">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Part</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Add Labor  -->
<div class="modal fade" id="labor_add_modal" tabindex="-1" role="dialog" aria-labelledby="labor_add_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labor_add_label">Add Labor In Workorder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/workorders/labors') }}" method="POST">
        @csrf
        <input type="hidden" name="workorder_id" value="{{ $workorder_id }}">
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="message-text" class="col-form-label d-block">Technician</label>
                <select class="search-select-w-100" name="technician_id" id="add-employee">
                  <option value="">Select Technician</option>
                  @if (isset($employee_list))
                  @foreach ($employee_list as $employee)
                  <option value="{{ $employee->employee_id }}">
                    {{ $employee->first_name.' '.$employee->last_name }}
                  </option>
                  
                  @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="message-text" class="col-form-label">Billable Hours</label>
                <input class="form-control" type="number" required name="billable_hours" id="add-employee_bh" value="0">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="message-text" class="col-form-label">Billing Rate</label>
                <input class="form-control" type="number" required name="hourly_rate" id="add-employee_br" value="0">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <label for="message-text" class="col-form-label">Comments</label>
                <textarea class="theme-input-style style--three" name="comments"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Labor</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Add Payment  -->
<div class="modal fade" id="payment_add_modal" tabindex="-1" role="dialog" aria-labelledby="payment_add_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payment_add_label">Add Payment In Workorder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/workorders/payments') }}" method="POST">
        @csrf
        <input type="hidden" name="workorder_id" value="{{ $workorder_id }}">
        <div class="modal-body">
          <div class="row edit-payment-parent">
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
                <label for="message-text" class="col-form-label">Payment Amount</label>
                <input type="number" class="form-control" required name="payment_amount" value="{{ $amount_due}}">
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
                <label for="message-text" class="col-form-label">Bank Name</label>
                <input type="text" class="form-control" name="bank_name">
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
                <label for="message-text" class="col-form-label">Amount</label>
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
          <button type="submit" class="btn btn-primary">Add Labor</button>
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

<script src="{{ asset('assets/plugins/jquery-smartwizard/jquery.smartWizard.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-smartwizard/custom-smartWizard.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.steps/custom-jquery-step.js') }}"></script>

<script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dropzone/dropzone.custom.js') }}"></script>

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
    
    $('#wo_company_id').change(function() {
      var url = "{{url('/get-company-addresses')}}";
      $.ajax({
        type:'GET',
        url: url,
        data: {
          wo_company_id: $(this).val(),
        },
        success:function(data) {
          $('#wo_billing_address').empty();
          $('#wo_contact_person').empty();
          
          var defaultOption1 = new Option('Select Billing Address', '', false, false);
          $('#wo_billing_address').append(defaultOption1).trigger('change');
          
          var defaultOption2 = new Option('Select Contact Person', '', false, false);
          $('#wo_contact_person').append(defaultOption2).trigger('change');
          
          $(data.response).each(function(i) {
            var newOption = new Option(data.response[i]['name'], data.response[i]['billing_address_id'], false, false);
            $('#wo_billing_address').append(newOption).trigger('change');
          });
        }
      });
    });
    
    $('#wo_billing_address').change(function() {
      if($(this).val() != '') {
        var url = "{{url('/get-company-persons')}}";
        $.ajax({
          type:'GET',
          url: url,
          data: {
            wo_company_id: $('#wo_company_id').val(),
            wo_billing_address_id: $(this).val(),
          },
          success:function(data) {
            $('#wo_contact_person').empty();
            var defaultOption = new Option('Select Contact Person', '', false, false);
            $('#wo_contact_person').append(defaultOption).trigger('change');
            $(data.response).each(function(i) {
              var newOption = new Option(
              ((data.response[i]['first_name']) == null || (data.response[i]['first_name']) == '' ? '' : data.response[i]['first_name'])+' '+((data.response[i]['last_name']) == null || (data.response[i]['last_name']) == '' ? '' : data.response[i]['last_name']), 
              data.response[i]['child_id'], 
              false, 
              false
              );
              $('#wo_contact_person').append(newOption).trigger('change');
            });
          }
        });
      }
    });
    
    $('#step-history-btn').click(function() {
      // console.log($('#wo_company_id').val()+' wo_company_id');
      // console.log($('#wo_billing_address').val()+' wo_billing_address');
      var url = "{{url('/get-company-history')}}";
      $.ajax({
        type:'GET',
        url: url,
        data: {
          wo_company_id: $('#wo_company_id').val(),
          wo_billing_address_id: $('#wo_billing_address').val()
        },
        success:function(data) {
          // console.log(data.response);
          $(data.response).each(function(i) {
            $('#history_wrap').append(`
            <tr>
              <td>`+ parseInt(i+1) +`</td>
              <td class="text-nowrap">`+(data.company_name['name'])+`</td>
              <td>`+(data.response[i]['po_num'])+`</td>
              <td>`+(data.response[i]['report_name'])+`</td>
              <td>`+(data.response[i]['date_received'])+`</td>
              <td>`+(data.response[i]['date_delivered'])+`</td>
            </tr>
            `);
          });
        }
      });
    });
    
    $('#add-product').change(function() {
      var url = "{{url('/get-product')}}";
      $.ajax({
        type:'GET',
        url: url,
        data: {
          part_id: $(this).val(),
        },
        success:function(data) {
          $("#add-product_up").val(data.msg[0]['unit_price']);
          $('#add-product_qty').val(1);
        }
      });
    });
    
    $('.get-part-price').change(function() {
      let parent = $(this).closest(".edit-part-parent");
      var url = "{{url('/get-product')}}";
      $.ajax({
        type:'GET',
        url: url,
        data: {
          part_id: $(this).val(),
        },
        success:function(data) {
          parent.find(".get-unit_price").val(data.msg[0]['unit_price']);
        }
      });
    });
    
    // $('#step-parts-btn').click(function() {
      //   console.log($('#workorder_id').val());
      //   $.ajax({
        //     type:'GET',
        //     url:'/get-workorder-products',
        //     data: {
          //       workorder_id: $('#workorder_id').val(),
          //     },
          //     success:function(data) {
            //       // parent.find(".get-unit_price").val(data.msg[0]['unit_price']);
            //       // $('#wo_products_qty').val(1);
            //       console.log(data.msg[0]['unit_price']);
            //     }
            //   });
            // });
            
          });
        </script>
        @endsection