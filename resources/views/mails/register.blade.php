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
	</style>
</head>
<body>
	<div>
		<center>
			<img src="data:image/png;base64,{{base64_encode(file_get_contents(public_path('mirai.jpg')))}}" alt=""><br>
			<p style="font-size: 18px;">Vendor Registration Information (登録情報)</p>
			This is an automatic notification. Please do not reply to this address.
			<table style="border:1px solid black; border-collapse: collapse;" width="50%">
				<thead>
					<tr>
						<th colspan="4" style="width: 1%; border:1px solid black;">
							Register Information
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="font-weight: bold; border:1px solid black;">Company</td>
						<td style="border:1px solid black;">:</td>
						<td style="border:1px solid black;">{{ $data->company }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold;border:1px solid black;">Name</td>
						<td style="border:1px solid black;">:</td>
						<td style="border:1px solid black;">{{ $data->name }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold;border:1px solid black;">Email</td>
						<td style="border:1px solid black;">:</td>
						<td style="border:1px solid black;">{{ $data->email }}</td>
					</tr>
					<tr>
						<td style="font-weight: bold;border:1px solid black;">Username</td>
						<td style="border:1px solid black;">:</td>
						<td style="border:1px solid black;">{{ $data->username }}</td>
					</tr>
				</tbody>
			</table>
			<br>
			<a href="{{ url('index/vendor/registration') }}">&#10148; Click this link if you want to check vendor registration</a>
		</center>
	</div>
</body>
</html>