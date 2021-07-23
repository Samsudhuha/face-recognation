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
                                <div class="bs-stepper">
                                    <div class="bs-stepper-header" role="tablist">
                                        <div class="col-md-4"></div>
                                        <!-- your steps here -->
                                        <div class="step" data-target="#logins-part">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="logins-part" id="logins-part-trigger">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Photo</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#information-part">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="information-part" id="information-part-trigger">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Input Data</span>
                                            </button>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->
                                        <div id="logins-part" class="content" role="tabpanel"
                                            aria-labelledby="logins-part-trigger">
                                            <center>
                                                <div id="my_camera"></div>
                                                <br>
                                                <input type=button value="Photo" onClick="take_snapshot(1)"
                                                    class="snapshot">
                                                <br>
                                                <br>
                                                <br>
                                            </center>
                                            <div class="row">
                                                <div id="results0" class="col-md-4"></div>
                                                <div id="results1" class="col-md-4"></div>
                                                <div id="results2" class="col-md-4"></div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div id="results3" class="col-md-4"></div>
                                                <div id="results4" class="col-md-4"></div>
                                                <div class="col-md-2"></div>
                                            </div>
                                            <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                                        </div>
                                        <div id="information-part" class="content" role="tabpanel"
                                            aria-labelledby="information-part-trigger">
                                            <form action="/ppl/face-recognation/daftar" method="POST"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    <div class="form-group col-md-4">
                                                        <textarea id="file1" name="file1" hidden></textarea>
                                                        <textarea id="file2" name="file2" hidden></textarea>
                                                        <textarea id="file3" name="file3" hidden></textarea>
                                                        <textarea id="file4" name="file4" hidden></textarea>
                                                        <textarea id="file5" name="file5" hidden></textarea>
                                                        <label for="exampleInputPassword1">NIK</label>
                                                        <input type="text" class="form-control" id="exampleInputPassword1"
                                                            name="nik" required>
                                                        <label for="exampleInputPassword1">Nomor Whatsapp</label>
                                                        <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required name="phone"/>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="stepper.previous()">Previous</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">

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
    <script src="{{ url('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
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
        var delayInMilliseconds = 1000; //1 second

        function myFunc(variable, data) {
            var s = document.getElementById(variable);
            s.value = data;
        }

        function take_snapshot(flag) {
            if (flag == 1) {
                index = 0;
            }
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            // take snapshot and get image data
            Webcam.snap(function(data_uri) {
                // display results in page
                if (index == 5) {
                    return;
                }
                document.getElementById('results' + index).innerHTML =
                    '<img src="' + data_uri + '"/>';
                index += 1;
                myFunc("file" + index, data_uri);

                if (index != 5) {
                    setTimeout(function() {
                        take_snapshot(0);
                    }, delayInMilliseconds);
                }
            });
        }

    </script>
    <script type="text/javascript">
        $("#sidebar-ppl-face-recognation").addClass("active");
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        });

    </script>

@endsection
