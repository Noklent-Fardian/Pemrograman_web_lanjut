@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"
                style="background: linear-gradient(-45deg, #ff7675, #d63031); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger animate__animated animate__fadeIn">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-ban fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, data pengguna yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ url('/user') }}" class="btn btn-back btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . $user->user_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(-45deg, #f39c12, #e74c3c); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus Data User
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning animate__animated animate__fadeIn">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                            <div>
                                <h5 class="mb-1">Konfirmasi Penghapusan</h5>
                                <p class="mb-0">Apakah Anda yakin ingin menghapus data pengguna berikut?</p>
                            </div>
                        </div>
                    </div>

                    <div class="user-detail-container mt-4 animate__animated animate__fadeIn">
                        <div class="user-info-card">
                            <div class="user-info-item">
                                <div class="info-label">
                                    <i class="fas fa-layer-group text-info"></i>
                                    <span>Level Pengguna</span>
                                </div>
                                <div class="info-value">
                                    <span class="badge badge-info">{{ $user->level->level_nama }}</span>
                                </div>
                            </div>
                            <div class="user-info-item">
                                <div class="info-label">
                                    <i class="fas fa-user-tag text-primary"></i>
                                    <span>Username</span>
                                </div>
                                <div class="info-value">{{ $user->username }}</div>
                            </div>
                            <div class="user-info-item">
                                <div class="info-label">
                                    <i class="fas fa-user text-success"></i>
                                    <span>Nama Lengkap</span>
                                </div>
                                <div class="info-value">{{ $user->nama }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-dismiss="modal" class="btn btn-back btn-outline-secondary">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash-alt mr-2"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            // Add animation to elements when modal loads
            $('.user-detail-container').css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });

            setTimeout(function() {
                $('.user-detail-container').css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.6s ease-out'
                });
            }, 300);

            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
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
                                        $.each(response.msgField, function(prefix,
                                            val) {
                                            $('#error-' + prefix).text(val[
                                                0]);
                                        });
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi Kesalahan',
                                            text: response.message
                                        });
                                    }
                                },
                            });
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
@endempty
