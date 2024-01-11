@extends('layouts.master')
@section('stylesheets')
    <link href="{{ url('css/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ url('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/buttons.dataTables.min.css') }}">
    <style type="text/css">
        .table>tbody>tr:hover {
            background-color: #7dfa8c !important;
        }

        table.table-bordered {
            border: 1px solid black;
            vertical-align: middle;
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid black;
            color: white;
            vertical-align: middle;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid black;
            vertical-align: middle;
            padding: 2px 5px 2px 5px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .nmpd-grid {
            border: none;
            padding: 20px;
        }

        .nmpd-grid>tbody>tr>td {
            border: none;
        }

        #loading {
            display: none;
        }
    </style>
@endsection

@section('header')
    <section class="content-header">
        <div class="page-breadcrumb" style="padding: 7px">
            <div class="row align-items-center">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="page-title mb-0 p-0">{{ $title }}<span class="text-purple"> {{ $vendor }}</span>
                    </h3>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="content" style="font-size: 0.9vw;">
        <div id="loading"
            style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(0,191,255); z-index: 30001; opacity: 0.8; display: none">
            <p style="position: absolute; color: White; top: 45%; left: 45%;">
                <span style="font-size: 5vw;"><i class="fa fa-spin fa-circle-o-notch"></i></span>
            </p>
        </div>

        <div class="container-fluid" style="padding: 7px;">
            <div class="row">
                <div class="col-sm-12 col-xs-12" style="text-align: center; padding-left: 15px">
                    <div class="card">
                        <div class="card-body" style="padding: 10px;">
                            <div class="col-md-6" style="text-align: left; display: inline-block;">
                                <table class="table table-bordered table-hover">
                                    <thead style="background-color: #0b76b5;">
                                        <tr>
                                            <th style="width: 20%; text-align: center;">Material</th>
                                            <th style="width: 60%; text-align: center;">Material Description</th>
                                            <th style="width: 20%; text-align: center;">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($materials as $item)
                                            @if ($item->category == 'FINISH MATERIAL')
                                                <tr id="{{ 'row_' . $item->material_number }}">
                                                    <td style="text-align: center;">{{ $item->material_number }}</td>
                                                    <td style="text-align: left;">{{ $item->material_description }}</td>
                                                    <td style="text-align: center;">
                                                        <input style="text-align: right;" type="number"
                                                            class="form-control"
                                                            id="{{ 'value_' . $item->material_number }}"
                                                            placeholder="Input Qty" value="0" min="0">
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <center>
                                    <button class="btn btn-danger" onclick="clearAll()"
                                        style="width: 40%; font-weight: bold; margin-top: 10px;">Clear All</button>
                                    <button class="btn btn-success" onclick="calculateMrp()"
                                        style="width: 40%; font-weight: bold; margin-top: 10px;">Calculate</button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12" style="text-align: center; padding-left: 15px" id="mrp_panel">

                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ url('js/jquery.gritter.min.js') }}"></script>
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

        jQuery(document).ready(function() {
            $('#createDate').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true
            });
            $('#bulkDate').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true
            });
            $('.select2').select2({
                allowClear: true
            });
        });

        var audio_error = new Audio('{{ url('sounds/error.mp3') }}');
        var audio_ok = new Audio('{{ url('sounds/sukses.mp3') }}');

        var vendor_nickname = "{{ $vendor_nickname }}";
        var results = [];
        var result_count = 0;

        var materials = <?php echo json_encode($materials); ?>;
        var stocks = <?php echo json_encode($stocks); ?>;
        var boms = <?php echo json_encode($boms); ?>;

        function clearAll() {
            location.reload();
        }

        function resumeMrp(mrp) {

            var result = [];
            var temp = [];
            for (var i = 0; i < mrp.length; i++) {
                var key = mrp[i].child_number;

                if (!temp[key]) {
                    temp[key] = {
                        'child_number': mrp[i].child_number,
                        'child_description': mrp[i].child_description,
                        'child_category': mrp[i].child_category,
                        'concat': mrp[i].child_category + '_' + mrp[i].child_number,
                        'need': mrp[i].need
                    };
                } else {
                    temp[key].need += mrp[i].need;
                }
            }


            for (var key in temp) {
                result.push(temp[key]);
            }

            return result;
        }


        function calculateMrp() {

            $('#mrp_panel').html('');

            var plans = [];
            for (let i = 0; i < materials.length; i++) {
                if (materials[i].category == 'FINISH MATERIAL') {
                    if (parseInt($('#value_' + materials[i].material_number).val()) > 0) {
                        plans.push({
                            'material_number': materials[i].material_number,
                            'material_description': materials[i].material_description,
                            'quantity': parseInt($('#value_' + materials[i].material_number).val())
                        });
                    }
                }
            }

            var mrp = [];
            for (let h = 0; h < plans.length; h++) {
                for (let i = 0; i < boms.length; i++) {
                    if (boms[i].ympi_material_number == plans[h].material_number) {
                        mrp.push({
                            'material_number': plans[h].material_number,
                            'material_description': plans[h].material_description,
                            'quantity': plans[h].quantity,
                            'child_number': boms[i].vendor_material_number,
                            'child_description': boms[i].vendor_material_description,
                            'child_category': boms[i].category,
                            'usage': boms[i].usage,
                            'need': plans[h].quantity * boms[i].usage,
                        });
                    }
                }
            }

            var mrp_resume = resumeMrp(mrp);

            mrp_resume.sort(function(a, b) {
                if (a.concat < b.concat) {
                    return -1;
                }
                if (a.concat > b.concat) {
                    return 1;
                }
                return 0;
            });

            var body = '';
            body += '<div class="card">';
            body += '<div class="card-body" style="padding: 10px;">';
            body += '<div class="col-md-10" style="text-align: left; display: inline-block;">';
            body += '<table id="tableResult" class="table table-bordered table-hover">';
            body += '<thead style="background-color: #0b76b5;">';
            body += '<tr>';
            body += '<th style="width: 15%; text-align: center;">Category</th>';
            body += '<th style="width: 15%; text-align: center;">Material</th>';
            body += '<th style="width: 40%; text-align: center;">Material Description</th>';
            body += '<th style="width: 10%; text-align: center;">Stock</th>';
            body += '<th style="width: 10%; text-align: center;">Usage</th>';
            body += '<th style="width: 10%; text-align: center;">Need</th>';
            body += '</tr>';
            body += '</thead>';
            body += '<tbody id="tableResultBody">';
            for (let i = 0; i < mrp_resume.length; i++) {

                var stock = 0;
                for (let j = 0; j < stocks.length; j++) {
                    if (mrp_resume[i].child_number == stocks[j].material_number) {
                        stock = stocks[j].stock;
                    }
                }

                body += '<tr>';
                body += '<td style="text-align: center;">';
                body += mrp_resume[i].child_category + '</td>';
                body += '<td style="text-align: center;">';
                body += mrp_resume[i].child_number + '</td>';
                body += '<td style="text-align: left;">';
                body += mrp_resume[i].child_description + '</td>';
                body += '<td style="text-align: right;">';
                body += stock.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }) + '</td>';
                body += '<td style="text-align: right;">';
                body += mrp_resume[i].need.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }) + '</td>';
                var diff = stock - mrp_resume[i].need;
                if (diff < 0) {
                    body += '<td style="text-align: right; background-color: #ffccff;">';
                    body += diff.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }) + '</td>';
                } else {
                    diff = 0;
                    body += '<td style="text-align: right;">';
                    body += diff.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }) + '</td>';
                }

                body += '</tr>';




            }
            body += ' </tbody>';
            body += '<tfoot style="background-color: #0b76b5;">';
            body += '<tr>';
            body += '<th></th>';
            body += '<th></th>';
            body += '<th></th>';
            body += '<th></th>';
            body += '<th></th>';
            body += '<th></th>';
            body += '</tr>';
            body += '</tfoot>';
            body += '</table>';

            body += '</div>';
            body += '</div>';
            body += ' </div>';

            $('#mrp_panel').html(body);

            $('#tableResult tfoot th').each(function() {
                var title = $(this).text();
                $(this).html(
                    '<input style="width: 80%; text-align: center;" type="text" placeholder="Search ' +
                    title +
                    '"/>');
            });

            var table = $('#tableResult').DataTable({
                'dom': 'Bfrtip',
                'responsive': true,
                'lengthMenu': [
                    [-1],
                    ['Show all']
                ],
                'buttons': {
                    buttons: [{
                            extend: 'pageLength',
                            className: 'btn btn-default',
                        },
                        {
                            extend: 'copy',
                            className: 'btn btn-success',
                            text: '<i class="fa fa-copy"></i> Copy',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-info',
                            text: '<i class="fa fa-file-excel-o"></i> Excel',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-warning',
                            text: '<i class="fa fa-print"></i> Print',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        }
                    ]
                },
                'paging': true,
                'lengthChange': true,
                'pageLength': 10,
                'searching': true,
                'ordering': true,
                'order': [],
                'info': true,
                'autoWidth': true,
                'sPaginationType': 'full_numbers',
                'bJQueryUI': true,
                'bAutoWidth': false,
                'processing': true,
                'columnDefs': [{
                    "targets": 2,
                    "className": "text-left",
                }],
                initComplete: function() {
                    this.api()
                        .columns([0, 1])
                        .every(function(dd) {
                            var column = this;
                            var theadname = $("#tableResult th").eq([dd]).text();
                            var select = $(
                                    '<select><option value="" style="font-size:11px;">All</option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this)
                                        .val());

                                    column.search(val ? '^' + val + '$' : '', true,
                                            false)
                                        .draw();
                                });
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    var vals = d;
                                    if ($("#tableResult th").eq([dd]).text() ==
                                        'Category') {
                                        vals = d.split(' ')[0];
                                    }
                                    select.append(
                                        '<option style="font-size:11px;" value="' +
                                        d + '">' + vals + '</option>');
                                });
                        });
                },
            });

            table.columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });

            $('#tableResult tfoot tr').appendTo('#tableResult thead');


        }

        function openSuccessGritter(title, message) {
            jQuery.gritter.add({
                title: title,
                text: message,
                class_name: 'growl-success',
                image: '{{ url('images/image-screen.png') }}',
                sticky: false,
                time: '3000'
            });
        }

        function openErrorGritter(title, message) {
            jQuery.gritter.add({
                title: title,
                text: message,
                class_name: 'growl-danger',
                image: '{{ url('images/image-stop.png') }}',
                sticky: false,
                time: '3000'
            });
        }
    </script>
@endsection
