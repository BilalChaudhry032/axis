<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <!-- Page Title -->
   <title>Axis</title>

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

   <!-- ======= MAIN STYLES ======= -->
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   <!-- ======= END MAIN STYLES ======= -->

</head>

<body>

   <!-- Offcanval Overlay -->
   <div class="offcanvas-overlay"></div>
   <!-- Offcanval Overlay -->

   @if($message = Session::get('message'))
      <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert" style="position: absolute; right: 15px; top: 0px; z-index: 9999;">
         {{ $message }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
   @endif

   <div class="vh-100 d-flex align-items-center">
       <div class="container">
           <!-- Card -->
           <div class="card justify-content-center auth-card" style="padding: 100px 30px 100px;">
               <div class="row justify-content-center">
                 <!-- Logo -->
                 <div class="col-12 logo text-center d-block mb-3">
                    <a href="{{ url('/') }}" class="mobile-logo"><img src="{{ asset('assets/logo.png') }}" alt="" style="width: 200px;"></a>
                 </div>
                 <!-- End Logo -->
                 <div class="col-lg-6 col-xl-4">
                     <form action="{{ url('/validate-login') }}" method="POST">
                        @csrf
                         <!-- Form Group -->
                         <div class="form-group mb-20">
                             <label for="username" class="mb-2 font-14 bold black">Username</label>
                             <input type="text" id="username" class="theme-input-style border {{ $errors->has('username') ? 'border-danger' : '' }}" name="username" placeholder="Username">
                             @if ($errors->has('username'))
                                 <span class="font-12 text-danger">{{ $errors->first('username') }}</span>
                             @endif
                         </div>
                         <!-- End Form Group -->
                         
                         <!-- Form Group -->
                         <div class="form-group mb-20">
                             <label for="password" class="mb-2 font-14 bold black">Password</label>
                             <input type="password" id="password" class="theme-input-style border {{ $errors->has('password') ? 'border-danger' : '' }}" name="password" placeholder="********">
                             @if ($errors->has('password'))
                                 <span class="font-12 text-danger">{{ $errors->first('password') }}</span>
                             @endif
                         </div>
                         <!-- End Form Group -->

                         <div class="d-flex align-items-center">
                             <button type="submit" class="btn long mr-20">Log In</button>
                         </div>
                     </form>
                 </div>                                    
               </div>
           </div>
           <!-- End Card -->
       </div>
   </div>

   <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
   <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
   <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
   <script src="{{ asset('assets/js/script.js') }}"></script>
   <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->

   <script>
      $(document).ready(function() {
         // show the alert
         setTimeout(function() {
            $(".alert").alert('close');
         }, 3000);
      });
   </script>

</body>

</html>