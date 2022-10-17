<html>
<head>
	<title>Monthly Sale Report</title>
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
				<label class='heading1'><b>Monthly Sale Report</b></label>
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td width="100%" valign="top">
				<label class='heading10'>For Services Conducted Between: {{ $from_date }} and {{ $to_date }} {{ $company }} {{ $billing_address }} {{ $child }} {{ $part }} {{ $city_name }}</label>
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="100%" valign="top" align="center">
					<table width="95%" align="center">
						<tr>
							<th width='20%' align='left'><label class='heading8'>Month</label></th>
							<th width='20%' align='right'><label class='heading8'>Products</label></th>
							<th width='15%' align='right'><label class='heading8'>Part Total</label></th>
							<th width='15%' align='right'><label class='heading8'>Total</label></th>
							<th width='15%' align='right'><label class='heading8'>Sales Tax</label></th>
							<th width='15%' align='right'><label class='heading8'>Invoice Total</label></th>
						</tr>
      @foreach ($result as $rlt)
        <tr>
         <td width='20%' align='left'><label class='heading8'>{{ $rlt->month }}</label></td>
         <td width='20%' align='right'><label class='heading8'>{{ number_format($rlt->total, 2, '.', ',') }}</label></td>
         <td width='15%' align='right'><label class='heading8'>{{ number_format($rlt->total, 2, '.', ',') }}</label></td>
         <td width='15%' align='right'><label class='heading8'>{{ number_format($rlt->total, 2, '.', ',') }}</label></td>
         <td width='15%' align='right'><label class='heading8'>{{ number_format($rlt->sales_tax, 2, '.', ',') }}</label></td>
         @if(floatval($rlt->sales_tax) > 0)
          <td width='15%' align='right'><label class='heading8'>{{ number_format(($rlt->total+($rlt->total/$rlt->sales_tax*100)), 2, '.', ',') }}</label></td>
         @else
          <td width='15%' align='right'><label class='heading8'>{{ number_format($rlt->total, 2, '.', ',') }}</label></td>
         @endif
        </tr>
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