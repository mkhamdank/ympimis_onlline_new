@extends('layouts.master')
@section('stylesheets')
@stop
@section('header')
    <div class="page-breadcrumb" style="padding: 7px">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{$title}}<span class="text-purple"> {{$title_jp}}</span></h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid" style="padding: 7px;min-height: 100vh">
        <div class="row"  style="padding: 5px">
            <div class="col-sm-4 col-xs-6" style="text-align: center; padding: 5px">
                <div class="card">
                    <div class="card-body" style="padding: 10px">
                        <h4 class="card-title"><span style="font-size: 20px; color: #0e691e;"><i class="fa fa-angle-double-down"></i> Process <i class="fa fa-angle-double-down"></i></span></h4>
                        <div class="text-end">
                            <?php if (Auth::user()->role_code == 'TRUE' || Auth::user()->role_code == 'MIS'): ?>
                                <a href="{{ url('/index/outgoing/true/input') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Input VFI PT. TRUE</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/serial_number/true') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Upload Serial Number PT. TRUE</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'ARISA' || Auth::user()->role_code == 'MIS'): ?>
                                <a href="{{ url('/index/kensa/arisa') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Production Check ARISA</a>
                                <a href="{{ url('/index/outgoing/arisa/input') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">QC Final Check ARISA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'KBI' || Auth::user()->role_code == 'MIS'): ?>
                                <a href="{{ url('/index/serial_number/kbi') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Upload Serial Number PT. KBI</a>
                                <a href="{{ url('/index/kensa/kbi') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Production Check KBI</a>
                                <!-- <a href="{{ url('/index/outgoing/arisa/input') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: green;background-color: green">QC Final Check ARISA</a> -->
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CRESTEC' || Auth::user()->role_code == 'MIS'): ?>
                                <a href="{{ url('/index/outgoing/crestec/master_defect') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Master Defect</a>
                                <a href="{{ url('/index/outgoing/crestec/input') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Sortir Produksi CRESTEC INDONESIA</a>
                                <a href="{{ url('/index/outgoing/crestec/sampling') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">QC Sampling CRESTEC INDONESIA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'LTI' || Auth::user()->role_code == 'MIS'): ?>
                                <a href="{{ url('/index/outgoing/lti/input') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Input VFI PT. LTI</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CPP' || Auth::user()->role_code == 'MIS'): ?>
                                <a href="{{ url('/index/outgoing/cpp/input') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #0e691e;background-color: white;color: #094a05">Input VFI PT. CPP</a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-xs-6" style="text-align: center;padding: 5px">
                <div class="card">
                    <div class="card-body" style="padding: 10px">
                        <h4 class="card-title"><span style="font-size: 20px;color: #e61010"><i class="fa fa-angle-double-down"></i> Display <i class="fa fa-angle-double-down"></i></span></h4>
                        <div class="text-end">
                            <?php if (Auth::user()->role_code == 'ARISA' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/outgoing/ng_rate/arisa') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production NG Rate ARISA</a>
                                <a href="{{ url('/index/outgoing/pareto/arisa') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production Pareto ARISA</a>
                                <a href="{{ url('/index/outgoing/lot_status/arisa') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Lot Monitoring ARISA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'TRUE' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/outgoing/ng_rate/true') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production NG Rate PT. TRUE</a>
                                <a href="{{ url('/index/outgoing/pareto/true') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production Pareto PT. TRUE</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'KBI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/outgoing/ng_rate/kbi') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production NG Rate KBI</a>
                                <a href="{{ url('/index/outgoing/pareto/kbi') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production Pareto KBI</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CRESTEC' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/outgoing/ng_rate/crestec') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Prod. NG Rate CRESTEC INDONESIA</a>
                                <a href="{{ url('/index/outgoing/pareto/crestec') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Prod. Pareto CRESTEC INDONESIA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'LTI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/outgoing/ng_rate/lti') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production NG Rate PT. LTI</a>
                                <a href="{{ url('/index/outgoing/pareto/lti') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production Pareto PT. LTI</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CPP' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/outgoing/ng_rate/cpp') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production NG Rate PT. CPP</a>
                                <a href="{{ url('/index/outgoing/pareto/cpp') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: #e61010;background-color: #fff;color: #4a0505 ">Production Pareto PT. CPP</a>
                            <?php endif ?>
                        </div>
                        <br>
                        <br>
                        <!-- <h4 class="card-title"><span style="font-size: 20px;color: #e61010"><i class="fa fa-angle-double-down"></i> Display Incoming YMPI <i class="fa fa-angle-double-down"></i></span></h4>
                        <div class="text-end">
                            <?php if (Auth::user()->role_code == 'TRUE' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/pareto/true') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">Pareto Incoming Check PT. TRUE</a>
                                <a href="{{ url('/index/incoming/ng_rate/true') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">NG Rate Incoming Check PT. TRUE</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'ARISA' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/pareto/arisa') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">Pareto Incoming Check PT. ARISA</a>
                                <a href="{{ url('/index/incoming/ng_rate/arisa') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">NG Rate Incoming Check PT. ARISA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'KBI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/pareto/kbi') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">Pareto Incoming Check PT. KBI</a>
                                <a href="{{ url('/index/incoming/ng_rate/kbi') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">NG Rate Incoming Check PT. KBI</a> -->
                                <!-- <a href="{{ url('/index/outgoing/arisa/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: red">Report QC Final ARISA</a> -->
                            <!-- <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CRESTEC' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/pareto/crestec') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">Pareto Incoming Check CRESTEC INDONESIA</a>
                                <a href="{{ url('/index/incoming/ng_rate/crestec') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">NG Rate Incoming Check CRESTEC INDONESIA</a>
                            <?php endif ?>

                            <?php if (Auth::user()->role_code == 'LTI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/pareto/lti') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">Pareto Incoming Check PT. LTI</a>
                                <a href="{{ url('/index/incoming/ng_rate/lti') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: red;background-color: white;color: #4a0505">NG Rate Incoming Check PT. LTI</a>
                            <?php endif ?>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-xs-6" style="text-align: center;padding: 5px">
                <div class="card">
                    <div class="card-body" style="padding: 10px">
                        <h4 class="card-title"><span style="font-size: 20px;color: purple"><i class="fa fa-angle-double-down"></i> Report Vendor Final Inspection <i class="fa fa-angle-double-down"></i></span></h4>
                        <div class="text-end">
                            <?php if (Auth::user()->role_code == 'TRUE' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/kensa/true/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Production Check PT. TRUE</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'ARISA' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/kensa/arisa/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Production Check ARISA</a>
                                <a href="{{ url('/index/outgoing/arisa/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report QC Final ARISA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'KBI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/kensa/kbi/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Production Check KBI</a>
                                <!-- <a href="{{ url('/index/outgoing/arisa/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: purple">Report QC Final ARISA</a> -->
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CRESTEC' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/kensa/crestec/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Production Check PT. CRESTEC</a>
                                <a href="{{ url('/index/sampling/crestec/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report QC Sampling PT. CRESTEC</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'LTI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/kensa/lti/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Production Check PT. LTI</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CPP' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/kensa/cpp/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Production Check PT. CPP</a>
                            <?php endif ?>
                        </div>
                        <br>
                        <br>

                        <!-- <h4 class="card-title"><span style="font-size: 20px;color: purple"><i class="fa fa-angle-double-down"></i> Report Incoming YMPI <i class="fa fa-angle-double-down"></i></span></h4>
                        <div class="text-end">
                            <?php if (Auth::user()->role_code == 'TRUE' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/true/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Incoming Check PT. TRUE</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'ARISA' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/arisa/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Incoming Check ARISA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'KBI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/kbi/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Incoming Check KBI</a> -->
                                <!-- <a href="{{ url('/index/outgoing/arisa/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: purple">Report QC Final ARISA</a> -->
                            <!-- <?php endif ?>
                            <?php if (Auth::user()->role_code == 'CRESTEC' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/crestec/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Incoming Check CRESTEC INDONESIA</a>
                            <?php endif ?>
                            <?php if (Auth::user()->role_code == 'LTI' || Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing'): ?>
                                <a href="{{ url('/index/incoming/lti/report') }}" class="btn btn-default btn-block" style="font-size: 17px; border-color: purple;background-color: white;color: #4a085e">Report Incoming Check PT. LTI</a>
                            <?php endif ?>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
@endsection