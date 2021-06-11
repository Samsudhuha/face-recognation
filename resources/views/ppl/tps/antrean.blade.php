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
                    <li class="breadcrumb-item active">Daftar - Penduduk TPS - {{ substr(Auth::user()->username, 13, 2) }} </li>
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
                    <h3 class="card-title">List Antrean TPS - {{ substr(Auth::user()->username, 13, 2) }} </h3>
                </div>
                <div class="card-body">
                    Sedang Di BILIK
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>KK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < count($datas); $i++)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $datas[$i]["nama"] }}</td>
                                    <td>{{ $datas[$i]["nik"] }}</td>
                                    <td>{{ $datas[$i]["kk"] }}</td>
                                </tr>
                                @if($i + 1 == $jumlah)
                                    @php
                                        $j = $i + 1;
                                    @endphp
                                    @break
                                @endif
                            @endfor
                        </tbody>
                    </table>
                    Menunggu
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>KK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @for($j; $j < count($datas); $j++)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $datas[$j]["nama"] }}</td>
                                    <td>{{ $datas[$j]["nik"] }}</td>
                                    <td>{{ $datas[$j]["kk"] }}</td>
                                </tr>
                                @php
                                    $no += 1;
                                @endphp
                            @endfor
                        </tbody>
                    </table>
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
    $("#sidebar-ppl-antrean").addClass("active");
</script>
@endsection