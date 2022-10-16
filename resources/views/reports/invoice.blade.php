
<html>
<head>
 
 <title>Invoice</title>
 
 <link href="{{ asset('/assets/css/rpt_style.css') }}" type="text/css" rel="stylesheet"/>
 
 <style>
  #box {
   -moz-box-shadow:    3px 3px 5px 5px #FFF;
   -webkit-box-shadow: 3px 3px 5px 5px #FFF;
   box-shadow:         3px 3px 5px 5px #FFF;
  }
  .container1 {
   position: relative;
   text-align: center;
   color: black;
  }
  
  /* Bottom left text */
  .bottom-left {
   position: absolute;
   float: left;
   line-height: 0.3;
   bottom: 8px;
   left: 28px;
  }
  
  /* Top left text */
  .top-left {
   position: absolute;
   top: 19px;
   left: -86px;
  }
  
  /* Top right text */
  .top-right {
   position: absolute;
   top: 8px;
   right: -146px;
  }
  
  /* Bottom right text */
  .bottom-right {
   position: absolute;
   bottom: -18px;
   right: 6px;
  }
  
  /* Centered text */
  .centered1 {
   position: absolute;
   top: 80%;
   left: 50%;
   transform: translate(-50%, -50%);
   font-size: 50px;
   font-family: Arial;
  }
  .centered {
   position: absolute;
   top: 40%;
   left: 41%;
   transform: translate(-50%, -50%);
   
   font-family: Impact, Charcoal, sans-serif;
  }
  ul{
   list-style-type:none;
   font-size: 20px;
   font-family: Arial;
   
  }
  .a{
   
   font-size: 52px;
   color: #414397;
  }
  .heading-custom{
   font-weight:700;
   
  }
  
 </style>
