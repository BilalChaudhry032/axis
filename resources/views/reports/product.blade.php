<html>
<head>
 <title>Product-Wise Sale Report</title>
 <link href="{{ asset('/assets/css/rpt_style.css') }}" type="text/css" rel="stylesheet"/>
 <style>
  * {
   margin: 0;
  }
  html, body {
   height: 100%;
  }
  .wrapper {
   min-height: 100%;
   height: auto !important;
   height: 100%;
   margin: 0 auto -4em;
  }
  .footer, .push {
   height: 4em;
   clear: both;
  }
 </style>
</head>
<body>
 <div class="wrapper">
  <table width="100%" align="center">
   <tr><td>&nbsp;</td></tr>
   <tr><td width="100%" valign="top" align="center">
    <label class='heading1'><b>Product-Wise Sale Report</b></label>
   </td></tr>
   <tr><td width="100%" valign="top" align="center">
    <label class='heading8'>{{ $date }} {{ $company }} {{ $billing_address }} {{ $child }} {{ $part }} {{ $city_name }}</label>
   </td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td width="100%" valign="top" align="center">
     <table width="95%" align="center">
      <tr>
       <th width='50%' align='left'><label class='heading8'>Product</label></th>
       <th width='25%' align='right'><label class='heading8'>Quantity</label></th>
       <th width='25%' align='right'><label class='heading8'>Total Amount</label></th>
      </tr>
      @php
      $quantity = 0;
      @endphp
      @foreach ($result as $rlt)
      @php
      $quantity = $rlt->quantity;
      @endphp
      
      @if($quantity > 0)
      <tr>
       <td width='50%' align='left'><label class='heading8'>{{ $rlt->name }}</label></td>
       <td width='25%' align='right'><label class='heading8'>{{ $quantity }}</label></td>
       <td width='25%' align='right'><label class='heading8'>{{ number_format($rlt->price, 2, '.', ',') }}</label></td>
      </tr>
      @endif
      @endforeach
      
      <tr>
       <th width='20%' align='left'><label class='heading8'></label></th>
       <th width='20%' align='left'><label class='heading8'></label></th>
       <th width='15%' align='left'><label class='heading8'></label></th>
       <th width='15%' align='left'><label class='heading8'></label></th>
       <th width='15%' align='left'><label class='heading8'></label></th>
       <th width='15%' align='right'><label class='heading8'></label></th>
      </tr>
     </table>
    </td>
   </tr>
  </table>
  <div class="push"></div>
 </div>
 <div class="footer"><label class="heading10"><b><?=date("l, F j, Y")?></b></label></div>
</body>
</html>