<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tafis Application</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/images/logoLws.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/images/lws-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/images/lws-16x16.png') }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Google Font -->
    <link href="" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/styles/styles.css') }}">

</head>

<body>
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a>
                    <img src="{{ asset('vendor/images/tafis-logo.png') }}" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('vendor/images/login-page-img.png') }}" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary style2">Login Tafis Application</h2>
                        </div>

                        @if (Session::has('salahPin'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Alert!</strong> {{ Session::get('salahPin') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (Session::has('nikTidakTerdaftar'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Alert!</strong> {{ Session::get('nikTidakTerdaftar') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (Session::has('notLoggedIn'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Alert!</strong> {{ Session::get('notLoggedIn') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action={{ route('login') }} method="post">
                            @csrf
                            <div class="input-group custom">
                                <input name="nik" type="number" class="form-control form-control-lg style2"
                                    placeholder="NIK" maxlength="10"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input name="pin" type="password" class="form-control form-control-lg"
                                    placeholder="PIN" maxlength="6">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                {{-- <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Remember</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="forgot-password"><a href="forgot-password.html">Forgot Password</a>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button type="submit"
                                            class="btn btn-primary btn-lg btn-block style2">Login</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="{{ asset('vendor/scripts/core.js') }}"></script>
    <script src="{{ asset('vendor/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendor/scripts/process.js') }}"></script>
    <script src="{{ asset('vendor/scripts/layout-settings.js') }}"></script>
</body>

</html>