</head>
<body>
 <div style="width: 100%;">
  <div style="max-width: 1140px; margin: 0 auto;">
   <table width="100%" height="100%" align="center">
    <tr><td width="100%" valign="top">
     <table width="95%" align="center">
      <tr><td>
       
       <div class="container1">
        <img src="{{ asset('/assets/img/invoice-header.png') }}" width="100%"/>
        <div class="bottom-left">
         <h3 align="left">NTN #: 3512754-6</h3>
         <h3 align="left">
          @if($province == 'Punjab,' || $province == 'Punjab')
           PRA#: P3512754-6
          @elseif($province == 'Sindh' || $province == 'Sind')
           SRB#: S3512754-6
          @else
          @endif
         </h3>
        </div>
        <div class="centered1"><b>Invoice</b></div>
       </div>
      </td></tr>
     </table>
    </td></tr>
    <tr>
     <td width="100%" valign="top" align="center">
      <table width="95%" align="center" id="box">
       <br />
       <tr>
        <td width="10%"><label class='heading8'>Inv. Date</label></td>
        <td width="10%"><label class='heading8'>{{ $date_delivered }}</label></td>
        <td width="13%"><label class='heading8'>Banker Name:</label></td>
        <td width="38%"><label class='heading8'>{{ $last_name }}</label></td>
        <td width="10%"><label class='heading8'>Customer ID:</label></td>
        <td width="15%" align="right"><label class='heading8'>{{ $customer_id }}</label></td>
       </tr>
       <tr>
        <td width="10%"><label class='heading8'>Invoice #:</label></td>
        <td width="10%"><label class='heading8'>{{ $workorder_id }}</label></td>
        <td width="13%"><label class='heading8'>Contact Title:</label></td>
        <td width="38%"><label class='heading8'>{{ $contact_title }}</label></td>
        <td width="10%"><label class='heading8'>Deliver Date:</label></td>
        <td width="15%" align="right"><label class='heading8'>{{ $date_delivered }}</label></td>
       </tr>
       <tr>
        <td width="10%"><label class='heading8'>Order Date:</label></td>
        <td width="10%"><label class='heading8'>{{ $date_received }}</label></td>
        <td width="13%"><label class='heading8'>Cash / Cheque:</label></td>
        <td width="38%"><label class='heading8'>Cash / Cheque</label></td>
        <td width="10%"><label class='heading8'>Order #</label></td>
        <td width="15%" align="right"><label class='heading8'>{{ $po_num }}</label></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td width="100%" valign="top" align="center">
      <BR />
      <BR />
      <table width="95%" align="center">
       <tr>
        <td colspan="3"><label class='heading10'><b>Bank / Branch Address</b></label></td>
        <td colspan="3"><label class='heading10'><b>Report Name / Address</b></label></td>						
       </tr>
       <tr>
        <td colspan="3"><label class='heading8'>{{ $cname }}</label></td>
        <td colspan="3"><label class='heading8'>{{ $report_name }}</label></td>						
       </tr>
       <tr>
        <td colspan="3"><label class='heading8'>{{ $postal_address.' '.$city }}</label></td>
        <td colspan="3"><label class='heading8'>{{ $problem_desc }}</label></td>
       </tr>
       <tr>
        <td colspan="3"><label class='heading8'>Tel: {{ $telephone }} Ext: {{ $extension }}</label></td>
        <td colspan="3"><label class='heading8'>{{ $country }}</label></td>
       </tr>
       <tr>
        <td colspan="3"><label class='heading8'>Direct: {{ $direct }}</label></td>
        <td colspan="3"><label class='heading8'>Reference#: {{ $reference_num }}</label></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr>
     <td width="100%" valign="top" align="center">
      <table width="95%" align="center">
       <tr>
        <th width='50%' align='left'><label class='heading8'>Products</label></th>
        <th width='10%' align='left'><label class='heading8'>Qty</label></th>
        <th width='10%' align='left'><label class='heading8'>US$</label></th>
        <th width='10%' align='left'><label class='heading8'>Ex. Rate</label></th>
        <th width='10%' align='right'><label class='heading8'>Unit Price</label></th>
        <th width='10%' align='right'><label class='heading8'>Total Price</label></th>
       </tr>

       @if ($products)
       @foreach ($products as $product)
       <tr>
        <td width='50%' align='left'><label class='heading8'>{{ $product->name }}</label></td>
        <td width='10%' align='left'><label class='heading8'>{{ $product->quantity }}</label></td>
        <td width='10%' align='left'><label class='heading8'>{{ $product->us_price == 0 ? '0.00' : number_format($product->us_price, 2, '.', ',') }}</label></td>
        <td width='10%' align='left'><label class='heading8'>{{ $product->exchange_rate == 0 ? '0.00' : number_format($product->exchange_rate, 2, '.', ',') }}</label></td>
        <td width='10%' align='right'><label class='heading8'>{{ $product->unit_price == 0 ? '0.00' : number_format($product->unit_price, 2, '.', ',') }}</label></td>
        @php
         $total = $product->unit_price * $product->quantity;
        @endphp
        <td width='10%' align='right'><label class='heading8'>{{ $total == 0 ? '0.00' : number_format($total, 2, '.', ',') }}</label></td>
       </tr>			
       @endforeach		
       @endif
       
       <tr><td colspan="6">&nbsp;</td></tr>
       <tr><td colspan="6">&nbsp;</td></tr>
       <tr>
        <td width="50%" align="left"><label class='heading8'>Please Arrange Payment Within 02 Working Days</label></td>
        <td colspan="4" align="left"><label class='heading8'>Total</label></td>
        <td align="right"><label class='heading8'>{{ $sub_total }}</label></td>
       </tr>
       <!--<tr>
        <td width="50%" align="left">&nbsp;</td>
        <td colspan="4" align="left"><label class='heading8'>Special Discount</label></td>
        <td align="right"><label class='heading8'></label></td>
       </tr>-->
       <tr>
        <td width="50%" align="left">&nbsp;</td>
        <td colspan="4" align="left"><label class='heading8'>Sales Tax ({{ $sales_tax_rate }}%)</label></td>
        <td align="right"><label class='heading8'>{{ $sales_tax }}</label></td>
       </tr>
       
       <!--<tr>
        <td width="50%" align="left">&nbsp;</td>
        <td colspan="4" align="left"><label class='heading8'>Amount Due</label></td>
        <td align="right"><label class='heading8'>11,693</label></td>
       </tr>-->
       <tr>
        <td width="50%" align="left">&nbsp;</td>
        <td colspan="4" align="left"><label class='heading8'>Grand Total</label></td>
        <td align="right"><label class='heading8'>{{ $order_total }}</label></td>
       </tr>
       <tr>
        <td width="50%" align="left">&nbsp;</td>
        <td colspan="4" align="left"><label class='heading8'>Payment Received</label></td>
        <td align="right"><label class='heading8'>{{ $payments }}</label></td>
       </tr>
       <!--<tr>
        <td width="50%" align="left">&nbsp;</td>
        <td colspan="6" align="left"><label class='heading8 heading-custom'>Net Payable Amount 10,080 - 0% = 10,080 -10%(NTN) = 9,072 + (16% Provisional Tax)1,613 = 10,685  </label></td>
        
       </tr>-->
       <tr><td colspan="6">&nbsp;</td></tr>
       <tr><td colspan="6"><label class='heading8'>Cheque / Pay Order to be Drawn in Favour of M/s. Axis International</label></td></tr>
       <tr><td colspan="6">&nbsp;</td></tr>
       <tr><td colspan="6">&nbsp;</td></tr>
       <tr><td colspan="6">&nbsp;</td></tr>
      </table>
     </td>
    </tr>
    <tr>
     <td width="100%" valign="top" align="center">
      <table width="80%" align="center">
       <tr>
        <td width="20%" align="center"><label class="h3">____________</label></td>
        <td width="60%">&nbsp;</td>
        <td width="20%" align="center"><label class="h3">____________</label></td>				
       </tr>
       <tr>
        <td width="20%" align="center"><label class="heading1"><b>Approved By:</b></label></td>
        <td width="60%">&nbsp;</td>
        <td width="20%" align="center"><label class="heading1"><b>Received By:</b></label></td>				
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </div>
 </div>
</body>
</html>