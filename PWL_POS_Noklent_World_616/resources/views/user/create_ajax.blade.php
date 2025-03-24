<form action="{{ url('/user/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(-45deg, #3498db, #9b59b6, #1abc9c, #2980b9); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                <h5 class="modal-title text-white font-weight-bold">Tambah Data User</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">Level Pengguna</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-layer-group"></i></span>
                        </div>
                        <select name="level_id" id="level_id" class="form-control" required>
                            <option value="">-- Pilih Level --</option>
                            @foreach ($level as $l)
                                <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Username</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-user-tag"></i></span>
                        </div>
                        <input value="" type="text" name="username" id="username" class="form-control" 
                            placeholder="Masukkan username" required>
                    </div>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Nama Lengkap</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white"><i class="fas fa-user"></i></span>
                        </div>
                        <input value="" type="text" name="nama" id="nama" class="form-control" 
                            placeholder="Masukkan nama lengkap" required>
                    </div>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Password</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-danger text-white"><i class="fas fa-lock"></i></span>
                        </div>
                        <input value="" type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" required>
                        <div class="input-group-append">
                            <button class="btn btn-light border-0" type="button" id="togglePassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-back btn-outline-secondary">
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        // Add animation to form elements when modal loads
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
            const toggleIcon = $(this).find('i');

            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordField.attr('type', 'password');
                toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });

        $("#form-tambah").validate({
            rules: {
                level_id: {
                    required: true,
                    number: true
                },
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                }
            },
            messages: {
                level_id: {
                    required: "Level pengguna harus dipilih"
                },
                username: {
                    required: "Username tidak boleh kosong",
                    minlength: "Username minimal 3 karakter",
                    maxlength: "Username maksimal 20 karakter"
                },
                nama: {
                    required: "Nama tidak boleh kosong",
                    minlength: "Nama minimal 3 karakter",
                    maxlength: "Nama maksimal 100 karakter"
                },
                password: {
                    required: "Password tidak boleh kosong",
                    minlength: "Password minimal 6 karakter",
                    maxlength: "Password maksimal 20 karakter"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>