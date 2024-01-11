<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('images/bridgesmall.png') }}" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, user-scalable=yes, initial-scale=1.0" name="viewport">
    <title>Bridge For Vendor</title>
    <link rel="stylesheet" href="{{ url('css/bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/dashboard/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet"
        href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('bower_components/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    @yield('stylesheets')
    <style>
        aside {
            font-size: 12px;
        }

        .text-red {
            color: red;
        }

        .crop {
            overflow: hidden;
        }

        .crop img {
            margin: -10% 0 -10% 0;
        }

        .sidebar-menu>li>a {
            padding: 7px 5px 7px 15px;
            display: block;
        }

        .treeview-menu>li>a {
            padding: 3px 5px 3px 15px;
            display: block;
            font-size: 12px;
        }

        @media (min-width:576px) {
            #logo-bridge {
                height: 8px;
                /*content:url("{{ url('images/bridgesmall.png') }}");*/
            }

            #logo-icon {
                padding-left: 0px !important;
            }
        }

        @media (min-width:767px) {
            #logo-bridge {
                height: 8px !important;
                /*content:url("{{ url('images/bridgesmall.png') }}");*/
            }

            #logo-icon {
                padding-left: 0px !important;
            }
        }

        @media (min-width:768px) {
            #logo-bridge {
                height: 8px !important;
                /*content:url("{{ url('images/bridgesmall.png') }}");*/
            }

            #logo-icon {
                padding-left: 0px !important;
            }
        }

        @media (min-width:1200px) {
            #logo-bridge {
                height: 30px !important;
                /*content:url("{{ url('images/bridge.png') }}");*/
            }

            #logo-icon {
                padding-left: 10px !important;
            }
        }
    </style>
</head>

<body class="hold-transition skin-purple sidebar-mini">
    <div id="main-wrapper">
        @include('layouts.header')
        <div class="page-wrapper">
            @yield('header')
            @yield('content')
            @include('layouts.footer')
        </div>
    </div>
    <script src="{{ url('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('js/waves.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/dashboard1.js') }}"></script>
    <script src="{{ url('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript"></script>
    @yield('scripts')
</body>

</html>
