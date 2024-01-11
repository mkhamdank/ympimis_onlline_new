<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url("images/bridgesmall.png")}}" />
	<title>Bridge For Vendor</title>
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

        #tableDetail > thead > tr > th{
            border: 1px solid black;
            text-align: center;
        }
        #tableDetail > tbody > tr > td{
            border: 1px solid black;
            text-align: center;
            padding: 7px;
        }
        #tableAQL > thead > tr > th{
            border: 1px solid black;
            text-align: center;
        }

        #tableAQL > tbody > tr > td{
            border: 1px solid black;
            text-align: center;
            padding: 7px;
        }
        .page-break {
          page-break-after: always;
        }
	</style>
</head>

<body>
	<header>
        <center>
            <h2>FINISHING SORTING CHECK SHEET</h2>
        </center>
		<table style="width: 70%; font-family: TimesNewRoman; border-collapse: collapse; text-align: left;" >
        	<thead style="">
        		<tr>
        			<td style="padding:0px;width: 2%;">Date</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;{{$data[0]->sampling_date}}</td>
                    <td style="padding:0px;width: 2%;">PO Qty</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;{{$data[0]->qty_check}}</td>
                </tr>
                <!-- <tr>
    				
                </tr> -->
                <tr>
    				<td style="padding:0px;width: 2%;">Job No.</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;{{$data[0]->serial_number}}</td>
                    <td style="padding:0px;width: 2%;">Part Code / Name</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;{{$outgoing[0]->material_description}}</td>
                </tr>
                <!-- <tr>
                    
                </tr> -->
                <tr>
                    <td style="padding:0px;width: 2%;">Customer</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;PT. Yamaha Musical Products Indonesia</td>
                    <td style="padding:0px;width: 2%;">Shift</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;{{$data[0]->shift}}</td>
                </tr>
               <!--  <tr>
                    
                </tr> -->
                <tr>
                    <td style="padding:0px;width: 2%;">Line</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;{{$data[0]->line}}</td>
                    <td style="padding:0px;width: 2%;">Line Clearance</td>
                    <td style="padding:0px;width: 5%;">: &nbsp;&nbsp;{{$data[0]->line_clearance}}</td>
                </tr>
                <!-- <tr>
                    
                </tr> -->
        	</thead>
		</table>
        <br>
        <table id="tableDetail" style="width: 100%; font-family: TimesNewRoman; border-collapse: collapse; text-align: left;" >
            <thead>
                <tr>
                    <th rowspan="4" style="width: 2%;vertical-align: middle;">Frequency of Inspection</th>
                    <th rowspan="4" style="width: 2%;vertical-align: middle;">Time</th>
                    <th rowspan="4" style="width: 2%;vertical-align: middle;">Qty Sampling <span style="font-size: 9px;font-weight: normal;">(Refer to Note No. 2 & 3)</span></th>
                    <th colspan="9" style="width: 2%;">In Proses Check / IPC <span style="font-size: 9px;font-weight: normal;">(Refer to Note No. 1 & 4)</span></th>
                </tr>
                <tr>
                    <th rowspan="3" style="width: 2%;">Mix Up <br><span style="font-size: 9px;font-weight: normal;">(All Sample Qty)</span></th>
                    <th rowspan="3" style="width: 2%;">Design <br><span style="font-size: 9px;font-weight: normal;">(Sample Qty : 5 Pcs / every up)</span></th>
                    <th rowspan="3" style="width: 2%;">Visual Inspection <br><span style="font-size: 9px;font-weight: normal;">(All Sample Qty)</span></th>
                    <th colspan="5" style="width: 2%;">Dimension (mm)<br><span style="font-size: 9px;font-weight: normal;">(All Sample Qty)</span></th>
                    @if($data[0]->types != 'Not Set')
                    <th rowspan="3" style="width: 2%;" id="th_types"><span id="types">{{$data[0]->types}}</span> <br><span style="font-size: 9px;font-weight: normal;">(Sample Qty : 5 pcs / every up)</span></th>
                    @endif
                </tr>
                <tr>
                    <th colspan="5" style="width: 2%;">Specification :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        L : 
                        <span id="long" style="background-color: white;color: black">
                            {{$dimensi->point_check_upper}}
                        </span>&nbsp;&nbsp;&nbsp;
                        W : 
                        <span id="wide" style="background-color: white;color: black">
                            {{$dimensi->point_check_lower}}
                        </span>
                        @if($dimensi->point_check_height != null)
                        &nbsp;&nbsp;&nbsp;
                        H : 
                        <span id="height" style="background-color: white;color: black">
                            {{$dimensi->point_check_height}}
                        </span>
                        @endif
                    </th>
                </tr>
                <tr>
                    <th style="width: 2%;">Sample 1</th>
                    <th style="width: 2%;">Sample 2</th>
                    <th style="width: 2%;">Sample 3</th>
                    <th style="width: 2%;">Sample 4</th>
                    <th style="width: 2%;">Sample 5</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $qty_check = [];
                $qty_all = 0;
                $acc = 0;
                $re = 0;
                $ok = 0;
                $ng = 0;
                $detail_ng = '';
                ?>
                <tr>
                    <td>Start (S)</td>
                    <?php 
                        $time = '';
                        $qty = '';
                        $mixup = '';
                        $design = '';
                        $visual = '';
                        $dimension_long = [];
                        $dimension_wide = [];
                        $dimension_height = [];
                        $types = '';
                    ?>
                    <?php for ($i=0; $i < count($data); $i++) { 
                        if ($data[$i]->frequency == 'Start') {
                            if ($data[$i]->result_check != null) {
                                $time = $data[$i]->check_time;
                                $qty = $data[$i]->qty_sampling;
                                array_push($qty_check, $data[$i]->qty_sampling);
                                $qty_all = $data[$i]->qty_total;
                                $acc = $data[$i]->acceptance;
                                $re = $data[$i]->reject;
                                $ok = $data[$i]->qty_ok;
                                $ng = $data[$i]->qty_ng;
                                if ($data[$i]->detail_ng != null) {
                                    $detail_ng = $data[$i]->detail_ng;
                                }
                                if ($data[$i]->point_check_type == 'mixup') {
                                    $mixup = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'design') {
                                    $design = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'visual') {
                                    $visual = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'types') {
                                    $types = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'dimension') {
                                    if ($data[$i]->point_check_name == 'long') {
                                        array_push($dimension_long, $data[$i]->result_check);
                                    }
                                    if ($data[$i]->point_check_name == 'wide') {
                                        array_push($dimension_wide, $data[$i]->result_check);
                                    }
                                    if ($data[$i]->point_check_name == 'height') {
                                        array_push($dimension_height, $data[$i]->result_check);
                                    }
                                }
                            }
                        }
                    } ?>
                    @if($time != '')
                    <td>{{$time}}</td>
                    <td>{{$qty}}</td>
                    <td>{{$mixup}}</td>
                    <td>{{$design}}</td>
                    <td>{{$visual}}</td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[0]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[0]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[0]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[1]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[1]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[1]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[2]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[2]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[2]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[3]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[3]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[3]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[4]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[4]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[4]}}<br>
                        @endif
                    </td>
                    <td>{{$types}}</td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td>Middle (M)</td>
                    <?php 
                        $time = '';
                        $qty = '';
                        $mixup = '';
                        $design = '';
                        $visual = '';
                        $dimension_long = [];
                        $dimension_wide = [];
                        $dimension_height = [];
                        $types = '';
                    ?>
                    <?php for ($i=0; $i < count($data); $i++) { 
                        if ($data[$i]->frequency == 'Middle') {
                            if ($data[$i]->result_check != null) {
                                $time = $data[$i]->check_time;
                                $qty = $data[$i]->qty_sampling;
                                array_push($qty_check, $data[$i]->qty_sampling);
                                if ($data[$i]->point_check_type == 'mixup') {
                                    $mixup = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'design') {
                                    $design = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'visual') {
                                    $visual = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'types') {
                                    $types = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'dimension') {
                                    if ($data[$i]->point_check_name == 'long') {
                                        array_push($dimension_long, $data[$i]->result_check);
                                    }
                                    if ($data[$i]->point_check_name == 'wide') {
                                        array_push($dimension_wide, $data[$i]->result_check);
                                    }
                                    if ($data[$i]->point_check_name == 'height') {
                                        array_push($dimension_height, $data[$i]->result_check);
                                    }
                                }
                            }
                        }
                    } ?>
                    @if($time != '')
                    <td>{{$time}}</td>
                    <td>{{$qty}}</td>
                    <td>{{$mixup}}</td>
                    <td>{{$design}}</td>
                    <td>{{$visual}}</td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[0]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[0]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[0]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[1]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[1]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[1]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[2]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[2]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[2]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[3]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[3]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[3]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[4]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[4]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[4]}}<br>
                        @endif
                    </td>
                    <td>{{$types}}</td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td>End (E)</td>
                    <?php 
                        $time = '';
                        $qty = '';
                        $mixup = '';
                        $design = '';
                        $visual = '';
                        $dimension_long = [];
                        $dimension_wide = [];
                        $dimension_height = [];
                        $types = '';
                    ?>
                    <?php for ($i=0; $i < count($data); $i++) { 
                        if ($data[$i]->frequency == 'End') {
                            if ($data[$i]->result_check != null) {
                                $time = $data[$i]->check_time;
                                $qty = $data[$i]->qty_sampling;
                                array_push($qty_check, $data[$i]->qty_sampling);
                                if ($data[$i]->point_check_type == 'mixup') {
                                    $mixup = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'design') {
                                    $design = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'visual') {
                                    $visual = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'types') {
                                    $types = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'dimension') {
                                    if ($data[$i]->point_check_name == 'long') {
                                        array_push($dimension_long, $data[$i]->result_check);
                                    }
                                    if ($data[$i]->point_check_name == 'wide') {
                                        array_push($dimension_wide, $data[$i]->result_check);
                                    }
                                    if ($data[$i]->point_check_name == 'height') {
                                        array_push($dimension_height, $data[$i]->result_check);
                                    }
                                }
                            }
                        }
                    } ?>
                    @if($time != '')
                    <td>{{$time}}</td>
                    <td>{{$qty}}</td>
                    <td>{{$mixup}}</td>
                    <td>{{$design}}</td>
                    <td>{{$visual}}</td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[0]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[0]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[0]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[1]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[1]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[1]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[2]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[2]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[2]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[3]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[3]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[3]}}<br>
                        @endif
                    </td>
                    <td>
                        @if(count($dimension_long) != 0)
                        L : {{$dimension_long[4]}}<br>
                        @endif
                        @if(count($dimension_wide) != 0)
                        W : {{$dimension_wide[4]}}<br>
                        @endif
                        @if(count($dimension_height) != 0)
                        H : {{$dimension_height[4]}}<br>
                        @endif
                    </td>
                    <td>{{$types}}</td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td rowspan="4" style="background-color: #dedede">Composite Sample (Pcs)</td>
                    <td>S = {{$qty_check[0]}}</td>
                    <td rowspan="4" style="background-color: #dedede">Check Result Sampling (Pcs)</td>
                    <td style="background-color: #dedede">Acc</td>
                    <td style="background-color: #dedede">Total OK</td>
                    <td style="background-color: #dedede" colspan="4">Detail NG</td>
                    <td colspan="3" style="text-align: right;"><span style="font-size: 8px;">* All In Process Check (IPC) sample need to be destroyed after testing</span></td>
                </tr>
                <tr>
                    <td>M = {{$qty_check[1]}}</td>
                    <td>{{$acc}}</td>
                    <td>{{$ok}}</td>
                    <td rowspan="3" colspan="4">
                        <?php if ($detail_ng != ''): ?>
                            <?php 
                            $ng_name = explode(',', explode('_', $detail_ng)[0]);
                            $ng_qty = explode(',', explode('_', $detail_ng)[1]);
                            for ($i=0; $i < count($ng_name); $i++) { 
                                echo $ng_name[$i].' = '.$ng_qty[$i].' ; ';
                            }
                            ?>
                        <?php endif ?>
                    </td>
                    <td colspan="2" style="background-color: #dedede">Line Clearance</td>
                    <td>{{$data[0]->line_clearance}}</td>
                </tr>
                <tr>
                    <td>E = {{$qty_check[2]}}</td>
                    <td style="background-color: #dedede">Re</td>
                    <td style="background-color: #dedede">Total NG</td>
                    <td rowspan="2" style="background-color: #dedede">Lot Status</td>
                    @if($data[0]->lot_status == 'LOT OK')
                    <td rowspan="2" colspan="2" style="font-size: 20px;font-weight: bold;background-color: #d2ffbf">{{$data[0]->lot_status}}</td>
                    @else
                    <td rowspan="2" colspan="2" style="font-size: 20px;font-weight: bold;background-color: #ffc2c2">{{$data[0]->lot_status}}</td>
                    @endif
                </tr>
                <tr>
                    <td>Total = {{$qty_all}}</td>
                    <td>{{$re}}</td>
                    <td>{{$ng}}</td>
                </tr>
            </tbody>
        </table>
        <div class="page-break">
            
        </div>
        <center>
            <h2>AQL and Testing on Composite Sample (Out Going)</h2>
        </center>
        <table id="tableAQL" style="width: 100%; font-family: TimesNewRoman; border-collapse: collapse; text-align: left;" >
            <thead>
                <tr>
                    <th style="vertical-align: middle;border:0px;font-weight: normal;text-align: left;" colspan="8">* Composite Sample Qty : <b>{{$data[0]->qty_check}}</b> Pcs</th>
                </tr>
                <tr>
                    <th rowspan="2" style="width: 2%;vertical-align: middle;">Testing on Composite Sample</th>
                    <th colspan="6" style="width: 5%;vertical-align: middle;">Testing Column</th>
                    <th rowspan="2" style="width: 2%;vertical-align: middle;">Method Reference No.</th>
                </tr>
                <tr>
                    <th>AQL<br>(as per AQL table)</th>
                    <th>Acc</th>
                    <th>Re</th>
                    <th colspan="3">Result<br>(OK / NG)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php 
                        $time = '';
                        $qty = '';
                        $mixup = '';
                        $design = '';
                        $visual = '';
                        $std_long = '';
                        $std_wide = '';
                        $std_height = '';
                        $dimension_long = [];
                        $dimension_wide = [];
                        $dimension_height = [];
                        $types = '';
                    ?>
                    <?php for ($i=0; $i < count($data); $i++) { 
                        if ($data[$i]->frequency == 'Start') {
                            if ($data[$i]->result_check != null) {
                                $time = $data[$i]->check_time;
                                $qty = $data[$i]->qty_sampling;
                                array_push($qty_check, $data[$i]->qty_sampling);
                                if ($data[$i]->point_check_type == 'mixup') {
                                    $mixup = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'design') {
                                    $design = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'visual') {
                                    $visual = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'types') {
                                    $types = $data[$i]->result_check;
                                }
                                if ($data[$i]->point_check_type == 'dimension') {
                                    if ($data[$i]->point_check_name == 'long') {
                                        array_push($dimension_long, $data[$i]->result_check);
                                        $std_long = $data[$i]->standard;
                                    }
                                    if ($data[$i]->point_check_name == 'wide') {
                                        array_push($dimension_wide, $data[$i]->result_check);
                                        $std_wide = $data[$i]->standard;
                                    }
                                    if ($data[$i]->point_check_name == 'height') {
                                        array_push($dimension_height, $data[$i]->result_check);
                                        $std_height = $data[$i]->standard;
                                    }
                                }
                            }
                        }
                    } ?>
                    <?php 
                        $acc = '';
                        $re = '';
                        $acc2 = '';
                        $re2 = '';
                        for ($k=0; $k < count($aql); $k++) { 
                            if ($aql[$k]->inspection_leves == 'AQL0') {
                                $acc = $aql[$k]->lot_ok;
                                $re = $aql[$k]->lot_out;
                            }
                            if ($aql[$k]->inspection_leves == 'AQL15') {
                                $acc2 = $aql[$k]->lot_ok;
                                $re2 = $aql[$k]->lot_out;
                            }
                        }
                    ?>
                    <td>Mix Up</td>
                    <td>0%</td>
                    <td>{{$acc}}</td>
                    <td>{{$re}}</td>
                    <td colspan="3">{{$mixup}}</td>
                    <td rowspan="5" style="font-size: 20px;">CINP-IK-QC-02</td>
                </tr>
                <tr>
                    <td>Design</td>
                    <td>0%</td>
                    <td>{{$acc}}</td>
                    <td>{{$re}}</td>
                    <td colspan="3">{{$design}}</td>
                </tr>
                <tr>
                    <td>Visual Inspection</td>
                    <td>1.5%</td>
                    <td>{{$acc2}}</td>
                    <td>{{$re2}}</td>
                    <td colspan="3">{{$visual}}</td>
                </tr>
                <tr>
                    <td>Dimension (mm)</td>
                    <td style="padding: 0px;">
                        <table style="width: 100%;padding: 0px;text-align: center;">
                            <tr>
                                <td style="border-bottom: 1px solid black;padding: 0px;">Specification</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    @if($std_long != '')
                                    L : {{$std_long}}<br>
                                    @endif
                                    @if($std_wide != '')
                                    W : {{$std_wide}}<br>
                                    @endif
                                    @if($std_height != '')
                                    H : {{$std_height}}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%;padding: 0px;text-align: center;">
                            <tr>
                                <td style="border-bottom: 1px solid black;padding: 0px;">Sample 1</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    @if(count($dimension_long) != 0)
                                    L : {{$dimension_long[0]}}<br>
                                    @endif
                                    @if(count($dimension_wide) != 0)
                                    W : {{$dimension_wide[0]}}<br>
                                    @endif
                                    @if(count($dimension_height) != 0)
                                    H : {{$dimension_height[0]}}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%;padding: 0px;text-align: center;">
                            <tr>
                                <td style="border-bottom: 1px solid black;padding: 0px;">Sample 2</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    @if(count($dimension_long) != 0)
                                    L : {{$dimension_long[1]}}<br>
                                    @endif
                                    @if(count($dimension_wide) != 0)
                                    W : {{$dimension_wide[1]}}<br>
                                    @endif
                                    @if(count($dimension_height) != 0)
                                    H : {{$dimension_height[1]}}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%;padding: 0px;text-align: center;">
                            <tr>
                                <td style="border-bottom: 1px solid black;padding: 0px;">Sample 3</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    @if(count($dimension_long) != 0)
                                    L : {{$dimension_long[2]}}<br>
                                    @endif
                                    @if(count($dimension_wide) != 0)
                                    W : {{$dimension_wide[2]}}<br>
                                    @endif
                                    @if(count($dimension_height) != 0)
                                    H : {{$dimension_height[2]}}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%;padding: 0px;text-align: center;">
                            <tr>
                                <td style="border-bottom: 1px solid black;padding: 0px;">Sample 4</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    @if(count($dimension_long) != 0)
                                    L : {{$dimension_long[3]}}<br>
                                    @endif
                                    @if(count($dimension_wide) != 0)
                                    W : {{$dimension_wide[3]}}<br>
                                    @endif
                                    @if(count($dimension_height) != 0)
                                    H : {{$dimension_height[3]}}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width: 100%;padding: 0px;text-align: center;">
                            <tr>
                                <td style="border-bottom: 1px solid black;padding: 0px;">Sample 5</td>
                            </tr>
                            <tr>
                                <td style="padding: 0px;">
                                    @if(count($dimension_long) != 0)
                                    L : {{$dimension_long[4]}}<br>
                                    @endif
                                    @if(count($dimension_wide) != 0)
                                    W : {{$dimension_wide[4]}}<br>
                                    @endif
                                    @if(count($dimension_height) != 0)
                                    H : {{$dimension_height[4]}}<br>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @if($data[0]->types != 'Not Set')
                <tr>
                    <td>{{$data[0]->types}}</td>
                    <td>1.5%</td>
                    <td>{{$acc2}}</td>
                    <td>{{$re2}}</td>
                    <td colspan="3">{{$types}}</td>
                </tr>
                @endif
                <tr>
                    <td style="vertical-align: middle;border:0px;font-weight: normal;text-align: left;" colspan="8"><b>Note:</b><br>
                        Retention Sample : 1 pcs (Only MSD : Yes / No)
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;border:0px;font-weight: normal;text-align: left;" colspan="8"><b>Release the Lot on IPO</b>
                    </td>
                </tr>
            </tbody>
        </table>
       <!--  <table style="width: 50%; font-family: TimesNewRoman; border-collapse: collapse; text-align: left;padding-top: 50px;">
            <tr>
                <td style="text-decoration: underline;font-weight: bold;">Performed By,</td>
                <td style="text-decoration: underline;font-weight: bold;">Performed By,</td>
            </tr>
            <tr>
                <td style="text-decoration: underline;font-weight: bold;">Reviewed By,</td>
            </tr>
        </table> -->
	</header>
	
</body>
</html>