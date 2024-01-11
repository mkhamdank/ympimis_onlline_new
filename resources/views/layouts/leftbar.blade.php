<aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                @foreach (Auth::user()->role->permissions as $perm)
                    @php
                        $navs[] = $perm->navigation_code;
                    @endphp
                @endforeach

                @if (in_array('Dashboard', $navs))
                    @if (isset($page) && $page == 'Dashboard')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/home') }}"><i
                            class="fa fa-industry"></i> <span class="hide-menu">Dashboard</span></a>
                    </li>
                @endif


                @if (in_array('A3', $navs))
                    @if (isset($page) && $page == 'Navigation')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/navigation') }}"><i class="fa fa-arrows"></i> <span
                            class="hide-menu">Navigation</span></a>
                    </li>
                @endif

                @if (in_array('A4', $navs))
                    @if (isset($page) && $page == 'Role')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/index/role') }}"><i
                            class="fa fa-cogs"></i> <span class="hide-menu">Role</span></a>
                    </li>
                @endif


                @if (in_array('A6', $navs))
                    @if (isset($page) && $page == 'User')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/index/user') }}"><i
                            class="fa fa-users"></i> <span class="hide-menu">User</span></a>
                    </li>
                @endif

                {{-- @if (in_array('S1', $navs))
                    @if (isset($page) && $page == 'Invoice Data')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/index/invoice') }}"><i
                            class="fa fa-book"></i> <span class="hide-menu">Invoice Data</span></a>
                    </li>

                    @if (isset($page) && $page == 'Upload Invoice')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/upload_invoice') }}"><i class="fa fa-upload"></i> <span
                            class="hide-menu">Upload Invoice</span></a>
                    </li>
                @endif


                @if (in_array('S2', $navs))
                    @if (isset($page) && $page == 'Purchasing')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/purchasing') }}"><i class="fa fa-book"></i> <span
                            class="hide-menu">Purchasing Menu</span></a>
                    </li>
                @endif

                @if (in_array('S3', $navs))
                    @if (isset($page) && $page == 'Accounting')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/accounting') }}"><i class="fa fa-book"></i> <span
                            class="hide-menu">Accounting Menu</span></a>
                    </li>
                @endif

                @if (in_array('S4', $navs))
                    @if (isset($page) && $page == 'Warehouse')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/index/warehouse') }}"><i
                            class="fa fa-book"></i> <span class="hide-menu">Warehouse Menu</span></a>
                    </li>
                @endif --}}

                @if (in_array('S5', $navs))

                    @if (Auth::user()->role_code == 'RK' || Auth::user()->role_code == 'MIS')
                        @if (isset($page) && $page == 'Stock Control Dashboard')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/stock_control/dashboard') }}"><i class="fa fa-tv"></i>
                            <span class="hide-menu">Dashboard</span></a>
                        </li>

                        @if (isset($page) && $page == 'RK Stock Control')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/stock_control/rk') }}"><i class="fa fa-cubes"></i>
                            <span class="hide-menu">Rahayu Kusuma</span></a>
                        </li>
                    @endif

                    @if (Auth::user()->role_code == 'TRUE' || Auth::user()->role_code == 'MIS')
                        @if (isset($page) && $page == 'TRUE Stock Control')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/stock_control/true') }}"><i class="fa fa-cubes"></i>
                            <span class="hide-menu">PT TRUE</span></a>
                        </li>
                    @endif
                @endif

                @if (in_array('S0', $navs))
                    @if (Auth::user()->role_code == 'MIS' || Auth::user()->role_code == 'E - Purchasing')
                        @if (isset($page) && $page == 'Outgoing True')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/outgoing/true') }}"><i class="fa fa-book"></i> <span
                                class="hide-menu">Vendor Final Inspection</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->role_code == 'TRUE' || Auth::user()->role_code == 'MIS')
                        @if (isset($page) && $page == 'Outgoing True')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/outgoing/true') }}"><i class="fa fa-book"></i> <span
                                class="hide-menu">VFI PT. TRUE</span></a>
                        </li>
                    @endif

                    @if (Auth::user()->role_code == 'KBI' || Auth::user()->role_code == 'MIS')
                        @if (isset($page) && $page == 'Outgoing KBI')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/outgoing/kbi') }}"><i class="fa fa-book"></i> <span
                                class="hide-menu">VFI KBI</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->role_code == 'ARISA' || Auth::user()->role_code == 'MIS')
                        @if (isset($page) && $page == 'Outgoing ARISA')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/outgoing/arisa') }}"><i class="fa fa-book"></i> <span
                                class="hide-menu">VFI ARISA</span></a>
                        </li>
                    @endif
                    @if (Auth::user()->role_code == 'CRESTEC' || Auth::user()->role_code == 'MIS')
                        @if (isset($page) && $page == 'Outgoing Crestec')
                            <li class="sidebar-item active">
                            @else
                            <li class="sidebar-item">
                        @endif
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('/index/outgoing/crestec') }}"><i class="fa fa-book"></i> <span
                                class="hide-menu">VFI PT. CRESTEC INDONESIA</span></a>
                        </li>
                    @endif
                @endif
                @if (Auth::user()->role_code == 'LTI' || Auth::user()->role_code == 'MIS')
                    @if (isset($page) && $page == 'Outgoing LTI')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/outgoing/lti') }}"><i class="fa fa-book"></i> <span class="hide-menu">VFI
                            PT. LTI</span></a>
                    </li>
                @endif

                @if (Auth::user()->role_code == 'CPP' || Auth::user()->role_code == 'MIS')
                    @if (isset($page) && $page == 'Outgoing CPP')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/outgoing/cpp') }}"><i class="fa fa-book"></i> <span class="hide-menu">VFI
                            PT. CPP</span></a>
                    </li>
                @endif

                @if (Auth::user()->role_code == 'PE Molding' || Auth::user()->role_code == 'MIS')
                    @if (isset($page) && $page == 'Molding Audit')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/workshop/check_molding_vendor') }}"><i class="fa fa-cubes"></i> <span class="hide-menu"> Molding ARISA</span></a>
                    </li>
                @endif


                @if (Auth::user()->role_code == 'FA-Check1' ||
                    Auth::user()->role_code == 'FA-Check2' ||
                    Auth::user()->role_code == 'MIS')
                    @if (isset($page) && $page == 'Fixed Asset')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/index/fixed_asset') }}"><i class="fa fa-cubes"></i> <span
                            class="hide-menu">Fixed Asset</span></a>
                    </li>
                @endif

                @if (Auth::user()->role_code == 'E - Logistic' || Auth::user()->role_code == 'MIS')
                    @if (isset($page) && $page == 'Delivery Order')
                        <li class="sidebar-item active">
                        @else
                        <li class="sidebar-item">
                    @endif
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('index/delivery_order_bc') }}">
                        <i class="fa fa-truck"></i>
                        <span class="hide-menu"> Surat Jalan</span>
                    </a>
                    </li>
                @endif


            </ul>

        </nav>
    </div>
</aside>
