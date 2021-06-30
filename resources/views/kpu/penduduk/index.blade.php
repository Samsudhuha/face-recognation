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
                    <li class="breadcrumb-item active">Daftar - Penduduk</li>
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
                    <h3 class="card-title">Data Penduduk</h3>
                </div>
                <form action="/kpu/penduduk" method="post">
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
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>KK</th>
                                <th>AKSI</th>
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
                                <td>
                                    <button type="button" class="btn btn-danger mt-1" data-toggle="modal" data-target="#modal-default{{$no}}">Hapus</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-default{{$no}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <center>
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Menghapus Data Penduduk</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            <?php $no++ ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-success mt-1" data-toggle="modal" data-target="#modal-default">Tambah Data Penduduk</button>
                        <!-- Modal -->
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Menambah Data Penduduk</h4>
                                        <a href="/kpu/penduduk/export" class="btn btn-secondary" style="margin-left: 10px">Export Tamplate Excel</a>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/kpu/penduduk/store" method="post">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <input type="text" name="provinsi_id" value="{{$provinsi_id}}" hidden>
                                            <input type="text" name="kota_kab_id" value="{{$kota_kab_id}}" hidden>
                                            <input type="text" name="kecamatan_id" value="{{$kecamatan_id}}" hidden>
                                            <input type="text" name="kelurahan_id" value="{{$kelurahan_id}}" hidden>
                                            <input type="text" name="tps_id" value="{{$tps_id}}" hidden>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required autofocus>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>NIK</label>
                                                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>KK</label>
                                                        <input type="text" name="kk" class="form-control" value="{{ old('kk') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <div>
                                                <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
                                                    IMPORT EXCEL
                                                </button>
                                                <button class="btn btn-success" type="submit"> Tambah Data Penduduk</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Import Excel -->
            <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="/kpu/penduduk/import" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                            </div>
                            <div class="modal-body">
                                {{ csrf_field() }}
                                <input type="text" name="provinsi_id" value="{{$provinsi_id}}" hidden>
                                <input type="text" name="kota_kab_id" value="{{$kota_kab_id}}" hidden>
                                <input type="text" name="kecamatan_id" value="{{$kecamatan_id}}" hidden>
                                <input type="text" name="kelurahan_id" value="{{$kelurahan_id}}" hidden>
                                <input type="text" name="tps_id" value="{{$tps_id}}" hidden>
                                <label>Pilih file excel</label>
                                <div class="form-group">
                                    <input type="file" name="file" required="required" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
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
    $("#sidebar-kpu-penduduk").addClass("active");
</script>
@endsection