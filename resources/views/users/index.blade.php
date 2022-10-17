@extends('layouts.master')

@section('pageCSS')
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">

<style>
   input[readonly] {
      cursor: not-allowed;
   }
</style>

@endsection

@section('content')

<div class="d-flex flex-column flex-md-row">
   <div class="mb-4 mb-md-0">
      <!-- Tasks Aside -->
      <div class="aside">
         <!-- Aside Body -->
         <nav class="aside-body">
            <h4 class="mb-3">Users Settings</h4>
            
            <ul class="nav flex-column">
               <li><a class="active" data-toggle="tab" href="#user_list">Users</a></li>
               <li><a data-toggle="tab" href="#user_rights">Users Rights</a></li>
               <li><a data-toggle="tab" href="#page_rights">Page Rights</a></li>
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
                     <div class="tab-pane fade show active" id="user_list">
                        <div class="d-flex justify-content-between align-items-center">
                           <div class="title-content">
                              <h4 class="mb-2">Users</h4>
                           </div>
                           <div>
                              <a href="" data-toggle="modal" data-target="#user_create_modal" type="button" class="btn btn-secondary px-3 py-2">New User</a>
                           </div>
                        </div>
                        
                        <div class="table-responsive">
                           <table class="text-nowrap" id="users_table">
                              <thead>
                                 <tr>
                                    <th style="width: 100px">
                                       SR#
                                    </th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th class="text-right">Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                           <!-- End Invoice List Table -->
                        </div>
                     </div>
                     
                     <div class="tab-pane fade" id="user_rights">
                        <h4 class="mb-3">User Rights</h4>
                        
                        <div class="row">
                           <div class="col-lg-6 col-xl-4">
                              <div class="form-row mb-5">
                                 <label class="font-14 bold">Users</label>
                                 <select class="search-select" name="user_id" id="user_select">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->name.' ('.$user->username.')'}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-lg-4 offset-lg-2" id="page_list">
                              <div class="row">
                                 @foreach ($pages as $page)
                                 <div class="col-sm-12">
                                    <div class="d-flex align-items-center mb-4">
                                       <div class="switch-wrap">
                                          <!-- Switch -->
                                          <label class="switch">
                                             <input type="checkbox" class="" value="{{ $page->page_id }}" disabled>
                                             <span class="control"></span>
                                          </label>
                                          <!-- End Switch -->
                                       </div>
                                       <span>{{ $page->name }}</span>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </div>
                        
                        
                     </div>
                     
                     <div class="tab-pane fade" id="page_rights">
                        <h4 class="mb-3">Page Rights</h4>
                        
                        <div class="row">
                           <div class="col-lg-6 col-xl-4">
                              <div class="form-row mb-5">
                                 <label class="font-14 bold">Users</label>
                                 <select class="search-select" name="user_id" id="user_select2">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->name.' ('.$user->username.')'}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-lg-4 offset-lg-2" id="page_list2">
                              <div class="row">
                                 @foreach ($buttons as $button)
                                 <div class="col-sm-12">
                                    <div class="d-flex align-items-center mb-4">
                                       <div class="switch-wrap">
                                          <!-- Switch -->
                                          <label class="switch">
                                             <input type="checkbox" class="" value="{{ $button->button_id }}" disabled>
                                             <span class="control"></span>
                                          </label>
                                          <!-- End Switch -->
                                       </div>
                                       <span>{{ $button->name }}</span>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </div>
                        
                     </div>
                  </div>
               </div>
               <!-- End Card -->
            </div>
            
         </div>
      </div>
   </div>
   
   <!-- Modal Create -->
   <div class="modal fade" id="user_create_modal" tabindex="-1" role="dialog" aria-labelledby="user_create_label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="user_create_label">Add New User</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form action="{{ url('/user') }}" method="POST">
               @csrf
               <div class="modal-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Name</label>
                           <input type="text" class="form-control" required name="name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Username</label>
                           <input type="text" class="form-control" required name="username">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Password</label>
                           <input type="password" class="form-control" required name="password">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Confirm Password</label>
                           <input type="password" class="form-control" required name="password_confirmation">
                           <span class="position-absolute text-danger conf_error" style="display: none"></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary submit_btn">Add User</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   
   <!-- Modal Edit -->
   <div class="modal fade" id="user_edit_modal" tabindex="-1" role="dialog" aria-labelledby="user_edit_label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="user_edit_label">Update User</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form action="" method="POST">
               @csrf
               @method('PUT')
               <div class="modal-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Name</label>
                           <input type="text" class="form-control" required name="name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Username</label>
                           <input type="text" class="form-control" required name="username">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Password</label>
                           <input type="password" class="form-control" name="password">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="message-text" class="col-form-label">Confirm Password</label>
                           <input type="password" class="form-control" name="password_confirmation">
                           <span class="position-absolute text-danger conf_error" style="display: none"></span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary submit_btn">Save changes</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   
   <!-- Modal Delete -->
   <div class="modal fade" id="user_delete_modal" tabindex="-1" role="dialog" aria-labelledby="user_delete_label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <form action="" method="POST">
               @csrf
               @method('DELETE')
               <div class="modal-body">
                  <h4>Are you sure, you want to Delete this User?</h4>
               </div>
               <div class="modal-footer border-0">
                  <button type="button" class="btn btn-secondary bg-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary bg-danger">Delete</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   
   @endsection
   
   @section('pageScript')
   <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
   <script>
      $(document).ready(function() {
         
         $(".search-select").select2({
            dropdownAutoWidth: false,
            width: '100%'
         });
         
         $(function () {
            
            var table = $('#users_table').DataTable({
               processing: true,
               serverSide: true,
               paging: true,
               pageLength: 10,
               ajax: "{{ route('users.list') }}",
               columns: [
               {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
               {data: 'username', name: 'username'},
               {data: 'name', name: 'name'},
               {
                  data: 'action', 
                  name: 'action', 
                  orderable: false, 
                  searchable: false
               },
               ]
            });
            
         });
         
         $('#user_create_modal input[name="password_confirmation"]').on('keyup', function() {
            let pass = $('#user_create_modal input[name="password"]').val();
            if($(this).val() == pass) {
               $('#user_create_modal .submit_btn').prop('disabled', false);
               $('#user_create_modal .conf_error').hide();
            } else {
               $('#user_create_modal .conf_error').text('Your password does not match').show();
               $('#user_create_modal .submit_btn').prop('disabled', true);
            }
         });
         
         $('.table-responsive').on('click', '.user_edit_modal_btn', function(e) {
            e.preventDefault();
            const APP_URL = {!! json_encode(url('/')) !!};
            let id = $(this).attr('id').split('_');
            var url = "{{url('/get-user')}}";
            $.ajax({
               type:'GET',
               url: url,
               data: {
                  user_id: id[1],
               },
               success:function(data) {
                  $('#user_edit_modal form').attr('action', APP_URL+'/user/'+id[1]);
                  $('#user_edit_modal input[name="name"]').val(data.response.name);
                  $('#user_edit_modal input[name="username"]').val(data.response.username);
                  $('#user_edit_modal').modal('show');
               }
            });
         });
         
         $('#user_edit_modal input[name="password"]').on('keyup', function() {
            if($(this).val() != '') {
               $('#user_edit_modal input[name="password_confirmation"]').prop('required', true);
            } else {
               $('#user_edit_modal input[name="password_confirmation"]').prop('required', false);
            }
            
         });
         $('#user_edit_modal input[name="password_confirmation"]').on('keyup', function() {
            let pass = $('#user_edit_modal input[name="password"]').val();
            if($(this).val() == pass) {
               $('#user_edit_modal .submit_btn').prop('disabled', false);
               $('#user_edit_modal .conf_error').hide();
            } else {
               $('#user_edit_modal .conf_error').text('Your password does not match').show();
               $('#user_edit_modal .submit_btn').prop('disabled', true);
            }
         });
         
         $('.table-responsive').on('click', '.user_delete_modal_btn', function(e) {
            e.preventDefault();
            const APP_URL = {!! json_encode(url('/')) !!};
            let id = $(this).attr('id').split('_');
            
            $('#user_delete_modal form').attr('action', APP_URL+'/user/'+id[1]);
            $('#user_delete_modal').modal('show');
         });
         
         $('#user_select').on('change', function() {
            const APP_URL = {!! json_encode(url('/')) !!};
            let id = $(this).val();
            var url = "{{url('/get-page-user')}}";
            if(id) {
               $.ajax({
                  type:'GET',
                  url: url,
                  data: {
                     user_id: id,
                  },
                  success:function(data) {
                     $('#page_list').empty();
                     let html = `<div class="row">`;
                        $(data.pages).each(function(i) {
                           html +=`<div class="col-sm-12">
                              <div class="d-flex align-items-center mb-4">
                                 <div class="switch-wrap">
                                    <label class="switch">
                                       <input type="checkbox" class="" value="`+data.pages[i]['page_id']+`" `;
                                       $(data.isPage).each(function(j) {
                                          if(data.pages[i]['page_id'] == data.isPage[j]['page_id']) {
                                             html +=` checked`;
                                          }
                                       });
                                       html +=`> <span class="control"></span>
                                    </label>
                                 </div>
                                 <span>`+data.pages[i]['name']+`</span>
                              </div>
                           </div>`;
                        });
                        html +=`</div>`;
                        $('#page_list').html(html);
                     }
                  });
               } else {
                  $('#page_list input[type="checkbox"]').prop('disabled', true);
               }
            });

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#user_rights').on('change', '#page_list input[type="checkbox"]', function(e) {
               e.preventDefault();
               let id = $(this).val();
               var url = "{{url('/update-user-rights')}}";
               $.ajax({
                  type:'POST',
                  url: url,
                  data: {
                     _token: CSRF_TOKEN,
                     page_id: id,
                     user_id: $('#user_select').val(),
                     isAllowed: $(this).prop("checked") ? 1 : 0,
                  },
                  success:function(data) {
                     console.log('Success');
                  }
               });
            });

            $('#user_select2').on('change', function() {
            const APP_URL = {!! json_encode(url('/')) !!};
            let id = $(this).val();
            var url = "{{url('/get-button-user')}}";
            if(id) {
               $.ajax({
                  type:'GET',
                  url: url,
                  data: {
                     user_id: id,
                  },
                  success:function(data) {

                     $('#page_list2').empty();
                     let html = `<div class="row">`;
                        $(data.buttons).each(function(i) {
                           html +=`<div class="col-sm-12">
                              <div class="d-flex align-items-center mb-4">
                                 <div class="switch-wrap">
                                    <label class="switch">
                                       <input type="checkbox" class="" value="`+data.buttons[i]['button_id']+`" `;
                                       $(data.isButton).each(function(j) {
                                          if(data.buttons[i]['button_id'] == data.isButton[j]['button_id']) {
                                             html +=` checked`;
                                          }
                                       });
                                       html +=`> <span class="control"></span>
                                    </label>
                                 </div>
                                 <span>`+data.buttons[i]['name']+`</span>
                              </div>
                           </div>`;
                        });
                        html +=`</div>`;
                        $('#page_list2').html(html);
                     }
                  });
               } else {
                  $('#page_list2 input[type="checkbox"]').prop('disabled', true);
               }
            });
            
            $('#page_rights').on('change', '#page_list2 input[type="checkbox"]', function(e) {
               e.preventDefault();
               let id = $(this).val();
               var url = "{{url('/update-button-user')}}";
               $.ajax({
                  type:'POST',
                  url: url,
                  data: {
                     _token: CSRF_TOKEN,
                     button_id: id,
                     user_id: $('#user_select2').val(),
                     isAllowed: $(this).prop("checked") ? 1 : 0,
                  },
                  success:function(data) {
                     console.log('Success');
                  }
               });
            });
            
         });
      </script>
      @endsection