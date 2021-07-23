@extends('layouts.home')

@section('title','Monitoring')

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
                    <li class="breadcrumb-item active">Daftar - Monitoring Pemilu</li>
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
                    <h3 class="card-title">Data Monitoring Pemilu</h3>
                </div>
                <form action="/kpu/monitoring/pemilu" method="post">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kota / Kabupaten</label>
                                    <select name="kota_kab_id" class="form-control-lg select2" style="width: 100%;">
                                        <option value="{{ $kota->id }}">{{ $kota->nama }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select name="kecamatan_id" class="form-control-lg select2" style="width: 100%;">
                                        <option disabled selected>Pilih Kecamatan</option>
                                        @if($method == 'post')
                                            @foreach($kecamatans as $kecamatan)
                                                <option value="{{ $kecamatan->id }}" @if($kecamatan->id == $kecamatan_id) selected @endif>{{ $kecamatan->nama }}</option>
                                            @endforeach
                                        @else
                                            @foreach($kecamatans as $kecamatan)
                                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kelurahan</label>
                                    <select name="kelurahan_id" class="form-control-lg select2" style="width: 100%;">
                                        <option disabled selected>Pilih Kelurahan</option>
                                        @if($method == 'post')
                                            @foreach($kelurahans as $kelurahan)
                                                <option value="{{ $kelurahan->id }}" @if($kelurahan->id == $kelurahan_id) selected @endif>{{ $kelurahan->nama }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>TPS</label>
                                    <select name="tps_id" class="form-control-lg select2" style="width: 100%;">
                                        <option disabled selected>Pilih TPS</option>
                                        @if($method == 'post')
                                            @foreach($tpss as $tps)
                                                <option value="{{ $tps->id }}" @if($tps->id == $tps_id) selected @endif>{{ $tps->tps }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button class="btn btn-success" type="submit"> Lihat</button>
                        </div>
                    </div>
                </form>
            </div>
            @if($method == 'post')
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">List Penduduk</h3>
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
            </div>
            @endif
        </div>
    </section>
</div>

@endsection

@section('custom-js')
<!-- Get List Dropdown -->
<script type="text/javascript">
    // Kelurahan
    jQuery(document).ready(function() {
        jQuery('select[name="kecamatan_id"]').on('change', function() {
            var kecamatanID = jQuery(this).val();
            if (kecamatanID) {
                jQuery.ajax({
                    url: '/dropdownlist/getkelurahan/' + kecamatanID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="kelurahan_id"]').empty();
                        $('select[name="kelurahan_id"]').append('<option disabled selected>Pilih Kelurahan</option>');
                        jQuery.each(data, function(key, value) {
                            $('select[name="kelurahan_id"]').append('<option value="' + value['id'] + '">' + value['nama'] + '</option>');
                        });
                    },
                });
            }
        });
    });

    // Tps
    jQuery(document).ready(function() {
        jQuery('select[name="kelurahan_id"]').on('change', function() {
            var kotaKabID = jQuery('select[name="kota_kab_id"]').val();
            var kecamatanID = jQuery('select[name="kecamatan_id"]').val();
            var kelurahanID = jQuery(this).val();
            if (kelurahanID && kotaKabID && kecamatanID) {
                jQuery.ajax({
                    url: '/dropdownlist/gettps/' + kotaKabID + '/' + kecamatanID + '/' + kelurahanID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="tps_id"]').empty();
                        $('select[name="tps_id"]').append('<option disabled selected>Pilih TPS</option>');
                        jQuery.each(data, function(key, value) {
                            $('select[name="tps_id"]').append('<option value="' + value['id'] + '">' + value['tps'] + '</option>');
                        });
                    },
                });
            }
        });
    });
</script>

<script type="text/javascript">
    $("#sidebar-kpu-monitoring-pemilu").addClass("active");
</script>
@endsection