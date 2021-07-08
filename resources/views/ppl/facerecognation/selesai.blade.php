@extends('layouts.home')

@section('title', 'Dashboard')

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
            <div class="card-body pb-0">
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Face Recognation</h3>
                            </div>
                            <div class="card-body p-0">
                                <center>
                                    <div id="my_camera"></div>
                                    <br>
                                    <input type=button value="Take Snapshot" onClick="take_snapshot()"
                                        class="snapshot">
                                    <br>
                                    <br>
                                    <br>
                                </center>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div id="results1" class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                </div>
                                <br>
                                <br>
                                <form action="/ppl/face-recognation/akhir" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="form-group col-md-4">
                                            <textarea id="file1" name="file1" hidden></textarea>
                                            <textarea id="file2" name="file2" hidden></textarea>
                                            <textarea id="file3" name="file3" hidden></textarea>
                                            <textarea id="file4" name="file4" hidden></textarea>
                                            <textarea id="file5" name="file5" hidden></textarea>
                                            <input type="text" name="nik" value="{{$id}}" hidden required>
                                        </div>
                                    </div>
                                    <center>

                                        <div>
                                            <a href="/ppl/antrean" class="btn btn-secondary">Kembali</a>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </center>
                                    <br>
                                    <br>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.container-fluid -->
    </div>

@endsection

@section('custom-js')

    <script src="{{ url('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/webcam.min.js') }}"></script>

    <!-- Configure a few settings and attach camera -->
    <script language="JavaScript">
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');

    </script>
    <!-- Code to handle taking the snapshot and displaying it locally -->
    <script language="JavaScript">
        let index = 0;

        function myFunc(variable, data) {
            var s = document.getElementById(variable);
            s.value = data;
        }

        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap(function(data_uri) {
                // display results in page
                if (index == 5) {
                    return;
                }
                if (index == 1) {
                document.getElementById('results' + index).innerHTML =
                    '<img src="' + data_uri + '"/>';
                }
                index += 1;
                    
                myFunc("file" + index, data_uri);
                take_snapshot();
            });
        }

    </script>
    <script type="text/javascript">
        $("#sidebar-ppl-antrean").addClass("active");
    </script>

@endsection
