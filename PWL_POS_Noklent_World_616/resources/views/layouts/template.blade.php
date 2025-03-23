<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PW: Laravel Noklent Starter Code') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @stack('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        #table_user tbody tr {
            transition: all 0.2s ease;
        }

        #table_user tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            border-radius: 0.2rem;
            margin-right: 0.25rem;
        }

        .has-search .form-control {
            padding-left: 2.375rem;
            border-radius: 20px;
            width: 300px;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 20px;
            padding: 8px 20px;
            box-shadow: 0 4px 6px rgba(32, 201, 151, 0.25);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(32, 201, 151, 0.35);
        }

        /* Animated gradient background for header */
        .card-header {
            background: linear-gradient(-45deg, #3498db, #9b59b6, #1abc9c, #2980b9);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 80px;
            overflow: hidden;
            display: flex;
            align-items: center;
            border-bottom: none;
        }

        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon fill="rgba(255,255,255,0.05)" points="0,100 100,0 100,100"/></svg>');
            background-size: cover;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }


        .form-control {
            border-radius: 0.5rem;
            transition: all 0.3s;
            border: 1px solid #e1e5eb;
            height: auto
        }

        .form-control:focus {
            border-color: #4285f4;
            box-shadow: 0 0 0 0.2rem rgba(66, 133, 244, 0.25);
            transform: translateY(-1px);
        }

        .input-group-custom {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            overflow: hidden;
            transition: all 0.3s;
        }

        .input-group-custom:hover {
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
        }

        .input-group-text {
            border: none;
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
        }

        .custom-select {
            height: calc(2.5rem + 2px);
            background-color: #fff;
            border: 1px solid #e1e5eb;
            border-radius: 0.5rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;

            cursor: pointer;
        }

        .custom-select:hover {
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
        }


        .btn-back {
            border-radius: 0.5rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4285f4, #34a853);
            border: none;
            box-shadow: 0 4px 6px rgba(66, 133, 244, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #34a853, #4285f4);
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(66, 133, 244, 0.4);
        }

        .btn-outline-secondary {
            color: #6c757d;
            border: 2px solid #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        }

        /* Card styling */
        .card {
            border: none;
            transition: all 0.3s;
        }

        .shadow-lg {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .password-toggle {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        hr {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .text-md-right {
                text-align: left !important;
            }

            .col-form-label {
                padding-bottom: 0;
            }
        }

        .user-avatar-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .user-avatar {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            animation: float 6s ease-in-out infinite;
        }

        .user-avatar i {
            font-size: 60px;
            color: white;
        }

        @keyframes float {
            0% {
                transform: translatey(0px);
            }

            50% {
                transform: translatey(-10px);
            }

            100% {
                transform: translatey(0px);
            }
        }

        .user-info-card {
            background-color: #fff;
            border-radius: 0.8rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .user-info-item {
            display: flex;
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .user-info-item:last-child {
            border-bottom: none;
        }

        .user-info-item:hover {
            background-color: rgba(0, 0, 0, 0.01);
            transform: translateX(5px);
        }

        .info-label {
            width: 180px;
            display: flex;
            align-items: center;
        }

        .info-label i {
            width: 24px;
            margin-right: 10px;
            font-size: 1rem;
        }

        .info-value {
            font-weight: 600;
            flex: 1;
        }

        /* Alert styling */
        .alert-danger {
            background: linear-gradient(45deg, #ff7675, #d63031);
            color: white;
            border: none;
            border-radius: 0.8rem;
            box-shadow: 0 4px 10px rgba(255, 118, 117, 0.3);
        }

        .badge-info {
            background: linear-gradient(45deg, #3498db, #2980b9);
            border: none;
            font-size: 0.9rem;
            box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
        }


        @media (max-width: 767px) {
            .user-info-item {
                flex-direction: column;
                padding: 1rem;
            }

            .info-label {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .col-md-3 {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            height="60" width="60">
    </div>

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PWL POS</span>
            </a>

            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('layouts.breadcrumb')
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All
            rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- CSRF Token Setup for AJAX -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <!-- Jquery Validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(window).on('load', function() {

            $('.preloader').delay(200).fadeOut('slow');

        });

        $(document).ready(function() {
            // Add animation to form elements when page loads
            $('.form-group').each(function(i) {
                $(this).css({
                    'opacity': 0,
                    'transform': 'translateY(20px)'
                });

                setTimeout(function() {
                    $('.form-group').eq(i).css({
                        'opacity': 1,
                        'transform': 'translateY(0)',
                        'transition': 'all 0.4s ease-out'
                    });
                }, 100 * (i + 1));
            });

            // Toggle password visibility
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const passwordFieldType = passwordField.attr('type');
                const toggleIcon = $(this);

                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    passwordField.attr('type', 'password');
                    toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });

            // Style validation on submit attempt
            $('form').on('submit', function() {
                if (this.checkValidity() === false) {
                    $(this).find(':invalid').first().focus();
                    $(this).addClass('was-validated');
                    return false;
                }
            });
        });
    </script>
    @stack('js')
</body>

</html>
