@extends('layouts.home')

@section('title','Dashboard')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('custom-css')

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- /.card -->
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Beranda</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (count($errors))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
            @endif

        </div>
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    @switch(Auth::user()->role)
                    @case('02')
                        <div class="col-12 col-sm-6 col-md-4 text-center">
                            <a href="/ppl/face-recognation">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">
                                        Face Recognation
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-camera" style="font-size:100px"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 text-center">
                            <a href="/ppl/penduduk">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">
                                        Data penduduk
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-users" style="font-size:100px"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 text-center">
                            <a href="/ppl/monitoring/pemilu">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">
                                        Data Monitoring Pemilu
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-chart-bar" style="font-size:100px"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 text-center">
                            <a href="/ppl/tps">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">
                                        Manajemen TPS
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-home" style="font-size:100px"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 text-center">
                            <a href="/ppl/antrean">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">
                                        Manajemen Antrean
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-hourglass-half" style="font-size:100px"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @break
                    @case('03')
                        <div class="col-12 col-sm-6 col-md-4 text-center">
                            <a href="/ppl/face-recognation/daftar">
                                <div class="card bg-light">
                                    <div class="card-header text-muted border-bottom-0">
                                        Face Recognation
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-camera" style="font-size:100px"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @break
                    @endswitch
                </div>
            </div>
        </div>
    </section>
    <!-- /.container-fluid -->
</div>

@endsection

@section('custom-js')

<script src="{{url('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{url('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<script type="text/javascript">
    $("#sidebar-home").addClass("active");
</script>

@endsection