<aside class="main-sidebar sidebar-dark-olive elevation-4">
    <a class="brand-link">
        <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            {{ substr(Auth::user()->username, 0, 3) }}
        </span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            @if (Auth::user()->role == '01')
                                {{ Auth::user()->username }}
                            @else
                                {{ Auth::user()->kota_kab }}
                                <br>
                                {{ Auth::user()->kecamatan }}
                                <br>
                                {{ Auth::user()->kelurahan }}
                                <br>
                                TPS - {{ substr(Auth::user()->username, 13, 2) }}
                            @endif
                        </p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Dashboard</li>
                <li class="nav-item">
                    <a href="/home" class="nav-link" id='sidebar-home'>
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                @switch(Auth::user()->role)
                    @case('01')
                        <li class="nav-header">Data</li>
                        <li class="nav-item">
                            <a href="/kpu/tps" class="nav-link" id='sidebar-kpu-tps'>
                                <i class="fas fa-home"></i>
                                <p>TPS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/kpu/penduduk" class="nav-link" id='sidebar-kpu-penduduk'>
                                <i class="fas fa-users"></i>
                                <p>Penduduk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/kpu/monitoring/pemilu" class="nav-link" id='sidebar-kpu-monitoring-pemilu'>
                                <i class="fas fa-chart-bar"></i>
                                <p>Monitoring Pemilu</p>
                            </a>
                        </li>
                    @break
                    @case('02')
                        <li class="nav-header">Face Recognation</li>
                        <li class="nav-item">
                            <a href="/ppl/face-recognation" class="nav-link" id='sidebar-ppl-face-recognation'>
                                <i class="fas fa-camera"></i>
                                <p>Photo</p>
                            </a>
                        </li>
                        <li class="nav-header">Data</li>
                        <li class="nav-item">
                            <a href="/ppl/penduduk" class="nav-link" id='sidebar-ppl-penduduk'>
                                <i class="fas fa-user"></i>
                                <p>Penduduk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/ppl/monitoring/pemilu" class="nav-link" id='sidebar-ppl-monitoring-pemilu'>
                                <i class="fas fa-chart-bar"></i>
                                <p>Monitoring Pemilu</p>
                            </a>
                        </li>
                        <li class="nav-header">Manajemen</li>
                        <li class="nav-item">
                            <a href="/ppl/tps" class="nav-link" id='sidebar-ppl-tps'>
                                <i class="fas fa-home"></i>
                                <p>TPS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/ppl/antrean" class="nav-link" id='sidebar-ppl-antrean'>
                                <i class="fas fa-hourglass-half"></i>
                                <p> Antrean</p>
                            </a>
                        </li>
                    @break
                @endswitch
                <!-- <li class="nav-header">Dropdown</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Contoh Dropdown
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" id='sidebar-dropdown-1'>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id='sidebar-dropdown-2'>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id='sidebar-dropdown-3'>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id='sidebar-contoh'>
                        <i class="nav-icon fas fa-th"></i>
                        <p>Contoh Sidebar<span class="right badge badge-danger">New</span></p>
                    </a>
                </li>
                <li class="nav-header">Test</li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id='sidebar-test'>
                        <i class="nav-icon fas fa-ellipsis-h"></i>
                        <p>Test</p>
                    </a>
                </li> -->
            </ul>
        </nav>
    </div>
</aside>
