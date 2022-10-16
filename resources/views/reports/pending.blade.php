<html>
<head>
 <title>Pending Workorders</title>
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
    <label class='heading1'><b>Pending Workorders</b></label>
   </td></tr>
   <tr><td width="100%" valign="top" align="center">
    <label class='heading8'>{{$date}} {{$company}} {{$billing_address}} {{$child}} {{$city_name}}</label>
   </td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
    <td width="100%" valign="top" align="center">
     <table width="95%" align="center">
      <tr>
       <th width='5%' align='left'><label class='heading8'>SR#</label></th>
       <th width='5%' align='left'><label class='heading8'>PO#</label></th>
       <th width='15%' align='left'><label class='heading8'>Bank Name</label></th>
       <th width='15%' align='left'><label class='heading8'>Contact</label></th>
       <th width='10%' align='left'><label class='heading8'>Phone Number</label></th>
       <th width='10%' align='left'><label class='heading8'>Order Date</label></th>
       <th width='22%' align='left'><label class='heading8'>Report Name</label></th>
       <th width='18%' align='left'><label class='heading8'>Vendor</label></th>
      </tr>
      @php
      $serial = 0;
      @endphp
      @foreach ($result as $rlt)
      <tr>
       <td width='5%' align='left'><label class='heading8'>{{ ++$serial }}</label></td>
       <td width='5%' align='left'><label class='heading8'>{{ $rlt->po_num }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $rlt->name }}</label></td>
       <td width='15%' align='left'><label class='heading8'>{{ $rlt->last_name }}</label></td>
       <td width='10%' align='left'><label class='heading8'>{{ $rlt->telephone }}</label></td>
       <td width='10%' align='left'><label class='heading8'>{{ $rlt->date_received }}</label></td>
       <td width='22%' align='left'><label class='heading8'>{{ $rlt->report_name }}</label></td>
       <td width='18%' align='left'><label class='heading8'>{{ $rlt->vname }}</label></td>
      </tr>
      @endforeach				
     </table>
    </td>
   </tr>
  </table>
  <div class="push"></div>
 </div>
 <div class="footer"><label class="heading10"><b><?=date("l, F j, Y")?></b></label></div>
</body>
</html>