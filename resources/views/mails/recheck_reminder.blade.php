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
			<span style="font-weight: bold; color: purple; font-size: 24px;">Recheck Reminder PT. CRESTEC INDONESIA</span><br>
			<br>
			<p style="color: black">This is an automatic notification. Please do not reply to this address.</p>
		</center>
	</div>
	<div>
		<center>
			<table style="border:1px solid black; border-collapse: collapse;" width="80%">
				<thead style="text-align: center;">
					<tr>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;width: 1%">Job Number</th>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;width: 10%">Material</th>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;width: 2%">Check Date</th>
						<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white;width: 3%">Recheck</th>
					</tr>
				</thead>
				<tbody>
					<td style="border:1px solid black;text-align: left;">{{$data[0]->serial_number}}</td>
					<td style="border:1px solid black;text-align: left;">{{$data[0]->material_number}} - {{$data[0]->material_description}}</td>
					<td style="border:1px solid black;text-align: left;">{{$data[0]->check_date_all}}</td>
					<td style="border:1px solid black;text-align: center;"><a href="{{url('index/outgoing/crestec/input/lot_out/'.$data[0]->serial_number.'/'.$data[0]->check_date_all)}}">Recheck Material</a></td>
				</tbody>
			</table>
		</center>
	</div>
</body>
</html>