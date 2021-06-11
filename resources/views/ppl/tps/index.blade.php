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
                    <li class="breadcrumb-item active">TPS - {{ substr(Auth::user()->username, 13, 2) }} </li>
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
                    <h3 class="card-title">Data TPS</h3>
                </div>
                <form action="/ppl/tps/update" method="post">
                    {{ csrf_field() }}
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="header">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <h5>TPS</h5>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <h5>: {{ $data->tps }} </h5>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                            <h5>Jumlah Bilik</h5>
                                        </div>
                                        <div class="new">
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <input type="text" name="id" class="form-control" hidden value="{{$data->id}}" />
                                                <input type="text" name="jumlah" class="form-control" value="{{$data->jumlah}}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                            <div class="old">
                                                <h5>: {{ $data->jumlah }} </h5>
                                            </div>
                                        </div>
                                    </div>
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
                                <button type="button" class="btn btn-warning">Batal Edit Logo</button>
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