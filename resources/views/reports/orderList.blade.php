<html>
<head>
 <title>Order List</title>
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
    <label class='heading1'><b>Order List</b></label>
   </td></tr>
   <tr><td width="100%" valign="top" align="center">
    <label class='heading8'>{{ $date }} {{ $company }} {{ $billing_address }} {{ $child }} {{ $part }} {{ $city_name }}</label>
   </td></tr>
   @foreach($top_result as $key => $top)
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td width="100%" valign="top" align="center">
     <table width="95%" align="center">
      <tr>
       <td width="70%"><label class='heading8'>Bank Name: {{ $top->cname }}</label></td>
       <td width="30%"><label class='heading8'>&nbsp;</label></td>
      </tr>
      <tr>
       <td colspan="2"><label class='heading8'>Billing Address: {{ $top->bname }}</label></td>
      </tr>
      <tr>
       <td colspan="2"><label class='heading8'>City: {{ $top->city }}</label></td>
      </tr>
      <tr>
       <td width="70%"><label class='heading8'>Tel: {{ $top->telephone }}</label></td>
       <td width="30%"><label class='heading8'>Fax: {{ $top->fax }}</label></td>
      </tr>
     </table>
    </td>
   </tr>			
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td width="100%" valign="top" align="center">
     <table width="95%" align="center">
      <tr>
       <th width='25%' align='left'><label class='heading8'>Reference#</label></th>
       <th width='20%' align='left'><label class='heading8'>Contact Name</label></th>
       <th width='15%' align='left'><label class='heading8'>Del. Date</label></th>
       <th width='40%' align='left'><label class='heading8'>Report Name</label></th>
      </tr>
      @foreach($result[$key] as $temp)
      <tr>
       <td width='25%' align='left'><label class='heading8'>{{ $temp->reference_num }}</label></td>
       <td width='20%' align='left'><label class='heading8'>{{ $temp->last_name }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $temp->date_delivered }}</label></td>
       <td width='40%' align='left'><label class='heading8'>{{ $temp->report_name }}</label></td>
      </tr>
      @endforeach
     </table>
    </td>
   </tr>
   @endforeach
  </table>
  <div class="push"></div>
 </div>
 <div class="footer"><label class="heading10"><b><?=date("l, F j, Y")?></b></label></div>
</body>
</html>