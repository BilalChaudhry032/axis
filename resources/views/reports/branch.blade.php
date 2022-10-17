<html>
<head>
	<title>Branch Wise</title>
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
				<label class='heading1'><b>Branch Wise</b></label>
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
							<th width='20%' align='left'><label class='heading8'>Company</label></th>
							<th width='20%' align='left'><label class='heading8'>Contact Person</label></th>
							<th width='30%' align='left'><label class='heading8'>Report Name</label></th>
							<th width='10%' align='left'><label class='heading8'>Date Received</label></th>
						</tr>

      @foreach ($result as $row)
          <tr>
					<td width='10%' align='left'><label class='heading8'><a href='{{ url('/workorder/'.$row->workorder_id.'/invoice') }}' target='_blank'>{{ $row->workorder_id }}</a></label></td>
					<td width='10%' align='left'><label class='heading8'>{{ $row->po_num }}</label></td>
					<td width='20%' align='left'><label class='heading8'>{{ $row->name }}</label></td>
					<td width='20%' align='left'><label class='heading8'>{{ $row->last_name }}</label></td>
					<td width='30%' align='left'><label class='heading8'>{{ $row->report_name }}</label></td>
					<td width='10%' align='left'><label class='heading8'>{{ $row->date_received }}</label></td>
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