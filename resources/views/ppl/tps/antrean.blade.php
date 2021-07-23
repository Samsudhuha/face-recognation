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
                    <div class="row">
                    @php
                        $no = 0;
                    @endphp
                    @for($i = 0; $i < $jumlah; $i++)
                        @if(0 != count($bilik))
                        @if($i + 1 == $bilik[$no]->antrean)
                            <div class="col-12 col-sm-6 col-md-4 text-center">
                                <a href="/ppl/face-recognation/akhir/{{$bilik[$no]["nik"]}}">
                                    <div class="card bg-success">
                                        <div class="card-header  border-bottom-0">
                                            Bilik {{ $i+1}}
                                        </div>
                                        <div class="card-body">
                                            <i class="fas fa-home" style="font-size:100px"></i>
                                            <br>
                                            <p>{{ $bilik[$no]["nama"] }} - {{ $bilik[$no]["nik"] }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @php
                                $no += 1;
                            @endphp
                        @else
                            <div class="col-12 col-sm-6 col-md-4 text-center">
                                <div class="card bg-light">
                                    <div class="card-header  border-bottom-0">
                                        Bilik {{ $i+1}}
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-home" style="font-size:100px"></i>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @else
                            <div class="col-12 col-sm-6 col-md-4 text-center">
                                <div class="card bg-light">
                                    <div class="card-header  border-bottom-0">
                                        Bilik {{ $i+1}}
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-home" style="font-size:100px"></i>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                    </div>
                    <br>
                    <br>
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
                            @for($j = 0; $j < count($wait); $j++)
                                <tr>
                                    <td>{{ $j+1 }}</td>
                                    <td>{{ $wait[$j]["nama"] }}</td>
                                    <td>{{ $wait[$j]["nik"] }}</td>
                                    <td>{{ $wait[$j]["kk"] }}</td>
                                </tr>
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