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
			<span style="font-weight: bold; color: purple; font-size: 24px;">Trouble Information From {{$data['vendor_name']}}</span><br>
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
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Category</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['category']}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Date From</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['date_from']}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Date To</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['date_to']}}
							</td>
						</tr>
							<?php if($data['category'] == 'Machine'){
								$title = 'Machine / Tools'; ?>
								<tr>
									<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
									<td style="border:1px solid black;text-align: left; width: 10%;">
										{{$data['supporting']}}
									</td>
								</tr>
							<?php }else if($data['category'] == 'Man'){
								$title = 'Process'; ?>
								<tr>
									<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
									<td style="border:1px solid black;text-align: left; width: 10%;">
										{{$data['supporting']}}
									</td>
								</tr>
							<?php } ?>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Material</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['material']}}
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Trouble</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['trouble'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Effect</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['effect'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Apakah sudah dilakukan<br>
								penanganan ke semua produk<br>
								lain di tengah proses<br>
								dan siap kirim?
							</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['handling_choice'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Handling</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['handling'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty WIP</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['qty_wip'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty Delivery</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['qty_delivery'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty Check</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['qty_check'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty OK</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['qty_ok'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty NG</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['qty_ng'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Results</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['results'] ?>
							</td>
						</tr>
						<tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Surat Jalan</th>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['surat_jalan'] ?>
							</td>
						</tr>
					</thead>
				</table>

                <br>
				<br>
				<p>
					<b style="color: red;">Please Follow Up and Be Attend to This Information.</b>
				</p>
		</center>
	</div>
</body>
</html>