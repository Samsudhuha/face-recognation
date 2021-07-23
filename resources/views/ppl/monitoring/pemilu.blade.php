@extends('layouts.home')

@section('title','Penduduk')

@section('navbar')
@include('layouts.navbar')
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('custom-css')

@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Beranda</a></li>
                    <li class="breadcrumb-item active">Monitoing TPS - {{ substr(Auth::user()->username, 13, 2) }} </li>
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
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Monitoring TPS - {{ substr(Auth::user()->username, 13, 2) }} </h3>
                </div>
                <div class="card-body">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3 text-center">
                                <a href="#">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Total Penduduk
                                        </div>
                                        <div class="card-body">
                                            <h4>{{$total}}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 text-center">
                                <a href="#">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Sudah Memilih
                                        </div>
                                        <div class="card-body">
                                            <h4>{{$sudah}}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 text-center">
                                <a href="#">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Sedang Memilih
                                        </div>
                                        <div class="card-body">
                                            <h4>{{$sedang}}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 text-center">
                                <a href="#">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Belum Memilih
                                        </div>
                                        <div class="card-body">
                                            <h4>{{$belum}}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 text-center">
                                <a href="#">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Tidak Mendaftar
                                        </div>
                                        <div class="card-body">
                                            <h4>{{$tidak}}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('custom-js')

<script type="text/javascript">
    $("#sidebar-ppl-monitoring-pemilu").addClass("active");
</script>
@endsection