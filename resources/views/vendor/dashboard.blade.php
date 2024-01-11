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
        <input type="hidden" id="vendor_nickname" value="{{ $vendor_nickname }}">
        <div class="row" style="padding: 5px">
            <div class="col-sm-12 col-xs-12" style="margin-bottom: 2%;">
                <div class="col-xs-2 col-sm-2 pull-right" style="display: inline-block; padding: 0px;">
                    <p style="text-align: left; padding-left: 15px; margin: 0px;">
                        Delivery Month :
                    </p>
                    <div class="col-xs-12 col-sm-12">
                        <input type="text" class="form-control datepicker" id="filterMonth" placeholder="Select Month"
                            onchange="drawChart()" style="text-align: center;">
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="height: 70vh; padding-right: 0px;">
                <div id="chart0" style="width: 100%"></div>
            </div>
            <div class="col-sm-8" style="height: 70vh; padding-left: 0px;">
                <div id="chart1" style="width: 100%"></div>
            </div>
            <div class="row" id="detail_material">
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="tittleDetail"
                        style="background-color: #f2f2f2; font-weight: bold; padding: 1%; margin-top: 0; color: #54667a; width: 100%; text-align: center;">
                    </h2>
                </div>
                <div class="modal-body table-responsive" style="min-height: 100px; padding-bottom: 25px;">
                    <div class="col-xs-12">
                        <table class="table table-bordered" id="tableDetail">
                            <thead style="background-color: rgba(126,86,134,.7);" id="headDetail">
                            </thead>
                            <tbody id="bodyDetail">
                            </tbody>
                            <tfoot id="footDetail">
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="<?php echo e(url('js/jquery.numpad.js')); ?>"></script>
    <script src="{{ url('js/jquery.gritter.min.js') }}"></script>
    <script src="{{ url('js/highcharts.js') }}"></script>
    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/jquery.flot.min.js') }}"></script>
    <script src="{{ url('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('js/buttons.flash.min.js') }}"></script>
    <script src="{{ url('js/jszip.min.js') }}"></script>
    <script src="{{ url('js/vfs_fonts.js') }}"></script>
    <script src="{{ url('js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('js/buttons.print.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var user = "{{ Auth::user()->role_code }}";

        jQuery(document).ready(function() {
            $('#filterMonth').datepicker({
                format: "yyyy-mm",
                startView: "months",
                minViewMode: "months",
                autoclose: true,
                todayHighlight: true
            });
            drawChart();

        });

        var availabilities = [];
        var plan_delivery = [];

        function drawChart() {

            var data = {
                month: $('#filterMonth').val(),
                vendor_nickname: $('#vendor_nickname').val(),
            }


            $.get('{{ url('fetch/stock_control/availability') }}', data, function(result, status, xhr) {
                if (result.status) {

                    var series = [];
                    var xSeries = ['0%', '< 30%', '< 70%', '< 100%', '> 100%', '> 200%', '> 300%'];
                    var color_palette = ['#32bbad', '#ffc3ff', '#ccffff', '#d3b5ac', '#ecff7b', '#8b85f4',
                        '#808087', '#22cc7d', '#3985e0'
                    ];

                    availabilities = result.percentage;

                    for (let h = 0; h < result.type.length; h++) {

                        var name = result.type[h].category;
                        var color = color_palette[h];
                        var data = [];

                        for (let i = 0; i < xSeries.length; i++) {
                            var count_item = 0
                            for (let j = 0; j < result.percentage.length; j++) {
                                if (result.type[h].category == result.percentage[j].material_type &&
                                    xSeries[i] == result.percentage[j].remark) {
                                    count_item++;
                                }
                            }
                            data.push(count_item);
                        }

                        series.push({
                            'name': name,
                            'color': color,
                            'data': data
                        });
                    }

                    Highcharts.chart('chart0', {
                        chart: {
                            backgroundColor: null,
                            type: 'column',
                        },
                        title: {
                            text: 'AVAILABILITY STOCK'
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            categories: xSeries,
                            plotBands: [{
                                from: -0.5,
                                to: 3.5,
                                color: 'RGB(255,204,255)',
                                label: {
                                    text: '<em>Not Safe</em>',
                                    style: {
                                        color: 'red'
                                    },
                                    y: -5
                                }
                            }, {
                                from: 3.5,
                                to: 4.5,
                                color: 'RGB(204,255,255)',
                                label: {
                                    text: '<em>Safe</em>',
                                    style: {
                                        color: 'green'
                                    },
                                    y: -5
                                }
                            }, {
                                from: 4.5,
                                to: 6.5,
                                color: '#FFAB85',
                                label: {
                                    text: '<em>Over</em>',
                                    style: {
                                        color: '#7A2700'
                                    },
                                    y: -5
                                }
                            }]
                        },
                        yAxis: [{
                            title: {
                                text: 'Quantity',
                                style: {
                                    fontWeight: 'bold',
                                },
                            },
                            stackLabels: {
                                enabled: true,
                                style: {
                                    fontWeight: 'bold',
                                    fontSize: '0.8vw'
                                }
                            },
                        }],
                        exporting: {
                            enabled: false
                        },
                        legend: {
                            enabled: true,
                            borderWidth: 1
                        },
                        tooltip: {
                            enabled: true
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                pointPadding: 0.93,
                                groupPadding: 0.93,
                                borderWidth: 0.8,
                                borderColor: 'black'
                            },
                            series: {
                                dataLabels: {
                                    enabled: true,
                                    formatter: function() {
                                        return (this.y != 0) ? this.y : "";
                                    },
                                    style: {
                                        textOutline: false
                                    }
                                },
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function() {
                                            fetchModalAvailability(this.category, this.series.name);
                                        }
                                    }
                                }
                            }
                        },
                        series: series
                    });

                }
            });


            $.get('{{ url('fetch/stock_control/plan_delivery') }}', data, function(result, status, xhr) {
                if (result.status) {

                    if ($('#filterMonth').val() != result.month) {
                        $('#filterMonth').val(result.month);
                    }

                    var categories = [];
                    var plan = [];
                    var actual = [];

                    plan_delivery = result.delivery;

                    for (var i = 0; i < result.calendar.length; i++) {

                        categories.push(result.calendar[i].date);

                        if (result.calendar[i].remark != 'H') {
                            var acc_plan = 0;
                            var acc_actual = 0;

                            var diff = 0;
                            for (var j = 0; j < result.delivery.length; j++) {
                                if (result.delivery[j].due_date <= result.calendar[i].week_date) {
                                    acc_plan += parseInt(result.delivery[j].plan);
                                    acc_actual += parseInt(result.delivery[j].actual);
                                }
                            }

                            var diff = acc_plan - acc_actual;

                            plan.push(diff);
                            actual.push(acc_actual);

                        } else {

                            plan.push(0);
                            actual.push(0);

                        }

                    }

                    Highcharts.chart('chart1', {
                        chart: {
                            backgroundColor: null,
                            type: 'column',
                        },
                        title: {
                            text: 'VENDOR PRODUCTION ACHIEVEMENT FOR PLAN DELIVERY'
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            title: {
                                text: 'Date',
                                style: {
                                    fontWeight: 'bold',
                                },
                            },
                            tickInterval: 1,
                            gridLineWidth: 1,
                            categories: categories,
                            crosshair: true
                        },
                        yAxis: [{
                            title: {
                                text: 'Quantity',
                                style: {
                                    fontWeight: 'bold',
                                },
                            },
                            stackLabels: {
                                enabled: false,
                            },
                        }],
                        exporting: {
                            enabled: false
                        },
                        legend: {
                            enabled: true,
                            borderWidth: 1
                        },
                        tooltip: {
                            enabled: true
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                pointPadding: 0.93,
                                groupPadding: 0.93,
                                borderWidth: 0.8,
                                borderColor: 'black',
                            },
                            series: {
                                dataLabels: {
                                    enabled: true,
                                    rotation: -90,
                                    formatter: function() {
                                        return (this.y != 0) ? this.y : "";
                                    },
                                    style: {
                                        textOutline: false
                                    }
                                },
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function() {
                                            fetchModalPlan(this.category, this.series.name);
                                        }
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'Accumulative Plan Delivery',
                            data: plan,
                            color: '#6c2c2c'
                        }, {
                            name: 'Accumulative Actual Production',
                            data: actual,
                            color: '#06ec06'
                        }]
                    });


                    var appendData = '';
                    for (let x = 0; x < result.material.length; x++) {
                        appendData += '<div class="col-sm-6" style="padding: 0px;">';
                        appendData += '<div id="chart' + result.material[x].material_number + '">AAA</div>';
                        appendData += '</div>';
                    }
                    $('#detail_material').append(appendData);

                    for (let x = 0; x < result.material.length; x++) {
                        var categories = [];
                        var plan = [];
                        var actual = [];

                        for (var i = 0; i < result.calendar.length; i++) {
                            categories.push(result.calendar[i].date);

                            if (result.calendar[i].remark != 'H') {
                                var acc_plan = 0;
                                var acc_actual = 0;

                                var diff = 0;
                                for (var j = 0; j < result.delivery.length; j++) {
                                    if (result.delivery[j].material_number == result.material[x].material_number) {
                                        if (result.delivery[j].due_date <= result.calendar[i].week_date) {
                                            acc_plan += parseInt(result.delivery[j].plan);
                                            acc_actual += parseInt(result.delivery[j].actual);
                                        }
                                    }
                                }

                                var diff = acc_plan - acc_actual;

                                plan.push(diff);
                                actual.push(acc_actual);

                            } else {

                                plan.push(0);
                                actual.push(0);

                            }

                        }

                        Highcharts.chart('chart' + result.material[x].material_number, {
                            chart: {
                                backgroundColor: null,
                                type: 'column',
                            },
                            title: {
                                text: 'VENDOR PRODUCTION ACHIEVEMENT FOR PLAN DELIVERY',
                                style: {
                                    fontSize: '16px',
                                }
                            },
                            subtitle: {
                                text: result.material[x].material_number + ' - ' + result.material[x]
                                    .material_description
                            },
                            credits: {
                                enabled: false
                            },
                            xAxis: {
                                title: {
                                    text: 'Date',
                                    style: {
                                        fontWeight: 'bold',
                                    },
                                },
                                tickInterval: 1,
                                gridLineWidth: 1,
                                categories: categories,
                                crosshair: true
                            },
                            yAxis: [{
                                title: {
                                    text: 'Quantity',
                                    style: {
                                        fontWeight: 'bold',
                                    },
                                },
                                stackLabels: {
                                    enabled: false,
                                },
                            }],
                            exporting: {
                                enabled: false
                            },
                            legend: {
                                enabled: false,
                            },
                            tooltip: {
                                enabled: true
                            },
                            plotOptions: {
                                column: {
                                    stacking: 'normal',
                                    pointPadding: 0.93,
                                    groupPadding: 0.93,
                                    borderWidth: 0.8,
                                    borderColor: 'black',
                                },
                                series: {
                                    dataLabels: {
                                        enabled: true,
                                        rotation: -90,
                                        formatter: function() {
                                            return (this.y != 0) ? this.y : "";
                                        },
                                        style: {
                                            textOutline: false
                                        }
                                    },
                                }
                            },
                            series: [{
                                name: 'Accumulative Plan Delivery',
                                data: plan,
                                color: '#6c2c2c'
                            }, {
                                name: 'Accumulative Actual Production',
                                data: actual,
                                color: '#06ec06'
                            }]
                        });



                    }

                }
            });
        }

        function fetchModalPlan(category, name) {

            $('#tittleDetail').html('DELIVERY DETAIL');
            $('#headDetail').html('');
            $('#bodyDetail').html('');
            $('#footDetail').html('');

            var haedData = '';
            haedData += '<tr>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Date';
            haedData += '</th>';
            haedData += '<th style="width: 3%; text-align: center; vertical-align: middle;">';
            haedData += 'Material';
            haedData += '</th>';
            haedData += '<th style="width: 3%; text-align: center; vertical-align: middle;">';
            haedData += 'Description';
            haedData += '</th>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Plan';
            haedData += '</th>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Actual';
            haedData += '</th>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Diff';
            haedData += '</th>';
            haedData += '</tr>';
            $('#headDetail').append(haedData);

            console.log(plan_delivery);

            var resume = [];
            for (let i = 0; i < plan_delivery.length; i++) {
                if (plan_delivery[i].date <= category) {
                    var key = plan_delivery[i].material_number;

                    if (!resume[key]) {
                        resume[key] = {
                            'material_number': plan_delivery[i].material_number,
                            'material_description': plan_delivery[i].material_description,
                            'plan': plan_delivery[i].plan,
                            'actual': plan_delivery[i].actual,
                        };
                    } else {
                        resume[key].plan = parseInt(resume[key].plan) + parseInt(plan_delivery[i].plan);
                        resume[key].actual = parseInt(resume[key].actual) + parseInt(plan_delivery[i].actual);
                    }
                }
            }

            resume.sort(function(a, b) {
                return a.material_number - b.material_number
            });


            var total_plan = 0;
            var total_actual = 0;
            var tableData = '';
            for (var key in resume) {
                tableData += '<tr>';
                tableData += '<td style="width: 5%; text-align: center;">';
                tableData += category + '</td>';

                tableData += '<td style="width: 1%; text-align: center;">';
                tableData += resume[key].material_number + '</td>';

                tableData += '<td style="width: 30%; text-align: left;">';
                tableData += resume[key].material_description + '</td>';

                tableData += '<td style="width: 1%; text-align: right;">';
                tableData += resume[key].plan + '</td>';
                total_plan += parseInt(resume[key].plan);

                tableData += '<td style="width: 1%; text-align: right;">';
                tableData += resume[key].actual + '</td>';
                total_actual += parseInt(resume[key].actual);

                var color = '#ffccff';
                if ((resume[key].actual - resume[key].plan) == 0) {
                    color = '#ccffff';
                }
                tableData += '<td style="width: 1%; text-align: right; font-weight: bold; ';
                tableData += 'background-color: ' + color + ';">';
                tableData += resume[key].actual - resume[key].plan;
                tableData += '</td>';

                tableData += '</tr>';
            }
            $('#bodyDetail').append(tableData);

            var footData = '';
            var total_diff = total_actual - total_plan;
            footData += '<tr>';
            footData += '<th colspan="3" style="background-color: #fcf8e3; text-align: center;">Total</th>';
            footData += '<th style="background-color: #fcf8e3; text-align: right;">' + total_plan + '</th>';
            footData += '<th style="background-color: #fcf8e3; text-align: right;">' + total_actual + '</th>';
            footData += '<th style="background-color: #fcf8e3; text-align: right;">' + total_diff + '</th>';
            footData += '</tr>';
            $('#footDetail').append(footData);

            $('#modalDetail').modal('show');

        }

        function fetchModalAvailability(category, name) {

            console.log(category);
            console.log(name);

            $('#tittleDetail').html('AVAILABILITY DETAIL');
            $('#headDetail').html('');
            $('#bodyDetail').html('');
            $('#footDetail').html('');

            var haedData = '';
            haedData += '<tr>';
            haedData += '<th style="width: 3%; text-align: center; vertical-align: middle;">';
            haedData += 'Material';
            haedData += '</th>';
            haedData += '<th style="width: 3%; text-align: center; vertical-align: middle;">';
            haedData += 'Description';
            haedData += '</th>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Category';
            haedData += '</th>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Stock Policy';
            haedData += '</th>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Actual Stock';
            haedData += '</th>';
            haedData += '<th style="width: 1%; text-align: center; vertical-align: middle;">';
            haedData += 'Stock Condition';
            haedData += '</th>';
            haedData += '</tr>';
            $('#headDetail').append(haedData);

            availabilities.sort(function(a, b) {
                return a.percentage - b.percentage
            });



            var tableData = '';
            for (let i = 0; i < availabilities.length; i++) {
                if (availabilities[i].remark == category && availabilities[i].material_type == name) {
                    tableData += '<tr>';
                    tableData += '<td style="width: 1%; text-align: center;">' + availabilities[i].material_number +
                        '</td>';
                    tableData += '<td style="width: 30%; text-align: left;">' + availabilities[i].material_description +
                        '</td>';
                    tableData += '<td style="width: 10%; text-align: center;">' + availabilities[i].material_type + '</td>';
                    tableData += '<td style="width: 1%; text-align: right;">' + availabilities[i].policy + '</td>';
                    tableData += '<td style="width: 1%; text-align: right;">' + availabilities[i].stock + '</td>';

                    var percentage = 0;
                    if (availabilities[i].percentage != null) {
                        percentage = availabilities[i].percentage;
                    }

                    tableData += '<td style="width: 1%; text-align: right; font-weight: bold;">';
                    tableData += Math.round(percentage);
                    tableData += '%</td>';

                    tableData += '</tr>';
                }
            }
            $('#bodyDetail').append(tableData);

            $('#modalDetail').modal('show');

        }
    </script>
@endsection
