@extends('layouts.master')

@section('pageCSS')


@endsection

@section('content')

<div class="d-flex flex-column flex-md-row">
   <div class="mb-4 mb-md-0">
      <!-- Tasks Aside -->
      <div class="aside">
         <!-- Aside Body -->
         <nav class="aside-body">
            <h4 class="mb-3">System Settings</h4>
            
            <ul class="nav flex-column">
               <li><a class="active" data-toggle="tab" href="#usd_exc">Dollar Exchange Rate</a></li>
            </ul>
         </nav>
         <!-- End Aside Body -->
      </div>
      <!-- End Tasks Aside -->
   </div>
   <div class="container-fluid">
      <div class="row">
         
         <div class="col-xl-12 mb-30 mb-xl-0">
            <!-- Card -->
            <div class="card h-100">
               <div class="card-body p-30">
                  <div class="tab-content">

                     <div class="tab-pane fade show active" id="usd_exc">
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="title-content mb-2">
                              <h4 class="mb-2">Dollar Exchange Rate</h4>
                           </div>
                           <div></div>
                        </div>
                        
                        <form action="{{ url('/usd-exc-rate') }}" method="post">
                           @csrf
                           @method('PUT')

                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <label class="font-14 bold">Today's USD Exchange Rate</label>
                                    <input type="text" class="theme-input-style" name="usd_exc_rate" value="{{ $to_pkr }}">
                                 </div>
                              </div>
                              <div class="col-lg-6 text-right py-3">
                                 <button type="submit" class="btn long">Update</button>
                              </div>
                           </div>

                        </form>
                     </div>
                     
                  </div>
               </div>
               <!-- End Card -->
            </div>
            
         </div>
      </div>
   </div>
</div>
   @endsection
   
@section('pageScript')

@endsection