<!DOCTYPE html>
<html>
<head>
	<title>YMPI 情報システム</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		body{
			font-size: 12px;
		}

		#isi > thead > tr > td {
			text-align: center;
		}

		#isi > tbody > tr > td {
			text-align: left;
			padding-left: 5px;
		}

		.centera{
			text-align: center;
			vertical-align: middle !important;
		}

		.line{
		   width: 100%; 
		   text-align: center; 
		   border-bottom: 1px solid #000; 
		   line-height: 0.1em;
		   margin: 10px 0 20px;  
		}

		.line span{
		   background:#fff; 
		   padding:0 10px;
		}

		@page { }
        .footer { position: fixed; left: 0px; bottom: -50px; right: 0px; height: 200px;text-align: center;}
        .footer .pagenum:before { content: counter(page); }
	</style>
</head>

<body>
	<header>

		<table style="width: 100%; font-family: TimesNewRoman; border-collapse: collapse; text-align: left;" >
			<thead>
				<tr>
					<td colspan="10" style="font-weight: bold;font-size: 13px">PT. YAMAHA MUSICAL PRODUCTS INDONESIA</td>
				</tr>
				<tr>
					<td colspan="6" style="text-align: left;font-size: 11px">Jl. Rembang Industri I/36 Kawasan Industri PIER - Pasuruan</td>
					<td colspan="1" style="text-align: left;font-size: 11px;width: 16%"><b>Nomor Payment</b></td>
					<td colspan="3" style="text-align: left;font-size: 11px"><b>: {{$id}}</b></td>
				</tr>
				<tr>
					<td colspan="6" style="text-align: left;font-size: 11px">Phone : (0343) 740290 Fax : (0343) 740291</td>
					<td colspan="1" style="text-align: left;font-size: 11px;width: 16%"><b>Date</b></td>
					<td colspan="3" style="text-align: left;font-size: 11px"><b>: <?= date('d-M-y', strtotime($payment->payment_date)) ?></b></td>
				</tr>
				<tr>
					<td colspan="10" style="text-align: left;font-size: 11px">Jawa Timur Indonesia</td>
				</tr>

				<tr>
					<td colspan="10" style="text-align: center;font-size: 30px"><b>Payment Request</b></td>
				</tr>

				<tr>
					<td colspan="10"><br></td>
				</tr>


				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="border:1px solid black;padding:5px">&nbsp;<b>Name Of Vendor</b></td>
					<td colspan="6" style="border:1px solid black">&nbsp;&nbsp;&nbsp;<b>{{$payment->supplier_name}}</b></td>
					<td colspan="1"></td>
				</tr>

				<tr>
					<td colspan="10"><br></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="border:1px solid black;padding:5px">&nbsp;<b>Amount Of Payment</b></td>
					<td colspan="6" style="border:1px solid black">&nbsp;&nbsp;&nbsp;<b><?= $payment->currency ?> &nbsp; <?= number_format($payment->amount,2,",",".") ?></b></td>
					<td colspan="1"></td>
				</tr>

				<tr>
					<td colspan="10"><br></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="border:1px solid black;padding:5px">&nbsp;<b>Payment Term</b></td>
					<td colspan="6" style="border:1px solid black">&nbsp;&nbsp;&nbsp;<b><?= $payment->payment_term ?></b></td>
					<td colspan="1"></td>
				</tr>

				<tr>
					<td colspan="10"><br></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="border:1px solid black;padding:5px">&nbsp;<b>Due Date</b></td>
					<td colspan="6" style="border:1px solid black">&nbsp;&nbsp;&nbsp;<b><?= date('d-M-y', strtotime($payment->payment_due_date)) ?></b></td>
					<td colspan="1"></td>
				</tr>

				<tr>
					<td colspan="10"><br></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="border:1px solid black;padding:5px">&nbsp;<b>Kinds Of Material</b></td>
					<td colspan="6" style="border:1px solid black">&nbsp;&nbsp;&nbsp;<b><?= $payment->kind_of ?></b></td>
					<td colspan="1"></td>
				</tr>

				<tr>
					<td colspan="10"><br></td>
				</tr>


				<?php 

				$attached_docoment = explode(",",$payment->attach_document);

				?>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="border:1px solid black;padding:5px">&nbsp;<b>Attached Document</b></td>
					<td colspan="1" style="border:1px solid black">&nbsp;&nbsp;&nbsp;
						<b>
						<?php 

						if (in_array("local", $attached_docoment))
						  {
						  	echo "&nbsp;&nbsp;&nbsp;&nbsp;X";
						  }
						  else{
						  	echo "";
						  }
						?>
							
						</b>
					</td>
					<td colspan="6">&nbsp;&nbsp;<b>Local</b></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="padding:5px">&nbsp;</td>
					<td colspan="1" style="border:1px solid black">&nbsp;&nbsp;&nbsp;
						<b>
						<?php 

						if (in_array("import", $attached_docoment))
						  {
						  	echo "&nbsp;&nbsp;&nbsp;&nbsp;X";
						  }
						  else{
						  	echo "";
						  }
						?>
						</b>
					</td>
					<td colspan="6">&nbsp;&nbsp;<b>Import</b></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="padding:5px">&nbsp;</td>
					<td colspan="1" style="border:1px solid black">&nbsp;&nbsp;&nbsp;
						<b>
							<?php 

							if (in_array("invoice", $attached_docoment))
							  {
							  	echo "&nbsp;&nbsp;&nbsp;&nbsp;X";
							  }
							  else{
							  	echo "";
							  }
							?>
						</b>
					</td>
					<td colspan="6">&nbsp;&nbsp;<b>Invoice</b></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="padding:5px">&nbsp;</td>
					<td colspan="1" style="border:1px solid black">&nbsp;&nbsp;&nbsp;
						<b>
							<?php 

							if (in_array("receipt", $attached_docoment))
							  {
							  	echo "&nbsp;&nbsp;&nbsp;&nbsp;X";
							  }
							  else{
							  	echo "";
							  }
							?>
						</b>
					</td>
					<td colspan="6">&nbsp;&nbsp;<b>Receipt</b></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="padding:5px">&nbsp;</td>
					<td colspan="1" style="border:1px solid black">&nbsp;&nbsp;&nbsp;
						<b>
							<?php 

							if (in_array("surat_jalan", $attached_docoment))
							  {
							  	echo "&nbsp;&nbsp;&nbsp;&nbsp;X";
							  }
							  else{
							  	echo "";
							  }
							?>
						</b>
					</td>
					<td colspan="6">&nbsp;&nbsp;<b>Surat Jalan</b></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="padding:5px">&nbsp;</td>
					<td colspan="1" style="border:1px solid black">&nbsp;&nbsp;&nbsp;
						<b>
							<?php 

							if (in_array("faktur_pajak", $attached_docoment))
							  {
							  	echo "&nbsp;&nbsp;&nbsp;&nbsp;X";
							  }
							  else{
							  	echo "";
							  }
							?>
						</b>
					</td>
					<td colspan="6">&nbsp;&nbsp;<b>Faktur Pajak</b></td>
				</tr>
				<tr>
					<td colspan="10"><br></td>
				</tr>
				<tr>
					<td colspan="10"><br></td>
				</tr>

				<tr>
					<td colspan="1">&nbsp;</td>
					<td colspan="2" style="width: 25%;border:1px solid black;padding:5px">&nbsp;<b>Invoice Number</b></td>
					<td colspan="2" style="width: 25%;border:1px solid black">&nbsp;<b>Amount (DPP)</b></td>
					<td colspan="1" style="width: 12%;border:1px solid black">&nbsp;<b>PPN</b></td>
					<td colspan="1" style="width: 12%;border:1px solid black">&nbsp;<b>PPH</b></td>
					<td colspan="2" style="width: 25%;border:1px solid black">&nbsp;<b>Net Payment</b></td>
					<td colspan="1">&nbsp;</td>
				</tr>
				<?php  
					$total = 0;
				?>

				@foreach($payment_detail as $detail)


					<tr>
						<td colspan="1">&nbsp;</td>
						<td colspan="2" style="border:1px solid black;text-align: center;padding:3px">&nbsp;<b>{{ $detail->invoice }}</b></td>
						<td colspan="2" style="border:1px solid black;text-align: right;">&nbsp;<b><?= number_format($detail->amount,2,",",".");?> </b></td>
						@if($detail->ppn == "on")
							<?php $ppn = 0.1*$detail->amount ?>
						@else
							<?php $ppn = 0; ?>
						@endif

						<?php 
							if ($detail->pph > 0) {
								$pph = (int) $detail->pph * (int) $detail->amount_service / 100;

							}else{
								$pph = 0;
							}
						?>

						<td colspan="1" style="border:1px solid black;text-align: right;">&nbsp;<b><?= number_format($ppn,2,",",".");?> </b></td>
						<td colspan="1" style="border:1px solid black;text-align: right;">&nbsp;<b>(<?= number_format($pph,2,",",".");?>)</b></td>
						<td colspan="2" style="border:1px solid black;text-align: right;">&nbsp;<b><?= number_format($detail->net_payment,2,",",".");?> </b></td>

						<?php $total += $detail->net_payment; ?>
						<td colspan="1">&nbsp;</td>
					</tr>

				@endforeach

				<tr>
					<td colspan="10">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="10" style="text-align:right;font-weight: bold;padding:5px"><u>Grand Total : <?= number_format($total,2,",",".");?></u></td>
				</tr>
				<tr>
					<td colspan="10">&nbsp;</td>
				</tr>

				<tr>
					<td colspan="2" style="text-align: center;"></td>
					<td colspan="2" style="border: 1px solid black;text-align: center;">Staff</td>
					<td colspan="2" style="border: 1px solid black;text-align: center;">Manager</td>
					<td colspan="2" style="border: 1px solid black;text-align: center;">General Manager</td>
					<td colspan="2" style="text-align: center;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;"></td>
					<td colspan="2" style="border: 1px solid black;height: 40px;text-align: center;">
							<?= $payment->created_name ?>
					</td>
					<?php 
						$manager_stat = explode("/",$payment->status_manager);
						$dgm_stat = explode("/",$payment->status_dgm);
						$gm_stat = explode("/",$payment->status_gm);
					?>
					<td colspan="2" style="height: 40px;text-align: center">
						@if($manager_stat[0] == "Approved")
							<?= $payment->manager_name ?>
						@endif
					</td>
					
					<td colspan="2" style="border: 1px solid black;height: 40px;text-align: center">
						@if($gm_stat[0] == "Approved")
							Budhi Apriyanto
						@endif
					</td>
					<td colspan="2" style="text-align:center"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;"></td>
					<td colspan="2" style="border: 1px solid black;text-align: center;">
						<?= date('d-M-y', strtotime($payment->payment_date)) ?>		
					</td>
					<td colspan="2" style="border: 1px solid black;text-align: center;">
						@if($manager_stat[0] != null)
							<?= date('d-M-y', strtotime($manager_stat[1])) ?>		
						@endif
					</td>
					<td colspan="2" style="border: 1px solid black;text-align: center;">
						@if($gm_stat[0] != null)
							<?= date('d-M-y', strtotime($gm_stat[1])) ?>		
						@endif
					</td>
					<td colspan="2" style="text-align:center"></td>
				</tr>
			</thead>
		</table>
	</header>
	
</body>
</html>