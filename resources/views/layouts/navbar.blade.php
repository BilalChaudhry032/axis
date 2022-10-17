
<header class="header white-bg fixed-top d-flex align-content-center flex-wrap" style="height: 60px">
   <!-- Logo -->
   <div class="logo" style="height: 60px; padding: 0 20px; flex-basis: 115px;">
      <a href="{{ url('/') }}" class="default-logo"><img src="{{ asset('assets/logo.png') }}" alt=""></a>
      <a href="{{ url('/') }}" class="mobile-logo"><img src="{{ asset('assets/logo.png') }}" alt=""></a>
   </div>
   <!-- End Logo -->

   <!-- Main Header -->
   <div class="main-header">
      <div class="container-fluid">
         <div class="row justify-content-between">
            <div class="col-3 col-lg-1 col-xl-4">
               <!-- Header Left -->
               <div class="main-header-left h-100 d-flex align-items-center">
                  <!-- Main Header Menu -->
                  <div class="main-header-menu d-block d-lg-none">
                     <div class="header-toogle-menu">
                        <!-- <i class="icofont-navigation-menu"></i> -->
                        <img src="{{ asset('assets/img/menu.png') }}" alt="">
                     </div>
                  </div>
                  <!-- End Main Header Menu -->
               </div>
               <!-- End Header Left -->
            </div>
            <div class="col-9 col-lg-11 col-xl-8">
               <!-- Header Right -->
               <div class="main-header-right d-flex justify-content-end">
                  <ul class="nav">
                     <li class="d-none d-lg-flex">
                        <!-- Main Header Time -->
                        <div class="main-header-date-time text-right">
                           <h3 class="time text-transform-none">
                              {{-- <span id="hours">21</span>
                              <span id="point">:</span>
                              <span id="min">06</span> --}}
                              <span id="time-12h">00 : 00</span>
                           </h3>
                           <span class="date"><span id="date">Tue, 12 October 2019</span></span>
                        </div>
                        <!-- End Main Header Time -->
                     </li>
                     @if(isset($AuthUser))
                        <li class="ml-5">
                           <span>Welcome, {{ $AuthUser['uname'] }} | <a href="{{ url('/logout') }}">Logout</a></span>
                        </li>
                     @endif
                  </ul>
               </div>
               <!-- End Header Right -->
            </div>
         </div>
      </div>
   </div>
   <!-- End Main Header -->
</header>
