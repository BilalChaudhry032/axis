<nav class="sidebar" data-trigger="scrollbar" style="top: 60px; height: calc(100% - 60px);">
   <!-- Sidebar Header -->
   <div class="sidebar-header d-none d-lg-block">
      <!-- Sidebar Toggle Pin Button -->
      {{-- <div class="sidebar-toogle-pin">
         <i class="icofont-tack-pin"></i>
      </div> --}}
      <!-- End Sidebar Toggle Pin Button -->
   </div>
   <!-- End Sidebar Header -->

   <!-- Sidebar Body -->
   <div class="sidebar-body">
      <!-- Nav -->
      <ul class="nav">
         {{-- <li class="{{ Request::is('/') ? 'active' : '' }}">
            <a href="{{ url('/') }}">
               <i class="icofont-pie-chart"></i>
               <span class="link-title">Dashboard</span>
            </a>
         </li> --}}
         <li class="{{ Request::is('workorders') ? 'active' : '' }}">
            <a href="{{ url('/workorders') }}">
               <i class="icofont-shopping-cart"></i>
               <span class="link-title">Workorders</span>
            </a>
         </li>
         <li class="{{ Request::is('payments') ? 'active' : '' }}">
            <a href="{{ url('/payments') }}">
               <i class="icofont-chart-histogram"></i>
               <span class="link-title">Payments</span>
            </a>
         </li>
         <li class="{{ Request::is('customers') ? 'active' : '' }}">
            <a href="{{ url('/customers') }}">
               <i class="icofont-mail-box"></i>
               <span class="link-title">Customers</span>
            </a>
         </li>
         <li class="{{ Request::is('reports') ? 'active' : '' }}">
            <a href="{{ url('/reports') }}">
               <i class="icofont-wechat"></i>
               <span class="link-title">Reports</span>
            </a>
         </li>
         <li class="{{ Request::is('parts') ? 'active' : '' }}">
            <a href="{{ url('/parts') }}">
               <i class="icofont-listing-box"></i>
               <span class="link-title">Parts</span>
            </a>
         </li>
         <li class="{{ Request::is('billing-address') ? 'active' : '' }}">
            <a href="{{ url('/billing-address') }}">
               <i class="icofont-calendar"></i>
               <span class="link-title">Billing Address</span>
            </a>
         </li>
         <li class="{{ Request::is('company') ? 'active' : '' }}">
            <a href="{{ url('/company') }}">
               <i class="icofont-file-document"></i>
               <span class="link-title">Company</span>
            </a>
         </li>
         <li class="{{ Request::is('archived') ? 'active' : '' }}">
            <a href="{{ url('/archived') }}">
               <i class="icofont-contact-add"></i>
               <span class="link-title">Archived</span>
            </a>
         </li>
         <li class="{{ Request::is('users') ? 'active' : '' }}">
            <a href="{{ url('/users') }}">
               <i class="icofont-calendar"></i>
               <span class="link-title">Users</span>
            </a>
         </li>
         <li class="{{ Request::is('vendor') ? 'active' : '' }}">
            <a href="{{ url('/vendor') }}">
               <i class="icofont-files-stack"></i>
               <span class="link-title">Vendor</span>
            </a>
         </li>
      </ul>
      <!-- End Nav -->
   </div>
   <!-- End Sidebar Body -->
</nav>