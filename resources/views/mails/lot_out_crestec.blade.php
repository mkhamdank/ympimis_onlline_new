<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		td{
			padding-right: 5px;
			padding-left: 5px;
			padding-top: 0px;
			padding-bottom: 0px;
		}
		th{
			padding-right: 5px;
			padding-left: 5px;			
		}
		.button {
		  background-color: #4CAF50; /* Green */
		  border: none;
		  color: white;
		  padding: 10px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 16px;
		  margin: 4px 2px;
		  cursor: pointer;
		  border-radius: 4px;
		  cursor: pointer;
		}
	</style>
</head>
<body>
	<div>
		<center>
			<span style="font-weight: bold; color: purple; font-size: 24px;">Lot Out Information PT. CRESTEC INDONESIA</span><br>
			<br>
			<p style="color: black">This is an automatic notification. Please do not reply to this address.</p>
		</center>
	</div>
	<div>
		<center>
			<span>
				Dear PT. CRESTEC INDONESIA,<br>
				We have information about Lot Out Material from QC Sampling Inspection.
			</span>
			<br>
				<table style="border:1px solid black; border-collapse: collapse;" width="60%">
					<thead style="text-align: center;">
						<tr>
							<th colspan="2" style="border:1px solid black;font-weight: bold;background-color: #d4e157;color: black">Details</th>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Job Number</th>
							<td style="border:1px solid black;text-align: left;">
								{{$data['sampling'][0]->serial_number}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Material</th>
							<td style="border:1px solid black;text-align: left;">
								{{$data['lot_all'][0]->material_number}} - {{$data['lot_all'][0]->material_description}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Acceptance - Reject</th>
							<td style="border:1px solid black;text-align: left;">
								{{$data['sampling'][0]->acceptance}} - {{$data['sampling'][0]->reject}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty Check</th>
							<td style="border:1px solid black;text-align: left;">
								{{$data['sampling'][0]->qty_total}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty Check</th>
							<td style="border:1px solid black;text-align: left;">
								{{$data['sampling'][0]->qty_ng}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Detail NG</th>
							<td style="border:1px solid black;text-align: left;">
								<?php $ngss = ''; ?>
								<?php if(str_contains($data['sampling'][0]->detail_ng,'P')){
									$ngs = explode('_',$data['sampling'][0]->detail_ng);
									$ng_code = explode(',',$ngs[0]);
									$ng_qty = explode(',',$ngs[1]);
									for($i = 0; $i < count($ng_code);$i++){
										$ng_name = '';
										for($j = 0; $j < count($data['ng_lists']);$j++){
											if($data['ng_lists'][$j]->code == $ng_code[$i]){
												$ng_name = $data['ng_lists'][$j]->ng_name;
											}
										}
										$ngss .= $ng_code[$i].' - '.$ng_name.' = '.$ng_qty[$i].'<br>';
									}
								} ?>
								<?php echo $ngss; ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Lot Status</th>
							<td style="border:1px solid black;text-align: left;color: red">
								{{$data['sampling'][0]->lot_status}}
							</td>
						</tr>
					</thead>
					<!-- <tbody style="text-align: center;">
					</tbody> -->
				</table>
				<br>
				<span style="font-weight: bold; background-color: orange;">&#8650; <i>Click Here For</i> &#8650;</span><br>
					<a href="{{url('index/outgoing/crestec/input/lot_out/'.$data['sampling'][0]->serial_number.'/'.$data['sampling'][0]->check_date_all)}}">Recheck Material</a>
				<br>
				<br>
		</center>
	</div>
</body>
</html>