<html>
<head>
	<title>Receivable</title>
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
				<label class='heading1'><b>Receivable</b></label>
			</td></tr>
			<tr><td width="100%" valign="top" align="center">
				<label class='heading8'>{{$date}} {{$company}} {{$billing_address}} {{$child}} {{$part}} {{$city_name}}</label>
			</td></tr>
			@php
			$grand_total = 0;
			$serial = 0;
			$wo_flag1 = true;
				$wo_flag2 = true;
			@endphp
			
			@foreach($top_result as $key => $top)
			@php
			$total = 0;
			$amount = 0;
			$wo_flag1 = true;
							$wo_flag2 = false;
			@endphp
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="100%" valign="top" align="center">
					<table width="95%" align="center">
						<tr>
							<td width="70%"><label class='heading8'>Bank Name: {{$top->cname}}</label></td>
							<td width="30%"><label class='heading8'>Customer ID: {{$top->customer_id}}</label></td>
						</tr>
						<tr>
							<td colspan="2"><label class='heading8'>Billing Address: {{$top->bname}}</label></td>
						</tr>
						<tr>
							<td colspan="2"><label class='heading8'>City: {{$top->city}}</label></td>
						</tr>
						<tr>
							<td width="70%"><label class='heading8'>Tel: {{$top->telephone}}</label></td>
							<td width="30%"><label class='heading8'>Fax: {{$top->fax}}</label></td>
						</tr>
					</table>
				</td>
			</tr>			
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td width="100%" valign="top" align="center">
					<table width="95%" align="center">
						<tr>
							<th width='10%' align='left'><label class='heading8'>SR#</label></th>
							<th width='10%' align='left'><label class='heading8'>Invoice#</label></th>
							<th width='10%' align='left'><label class='heading8'>Branch#</label></th>
							<th width='10%' align='left'><label class='heading8'>Reference#</label></th>
							<th width='10%' align='left'><label class='heading8'>Contact Name</label></th>
							<th width='10%' align='left'><label class='heading8'>Del. Date</label></th>
							<th width='18%' align='left'><label class='heading8'>Report Name</label></th>
							<th width='8%' align='right'><label class='heading8'>Inv. Amount</label></th>
							<!--<th width='8%' align='right'><label class='heading8'>NTN 10%</label></th>-->
							<th width='8%' align='right'><label class='heading8'>Prov. Tax</label></th>
							<th width='16%' align='right'><label class='heading8'>Amount</label></th>
						</tr>
						@foreach($result[$key] as $rlt)
										
						
						@php
						$amount = $rlt->amount;
						$ntn = $amount/100;
						$ntn = $ntn * 10;
						$ntn = 0; // Uncomment it to start using NTN
						$pAmount= $amount;
						$pra = $pAmount*$rlt->sales_tax_rate/100;
						$pAmount = 0;
						$province = $top->province;
						$tAmount = $amount + $pra;
						$tAmount = $tAmount - $ntn;
						
						$total += $tAmount;
						@endphp
						
						<tr>
							<td width='10%' align='left'><label class='heading8'>{{++$serial}}</label></td>
							<td width='10%' align='left'><label class='heading8'>{{$rlt->workorder_id}}</label></td>
							<td width='10%' align='left'><label class='heading8'>{{$rlt->branch}}</label></td>
							<td width='10%' align='left'><label class='heading8'>{{$rlt->reference_num}}</label></td>
							<td width='10%' align='left'><label class='heading8'>{{$rlt->last_name}}</label></td>
							<td width='10%' align='left'><label class='heading8'>{{$rlt->date_delivered}}</label></td>
							<td width='10%' align='left'><label class='heading8'>{{$rlt->report_name}}</label></td>
							<td width='8%' align='right'><label class='heading8'>{{number_format($amount, 2, '.', ',')}}</label></td>
							{{-- <td width='8%' align='right'><label class='heading8'>{{number_format($ntn, 2, '.', ',')}}</label></td> --}}
							<td width='8%' align='right'><label class='heading8'>{{number_format($pra, 2, '.', ',')}}</label></td>
							<td width='16%' align='right'><label class='heading8'>{{round($tAmount)}}</label></td>
						</tr>
						@endforeach
						@php
						$serial = 0;
						$grand_total += $total;
						@endphp
						<tr>
							<th colspan='9' align='right'><label class='heading8'>Total:  </label></th>
							<th colspan='2' width='10%' align='right'><label class='heading8'><?=round($total)?></label></th>
						</tr>
					</table>
				</td>
			</tr>
			@endforeach
			
			<tr>
				<td width="100%" valign="top" align="center">
					<table width="95%" align="center">
						<tr>
							<th width='85%' align='right'><label class='heading8'>Grand Total:</label></th>
							<th width='15%' align='right'><label class='heading8'><?=round($grand_total)?></label></th>
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