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
                    <h3 class="card-title">List Penduduk TPS - {{ substr(Auth::user()->username, 13, 2) }} </h3>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>KK</th>
                                <th>Status</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1
                            @endphp
                            @foreach($datas as $data)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $data["nama"] }}</td>
                                <td>{{ $data["nik"] }}</td>
                                <td>{{ $data["kk"] }}</td>
                                @if($data["status"] == 0)
                                    <td style="background-color: red">
                                        Belum Memilih
                                    </td>
                                @elseif($data["status"] == 1)
                                    <td style="background-color: yellow">
                                        Sedang Memilih
                                    </td>
                                @elseif($data["status"] == 2)
                                    <td style="background-color: greenyellow">
                                        Sudah Memilih
                                    </td>
                                @endif
                                <td>
                                    @if (Storage::disk('public')->exists($data["nik"] . 'jpg')) 
                                        <img src="{{ url($data['nik']) }}" alt="your image" style="height: 200px; width:200px" />
                                    @else
                                        <img src="{{ url('img/default.png') }}" alt="your image" style="height: 200px; width:200px" />
                                    @endif
                                </td>
                            <?php $no++ ?>
                            @endforeach
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
    $("#sidebar-ppl-penduduk").addClass("active");
</script>
@endsection