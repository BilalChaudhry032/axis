@extends('layouts.master')
@section('content')

<div class="row">
   <div class="col-xl-12">
      
      <div class="card mb-30">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between align-items-center">
               <div class="title-content">
                  <h4 class="mb-2">Settings</h4>
               </div>
               <div>
                  <a href="{{ url('/workorders/create') }}" type="button" class="btn btn-secondary px-3 py-2">New Workorder</a>
               </div>
            </div>
         </div>


      </div>
   </div>
</div>

@endsection