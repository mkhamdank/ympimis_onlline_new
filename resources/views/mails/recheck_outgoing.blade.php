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
			<span style="font-weight: bold; color: purple; font-size: 24px;">Recheck Information PT. CRESTEC INDONESIA</span><br>
			<br>
			<p style="color: black">This is an automatic notification. Please do not reply to this address.</p>
		</center>
	</div>
	<div>
		<center>
			<table style="border:1px solid black; border-collapse: collapse;" width="60%">
				<thead style="text-align: center;">
					<tr>
						<th colspan="2" style="border:1px solid black;font-weight: bold;background-color: #d4e157;color: black">Details</th>
					</tr>
					<tr>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Job Number</th>
						<td style="border:1px solid black;text-align: left;">
							{{$data[0]->serial_number}}
						</td>
					</tr>
					<tr>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Material</th>
						<td style="border:1px solid black;text-align: left;">
							{{$data[0]->material_number}} - {{$data[0]->material_description}}
						</td>
					</tr>
					<tr>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty Check</th>
						<td style="border:1px solid black;text-align: left;">
							{{$data[0]->qty_check}}
						</td>
					</tr>
					<tr>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty OK</th>
						<td style="border:1px solid black;text-align: left;">
							{{$data[0]->total_ok}}
						</td>
					</tr>
					<?php
					if($data[0]->ng_name != '-'){ ?>
					<tr>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Detail NG</th>
						<td style="border:1px solid black;text-align: left;">
							<?php $ngss = ''; ?>
							<?php 
								$ngs = explode('[]',$data[0]->ng_name);
								$ng_qty = explode('[]',$data[0]->ng_qty);
								for($i = 0; $i < count($ngs);$i++){
									$ngss .= explode('_',$ngs[$i])[0].' - '.explode('_',$ngs[$i])[1].' = '.$ng_qty[$i].'<br>';
								} ?>
							<?php echo $ngss; ?>
						</td>
					</tr>
					<?php }
					?>
					<tr>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Lot Status</th>
						<?php if($data[0]->lot_status == "LOT OK"){ ?>
						<td style="border:1px solid black;text-align: left;color: green">
							{{$data[0]->lot_status}}
						</td>
						<?php } else{ ?>
						<td style="border:1px solid black;text-align: left;color: red">
							{{$data[0]->lot_status}}
						</td>
						<?php } ?>
					</tr>
				</thead>
				<!-- <tbody style="text-align: center;">
				</tbody> -->
			</table>
		</center>
	</div>
</body>
</html>