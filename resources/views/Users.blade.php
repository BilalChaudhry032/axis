@extends('layouts.master')
@section('content')
<div class="row">
   <div class="col-xl-12">
      <!-- Card -->
      <div class="card">
         <div class="card-body pb-0">
            <div class="d-flex justify-content-between">
               <div class="title-content mb-4">
                  <h4 class="mb-2">Users</h4>
                  <p class="font-14">Tell use paid law ever yet new. Meant to learn of vexed if style allow he there.</p>
               </div>

               <!-- Dropdown Button -->
               <div class="dropdown-button">
                  <a href="#" class="d-flex align-items-center" data-toggle="dropdown">
                     <div class="menu-icon style--two mr-0 d-flex justify-content-center">
                        <span></span>
                        <span></span>
                        <span></span>
                     </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                     <a href="#">Report</a>
                     <a href="#">FAQ</a>
                     <a href="#">Charts</a>
                     <a href="#">Chat</a>
                     <a href="#">Settings</a>
                  </div>
               </div>
               <!-- End Dropdown Button -->
            </div>
         </div>
               
         <div class="table-responsive">
            <table class="style--three table-centered text-nowrap">
               <thead>
                  <tr>
                     <th>Order ID <img src="assets/img/svg/table-down-arrow.svg" alt="" class="svg"></th>
                     <th>Date <img src="assets/img/svg/table-down-arrow.svg" alt="" class="svg"></th>
                     <th>Products</th>
                     <th>Buyer Name <img src="assets/img/svg/table-up-arrow.svg" alt="" class="svg"></th>
                     <th>Status <img src="assets/img/svg/table-down-arrow.svg" alt="" class="svg"></th>
                     <th>Price</th>
                     <th>Shipping Cost</th>
                     <th>Total Cost</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td class="bold">#01254</td>
                     <td>12 Oct 2019</td>
                     <td>
                        <div class="product-img">
                           <img src="assets/img/product/product1.png" alt="">
                           <img src="assets/img/product/product5.png" alt="">
                           <img src="assets/img/product/product6.png" alt="">
                        </div>
                     </td>
                     <td>Kyle Lee</td>
                     <td class="text-danger">Processing</td>
                     <td class="bold">$2456.4</td>
                     <td class="bold">$24.6</td>
                     <td class="bold">2687</td>
                     <td><button type="button" class="details-btn">Details <i class="icofont-arrow-right"></i></button></td>
                  </tr>

                  <tr>
                     <td class="bold">#01365</td>
                     <td>12 Oct 2019</td>
                     <td>
                        <div class="product-img">
                           <img src="assets/img/product/product2.png" alt="">
                           <img src="assets/img/product/product7.png" alt="">
                           <img src="assets/img/product/product3.png" alt="">
                        </div>
                     </td>
                     <td>Lindo De Sire</td>
                     <td class="text-warning">Shipped</td>
                     <td class="bold">$2456.4</td>
                     <td class="bold">$24.6</td>
                     <td class="bold">2687</td>
                     <td><button type="button" class="details-btn">Details <i class="icofont-arrow-right"></i></button></td>
                  </tr>

                  <tr>
                     <td class="bold">#03654</td>
                     <td>11 Oct 2019</td>
                     <td>
                        <div class="product-img">
                           <img src="assets/img/product/product8.png" alt="">
                           <img src="assets/img/product/product9.png" alt="">
                           <img src="assets/img/product/product10.png" alt="">
                        </div>
                     </td>
                     <td>Laturi Yasn</td>
                     <td class="text-success">Delivered</td>
                     <td class="bold">$2456.4</td>
                     <td class="bold">$24.6</td>
                     <td class="bold">2687</td>
                     <td><button type="button" class="details-btn">Details <i class="icofont-arrow-right"></i></button></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <!-- End Card -->
   </div>
</div>
@endsection