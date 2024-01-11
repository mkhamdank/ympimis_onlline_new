@extends('layouts.master')
@section('stylesheets')
@stop
@section('header')
    <div class="page-breadcrumb" style="padding: 7px">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">{{ $title }}<span class="text-purple"> {{ $vendor }}</span></h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid" style="padding: 7px; min-height: 100vh">
        <div class="row" style="padding: 5px">
            <div class="col-sm-4 col-xs-6" style="text-align: center; padding: 5px">
                <div class="card">
                    <div class="card-body" style="padding: 10px">
                        <h4 class="card-title">
                            <span style="font-size: 20px; color: #0e691e;">
                                <i class="fa fa-angle-double-down"></i> Inquiry <i class="fa fa-angle-double-down"></i>
                            </span>
                        </h4>
                        <div class="text-end">
                            <a href="{{ url('/index/material_master') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #0e691e; background-color: white; color: #094a05">
                                Material Master
                            </a>
                            <a href="{{ url('/index/material_bom') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #0e691e; background-color: white; color: #094a05">
                                BOM
                            </a>
                            <a href="{{ url('/index/stock_inquiry') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #0e691e; background-color: white; color: #094a05">
                                Stock Inquiry
                            </a>
                            <a href="{{ url('/index/transaction_log') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #0e691e; background-color: white; color: #094a05">
                                Transaction Log
                            </a>
                            <a href="{{ url('/index/forecast') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #0e691e; background-color: white; color: #094a05">
                                YMPI Forecast
                            </a>
                            <a href="{{ url('/index/plan_delivery') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #0e691e; background-color: white; color: #094a05">
                                YMPI Plan Deliv.
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-6" style="text-align: center;padding: 5px">
                <div class="card">
                    <div class="card-body" style="padding: 10px">
                        <h4 class="card-title">
                            <span style="font-size: 20px;color: #e61010">
                                <i class="fa fa-angle-double-down"></i> Process
                                <i class="fa fa-angle-double-down"></i>
                            </span>
                        </h4>
                        <div class="text-end">
                            <a href="{{ url('/index/mrp_simulation') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #e61010; background-color: #fff; color: #4a0505;">
                                MRP Simulation
                            </a>
                            <a href="{{ url('/index/goods_receipt') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #e61010; background-color: #fff; color: #4a0505;">
                                Goods Receipt
                            </a>
                            <a href="{{ url('/index/completion') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #e61010; background-color: #fff; color: #4a0505;">
                                Completion
                            </a>
                            @if ($vendor != 'UD. RAHAYU KUSUMA')
                                <a href="" class="btn btn-default btn-block"
                                    style="font-size: 17px; border-color: #e61010; background-color: #fff; color: #4a0505;">
                                    Goods Movement
                                </a>
                            @endif
                            <a href="{{ url('/index/delivery_order') . '/' . $role }}" class="btn btn-default btn-block"
                                style="font-size: 17px; border-color: #e61010; background-color: #fff; color: #4a0505;">
                                Shipment
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-sm-4 col-xs-6" style="text-align: center;padding: 5px">
                <div class="card">
                    <div class="card-body" style="padding: 10px">
                        <h4 class="card-title">
                            <span style="font-size: 20px;color: purple">
                                <i class="fa fa-angle-double-down"></i> Display
                                <i class="fa fa-angle-double-down"></i>
                            </span>
                        </h4>
                        <div class="text-end">
                            <a href="" class="btn btn-default btn-block"
                                style="pointer-events: none; font-size: 17px; border-color: purple;background-color: #ebebeb;color: #4a085e">
                                Material Availability
                            </a>
                            <a href="" class="btn btn-default btn-block"
                                style="pointer-events: none; font-size: 17px; border-color: purple; background-color: #ebebeb; color: #4a085e">
                                Outstanding PO
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@stop
@section('scripts')
@endsection
