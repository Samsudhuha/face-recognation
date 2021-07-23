@extends('layouts.home')

@section('title','TPS')

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
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item active">Aksi</li>
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
                    <h3 class="card-title">Pengaturan TPS</h3>
                </div>
                <form action="/kpu/setting/aksi" method="post">
                    {{ csrf_field() }}
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="header">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                            <h5>Aksi TPS</h5>
                                        </div>
                                        <div class="old">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h5>: 
                                                    @if (Auth::user()->role == '01')
                                                        Pencoblosan Pemilihan Umum
                                                    @else
                                                        Pendaftaran Pemilihan Umum
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="new">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h5>:                                     
                                                    <select name="aksi" class="form-control-lg select2" style="width: 100%;">
                                                        <option value="pencoblosan" @if (Auth::user()->role == '01') selected @endif>Pencoblosan Pemilihan Umum</option>
                                                        <option value="pendaftaran" @if (Auth::user()->role == '00') selected @endif>Pendaftaran Pemilihan Umum</option>
                                                    </select> 
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div>
                            <button type="button" class="btn btn-warning mb-2" id="edit">Edit</button>
                            <div id="batalEdit">
                                <button type="button" class="btn btn-warning">Batal</button>
                                <button class="btn btn-success" type="submit"> Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@section('custom-js')

<script type="text/javascript">

    $(document).ready(function() {
        $(".new").hide();
        $("#formEdit").hide();
        $("#batalEdit").hide();
    });

    $(document).on('click', '#edit', function(e) {
        $(".new").show();
        $(".old").hide();
        $("#formEdit").show();
        $("#batalEdit").show();
        $("#edit").hide();
    });

    $(document).on('click', '#batalEdit', function(e) {
        $(".new").hide();
        $(".old").show();
        $("#formEdit").hide();
        $("#batalEdit").hide();
        $("#edit").show();
    });

    $("#sidebar-ppl-tps").addClass("active");
</script>
@endsection