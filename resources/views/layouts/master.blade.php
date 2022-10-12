<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <!-- Page Title -->
   <title>Axis</title>

   <meta name="csrf-token" content="{{ csrf_token() }}" />
   <!-- Meta Data -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta http-equiv="content-type" content="text/html; charset=utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="keywords" content="">

   <!-- Favicon -->
   <link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">

   <!-- Web Fonts -->
   <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">
   
   <!-- ======= BEGIN GLOBAL MANDATORY STYLES ======= -->
   <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/fonts/icofont/icofont.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }}">
   <!-- ======= END BEGIN GLOBAL MANDATORY STYLES ======= -->

   <link rel="stylesheet" href="{{ asset('assets/plugins/dataTables/dataTables.bootstrap4.min.css') }}">

   <!-- ======= BEGIN PAGE LEVEL PLUGINS STYLES ======= -->
   @yield('pageCSS')
   <!-- ======= END BEGIN PAGE LEVEL PLUGINS STYLES ======= -->

   <!-- ======= MAIN STYLES ======= -->
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   <!-- ======= END MAIN STYLES ======= -->

</head>

<body>

   @if($message = Session::get('message'))
      <div class="alert alert-primary alert-dismissible fade show" role="alert" style="position: fixed; right: 15px; top: 70px; z-index: 9999;">
         {{ $message }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
   @endif

   <!-- Offcanval Overlay -->
   <div class="offcanvas-overlay"></div>
   <!-- Offcanval Overlay -->
   @php
      $AuthUser = Session::get('user-session');
   @endphp
   <!-- Wrapper -->
   <div class="wrapper">

      <!-- Header -->
         @include('layouts.navbar')
      <!-- End Header -->

      <!-- Main Wrapper -->
      <div class="main-wrapper">
         <!-- Sidebar -->
         @include('layouts.sidebar')
         <!-- End Sidebar -->

         <!-- Main Content -->
         <div class="main-content" style="min-height: calc(100vh - 160px); margin-top: 80px;">
            <div class="container-fluid">
               @yield('content')
            </div>
         </div>
         <!-- End Main Content -->
      </div>
      <!-- End Main Wrapper -->

      <!-- Footer -->
      {{-- <footer class="footer">
         Dashmin © 2020 created by <a href="https://www.themelooks.com/"> ThemeLooks</a>
      </footer> --}}
      <!-- End Footer -->
   </div>
   <!-- End wrapper -->


   
   <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
   <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
   <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
   <script src="{{ asset('assets/js/script.js') }}"></script>
   <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->

   <script src="{{ asset('assets/plugins/dataTables/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('assets/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

   <!-- ======= BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
   @yield('pageScript')
   <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->

   <script>
      $(document).ready(function() {
         // show the alert
         setTimeout(function() {
            $(".alert").alert('close');
         }, 5000);
      });
   </script>

</body>

</html>