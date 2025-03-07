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
			<span style="font-weight: bold; color: purple; font-size: 24px;">Cancellation Trouble Information From {{$data['vendor_name']}}</span><br>
            <span style="color: red; font-size: 18px;">This trouble info has been deleted by {{$data['vendor_name']}}</span><br>
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
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Category</th>
							<td style="border:1px solid black;text-align: left">
								{{$data['data_before']->category}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Date From</th>
							<td style="border:1px solid black;text-align: left">
								{{$data['data_before']->date_from}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Date To</th>
							<td style="border:1px solid black;text-align: left">
								{{$data['data_before']->date_to}}
							</td>
						</tr>
						<tr>
							<?php if($data['data_before']->category == 'Machine'){
								$title = 'Machine / Tools'; ?>
							<tr>
								<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
								<td style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['data_before']->supporting}}
								</td>
							</tr>
							<?php }else if($data['data_before']->category == 'Man'){
								$title = 'Process'; ?>
							<tr>
								<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
								<td style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['data_before']->supporting}}
								</td>
							</tr>
							<?php } ?>
							
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Material</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->material ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Trouble</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->trouble ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Effect</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->effect ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Apakah sudah dilakukan<br>
								penanganan ke semua produk<br>
								lain di tengah proses<br>
								dan siap kirim?
							</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['data_before']->handling_choice ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Handling</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->handling ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty WIP</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->qty_wip ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty Delivery</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->qty_delivery ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty Check</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->qty_check ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty OK</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->qty_ok ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Qty NG</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->qty_ng ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Results</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->results ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;">Surat Jalan</th>
							<td style="border:1px solid black;text-align: left">
								<?php echo $data['data_before']->surat_jalan ?>
							</td>
						</tr>
					</thead>
                </table>
        </center>
	</div>
</body>
</html>
       