<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register PWL POS</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/loginPage.css') }}">
    <style>
        .login-box {
            max-height: 550px;
          
        }
        .container {
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <!-- Topographic Background -->
            <div class="topo-pattern"></div>

            <!-- Circle Shapes -->
            <div class="shape circle circle-1"></div>
            <div class="shape circle circle-2"></div>
            <div class="shape circle circle-3"></div>

            <!-- Ring Shapes -->
            <div class="shape ring ring-1"></div>
            <div class="shape ring ring-2"></div>

            <!-- Polygon Shapes -->
            <div class="shape triangle triangle-1"></div>
            <div class="shape square square-1"></div>

            <!-- Glass Effect -->
            <div class="glass-effect glass-1"></div>

            <div class="welcome-content">
                <h1>Buat Akun Baru!</h1>
                <p>Daftarkan diri Anda untuk mulai berbelanja di toko kami</p>
            </div>
        </div>

        <!-- Register Section -->
        <div class="login-section">
            <div class="login-box">
                <h2>Register</h2>
                <form action="{{ url('register') }}" method="POST" id="form-register">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <small id="error-username" class="error-text"></small>
                    </div>
                    <div class="input-group">
                        <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required>
                        <span class="input-icon"><i class="fas fa-id-card"></i></span>
                        <small id="error-nama" class="error-text"></small>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <small id="error-password" class="error-text"></small>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required>
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <small id="error-password_confirmation" class="error-text"></small>
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-user-plus"></i>
                        <span>Daftar</span>
                    </button>

                    <div class="mt-3 text-center">
                        <p>Sudah punya akun? <a href="{{ url('login') }}">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // Custom validation styling
            $.validator.setDefaults({
                errorClass: 'error',
                errorElement: 'span'
            });

            $("#form-register").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    password: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    username: {
                        required: "Username diperlukan",
                        minlength: "Username minimal 4 karakter",
                        maxlength: "Username maksimal 20 karakter"
                    },
                    nama: {
                        required: "Nama lengkap diperlukan",
                        minlength: "Nama minimal 3 karakter",
                        maxlength: "Nama maksimal 100 karakter"
                    },
                    password: {
                        required: "Password diperlukan",
                        minlength: "Password minimal 4 karakter",
                        maxlength: "Password maksimal 20 karakter"
                    },
                    password_confirmation: {
                        required: "Konfirmasi password diperlukan",
                        equalTo: "Konfirmasi password tidak cocok"
                    }
                },
                submitHandler: function(form) {
                 
                    $('.error-text').text('');

                    
                    const $btn = $(form).find('.btn-primary');
                    const originalText = $btn.html();
                    $btn.html('<i class="fas fa-circle-notch fa-spin"></i> Processing...');
                    $btn.prop('disabled', true);

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                // Success case
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Registrasi Berhasil!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1000,
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                    heightAuto: false,
                                    position: 'center',
                                    customClass: {
                                        container: 'swal-container-fixed'
                                    },
                                    didOpen: () => {
                                        $btn.html('<i class="fas fa-check"></i> Success!');
                                        $btn.css('background', 'linear-gradient(135deg, #28a745, #20c997)');
                                        Swal.showLoading();
                                    }
                                }).then(function() {
                                    // Redirect with slight delay for better UX
                                    window.location = response.redirect;
                                });
                            } else {
                                // Error case
                                $btn.html(originalText);
                                $btn.prop('disabled', false);
                                
                                // Display field-specific errors
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                }
                                
                                // Show error popup
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registrasi Gagal',
                                    text: response.message || 'Terjadi kesalahan pada saat registrasi',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#6a11cb',
                                    heightAuto: false,
                                    position: 'center'
                                });
                            }
                        }
                    });
                    return false;
                },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('error');
                    $(element).closest('.input-group').addClass('has-error');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('error');
                    $(element).closest('.input-group').removeClass('has-error');
                }
            });
        });
    </script>
</body>

</html>