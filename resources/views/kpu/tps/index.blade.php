@extends('layouts.home')

@section('title', 'TPS')

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
                        <li class="breadcrumb-item active">Daftar - TPS</li>
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
                    <form action="/kpu/tps" method="post">
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
                                            @if ($method == 'post')
                                                @foreach ($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}" @if ($kecamatan->id == $kecamatan_id) selected @endif>{{ $kecamatan->nama }}</option>
                                                @endforeach
                                            @else
                                                @foreach ($kecamatans as $kecamatan)
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
                                            @if ($method == 'post')
                                                @foreach ($kelurahans as $kelurahan)
                                                    <option value="{{ $kelurahan->id }}" @if ($kelurahan->id == $kelurahan_id) selected @endif>{{ $kelurahan->nama }}</option>
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
                @if ($method == 'post')
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">List TPS</h3>
                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>TPS</th>
                                        <th>Jumlah Bilik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $data['tps'] }}</td>
                                            <td>{{ $data['jumlah'] }}</td>
                                            <?php $no++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                <form action="/kpu/tps/store" method="post">
                                    {{ csrf_field() }}
                                    <input type="text" name="provinsi_id" value="{{ $provinsi_id }}" hidden>
                                    <input type="text" name="kota_kab_id" value="{{ $kota_kab_id }}" hidden>
                                    <input type="text" name="kecamatan_id" value="{{ $kecamatan_id }}" hidden>
                                    <input type="text" name="kelurahan_id" value="{{ $kelurahan_id }}" hidden>
                                    <button class="btn btn-success" type="submit"> Tambah TPS</button>
                                </form>
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
                            $('select[name="kelurahan_id"]').append(
                                '<option disabled selected>Pilih Kelurahan</option>');
                            jQuery.each(data, function(key, value) {
                                $('select[name="kelurahan_id"]').append(
                                    '<option value="' + value['id'] + '">' + value[
                                        'nama'] + '</option>');
                            });
                        },
                    });
                }
            });
        });

    </script>

    <script type="text/javascript">
        $("#sidebar-kpu-tps").addClass("active");

    </script>
@endsection
