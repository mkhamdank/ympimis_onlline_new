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
            <span style="color: red; font-size: 18px;">There is a change in trouble information from {{$data['vendor_name']}}</span><br>
			<p style="color: black">This is an automatic notification. Please do not reply to this address.</p>
		</center>
	</div>
	<div>
		<center>
				<table style="border:1px solid black; border-collapse: collapse;" width="60%">
					<thead style="text-align: center;">
						<tr>
							<th colspan="3" style="border:1px solid black;font-weight: bold;background-color: lightblue;color: black">Details</th>
						</tr>
                        <?php
                        if($data['data_before']->category == $data['category']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Category</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['category']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Category</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->category}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['category']}}
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->date_from == $data['date_from']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Date From</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['date_from']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Date From</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->date_from}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['date_from']}}
							</td>
                        </tr>
                        <?php } ?>
                        <?php
                        if($data['data_before']->date_to == $data['date_to']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Date To</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['date_to']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Date To</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->date_to}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['date_to']}}
							</td>
                        </tr>
                        <?php } ?> 

						<?php if($data['data_before']->category == 'Machine'){
							$title = 'Machine / Tools'; ?>
						<?php if($data['data_before']->category == $data['category']){ ?>
							<tr>
								<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
								<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['supporting']}}
								</td>
							</tr>
						<?php } else{ ?>
							<tr>
								<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
								<td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
									Before
								</td>
								<td style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['data_before']->supporting}}
								</td>
							</tr>
							<tr>
								<td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
									After
								</td>
								<td style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['supporting']}}
								</td>
							</tr>
						<?php } ?>
						<?php }else if($data['data_before']->category == 'Man'){
							$title = 'Process'; ?>
						<?php if($data['data_before']->category == $data['category']){ ?>
							<tr>
								<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
								<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['supporting']}}
								</td>
							</tr>
						<?php } else{ ?>
							<tr>
								<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">{{$title}}</th>
								<td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
									Before
								</td>
								<td style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['data_before']->supporting}}
								</td>
							</tr>
							<tr>
								<td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
									After
								</td>
								<td style="border:1px solid black;text-align: left; width: 10%;">
									{{$data['supporting']}}
								</td>
							</tr>
						<?php } ?>
						<?php } ?>

						<?php
                        if($data['data_before']->material == $data['material']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Material</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['material'] ?>
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Material</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['data_before']->material ?>
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['material'] ?>
							</td>
                        </tr>
                        <?php } ?>

                        <?php
                        if($data['data_before']->trouble == $data['trouble']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Trouble</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['trouble'] ?>
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Trouble</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['data_before']->trouble ?>
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['trouble'] ?>
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->effect == $data['effect']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Effect</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['effect'] ?>
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Effect</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['data_before']->effect ?>
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['effect'] ?>
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->handling_choice == $data['handling_choice']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Apakah sudah dilakukan<br>
								penanganan ke semua produk<br>
								lain di tengah proses<br>
								dan siap kirim?
							</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['handling_choice']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
								<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Apakah sudah dilakukan<br>
									penanganan ke semua produk<br>
									lain di tengah proses<br>
									dan siap kirim?
								</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->handling_choice}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['handling_choice']}}
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->handling == $data['handling']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Handling</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['handling'] ?>
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Handling</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['data_before']->handling ?>
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['handling'] ?>
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->qty_wip == $data['qty_wip']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty WIP</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_wip']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty WIP</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->qty_wip}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_wip']}}
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->qty_delivery == $data['qty_delivery']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty Delivery</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_delivery']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty Delivery</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->qty_delivery}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_delivery']}}
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->qty_check == $data['qty_check']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty Check</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_check']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty Check</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->qty_check}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_check']}}
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->qty_ok == $data['qty_ok']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty OK</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_ok']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty OK</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->qty_ok}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_ok']}}
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->qty_ng == $data['qty_ng']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty NG</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_ng']}}
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Qty NG</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['data_before']->qty_ng}}
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								{{$data['qty_ng']}}
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->results == $data['results']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Results</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['results'] ?>
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Results</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['data_before']->results ?>
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['results'] ?>
							</td>
                        </tr>
                        <?php } ?>

						<?php
                        if($data['data_before']->surat_jalan == $data['surat_jalan']){ ?>
                        <tr>
							<th style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Surat Jalan</th>
							<td colspan="2" style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['surat_jalan'] ?>
							</td>
						</tr>
                        <?php } else{ ?>
                            <tr>
							<th rowspan="2" style="border:1px solid black;font-weight: bold;background-color: rgb(126,86,134);text-align: left;color: white; width: 1%;">Surat Jalan</th>
                            <td style="border:1px solid black;text-align: left; background-color: lightpink; width: 1%;">
								Before
							</td>
							<td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['data_before']->surat_jalan ?>
							</td>
						</tr>
                        <tr>
                            <td style="border:1px solid black;text-align: left; background-color: lightgreen; width: 1%;">
								After
							</td>
                            <td style="border:1px solid black;text-align: left; width: 10%;">
								<?php echo $data['surat_jalan'] ?>
							</td>
                        </tr>
                        <?php } ?>

                        
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
       