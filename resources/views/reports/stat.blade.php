<html>
<head>
 <title>Stat</title>
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
    <label class='heading1'><b>Stat Report</b></label>
   </td></tr>
   <tr><td width="100%" valign="top" align="center">
    <label class='heading8'>{{ $date }} {{ $city_name }}</label>
   </td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td width="100%" valign="top" align="center">
     <table width="95%" align="center">
      <tr>
       <th width='10%' align='left'><label class='heading8'>Invoice#</label></th>
       <th width='10%' align='left'><label class='heading8'>PO#</label></th>
       <th width='15%' align='left'><label class='heading8'>Company</label></th>
       <th width='10%' align='left'><label class='heading8'>Contact Person</label></th>
       <th width='10%' align='left'><label class='heading8'>Date Received</label></th>
       <th width='15%' align='left'><label class='heading8'>Report Name</label></th>
       <th width='10%' align='left'><label class='heading8'>Reference#</label></th>
       <th width='10%' align='right'><label class='heading8'>Amount Due</label></th>
       <th width='10%' align='right'><label class='heading8'>Amount Received</label></th>
      </tr>
      
      @php
      $amount_due = 0;
      $payment_amount = 0;
      @endphp
      @foreach ($result as $row)
      @php
      if(isset($row->amount_due) && strlen($row->amount_due) > 0) {
       $amount_due += $row->amount_due;
      }
      if(isset($row->payment_amount) && strlen($row->payment_amount) > 0) {
       $payment_amount += $row->payment_amount;
      }
      @endphp
      <tr>
       <td width='10%' align='left'><label class='heading8'>{{ $row->workorder_id }}</label></td>
       <td width='10%' align='left'><label class='heading8'>{{ $row->po_num }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $row->name }}</label></td>
       <td width='10%' align='left'><label class='heading8'>{{ $row->last_name }}</label></td>
       <td width='10%' align='left'><label class='heading8'>{{ $row->date_received }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $row->report_name }}</label></td>
       <td width='10%' align='left'><label class='heading8'>{{ $row->reference_num }}</label></td>
       <td width='10%' align='right'><label class='heading8'>{{ number_format( (isset($row->amount_due) && strlen($row->amount_due) > 0) ? $row->amount_due : 0, 2, '.', ',') }}</label></td>
       <td width='10%' align='right'><label class='heading8'>{{ number_format( (isset($row->payment_amount) && strlen($row->payment_amount) > 0) ? $row->payment_amount : 0, 2, '.', ',') }}</label></td>
      </tr>
      @endforeach
      <tr>
       <th colspan='7' align='right'><label class='heading8'>Total</label></th>
       <th width='15%' align='right'><label class='heading8'><?=number_format($amount_due, 2, '.', ',')?></label></th>
       <th width='15%' align='right'><label class='heading8'><?=number_format($payment_amount, 2, '.', ',')?></label></th>
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