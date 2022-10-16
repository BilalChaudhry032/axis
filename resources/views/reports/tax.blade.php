<html>
<head>
 <title>Tax</title>
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
    <label class='h3'><b>Axis International</b></label>
   </td></tr>
   <tr><td width="100%" valign="top" align="center">
    <label class='heading1'><b>Tax Report</b></label>
   </td></tr>
   <tr><td width="100%" valign="top" align="center">
    <label class='heading8'>{{ $date }} {{ $city_name }}</label>
   </td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td width="100%" valign="top" align="center">
     <table width="95%" align="center">
      <tr>
       <th width='15%' align='left'><label class='heading8'>Invoice#</label></th>
       <th width='15%' align='left'><label class='heading8'>Company</label></th>
       <th width='15%' align='left'><label class='heading8'>Contact Person</label></th>
       <th width='15%' align='left'><label class='heading8'>Payment Date</label></th>
       <th width='15%' align='right'><label class='heading8'>Amount Due</label></th>
       <th width='10%' align='right'><label class='heading8'>Tax</label></th>
       <th width='10%' align='right'><label class='heading8'>Net Received</label></th>
       <th width='10%' align='right'><label class='heading8'>PRA/SRA</label></th>
       
      </tr>
      
      @php
      $amount_due = 0;
      $payment_amount = 0;
      $tax = 0;
      $pra = 0;
      $pAmount = 0;
      $pra_sra = 0;
      @endphp
      @foreach ($result as $row)
      @php
      $amount_due += $row->amount_due;
      $payment_amount += $row->payment_amount;
      $sales_tax_rate = $row->sales_tax_rate;
      $tax += $row->tax;
      $pAmount += $row->amount_due;
      $province = $row->province;
      $pra = $pAmount/100;
      $pra = $pra * $sales_tax_rate;
      $pAmount = 0;
      $pra_sra += $pra;
      @endphp
      <tr>
       <td width='15%' align='left'><label class='heading8'>{{ $row->workorder_id }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $row->name }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $row->last_name }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $row->payment_date }}</label></td>
       <td width='10%' align='right'><label class='heading8'>{{ number_format($row->amount_due, 2, '.', ',') }}</label></td>
       <td width='10%' align='right'><label class='heading8'>{{ number_format($row->tax, 2, '.', ',') }}</label></td>
       <td width='10%' align='right'><label class='heading8'>{{ number_format($row->payment_amount, 2, '.', ',') }}</label></td>
       <td width='15%' align='right'><label class='heading8'>{{ number_format($pra, 2, '.', ',') }}</label></td>
      </tr>
      @endforeach
      <tr>
       <th colspan='4' align='right'><label class='heading8'>Total</label></th>
       <th width='15%' align='right'><label class='heading8'><?=number_format($amount_due, 2, '.', ',')?></label></th>
       <th width='10%' align='right'><label class='heading8'><?=number_format($tax, 2, '.', ',')?></label></th>
       <th width='10%' align='right'><label class='heading8'><?=number_format($payment_amount, 2, '.', ',')?></label></th>
       <th width='15%' align='right'><label class='heading8'><?=number_format($pra_sra, 2, '.', ',')?></label></th>
       
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