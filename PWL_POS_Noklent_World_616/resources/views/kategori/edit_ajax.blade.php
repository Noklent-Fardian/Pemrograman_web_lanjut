@empty($kategori)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(-45deg, #ff7675, #d63031); background-size: 400% 400%; animation: gradient 15s ease infinite;">
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
                            <p class="mb-0">Maaf, data kategori yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-back btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kategori/' . $kategori->kategori_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(-45deg, #4a69bd, #6a89cc, #1e3799, #0c2461); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Data Kategori
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Kode Kategori</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-code"></i></span>
                            </div>
                            <input value="{{ $kategori->kategori_kode }}" type="text" name="kategori_kode" id="kategori_kode" 
                                class="form-control" placeholder="Masukkan kode kategori" required>
                        </div>
                        <small id="error-kategori_kode" class="error-text form-text text-danger"></small>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Kategori</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-tag"></i></span>
                            </div>
                            <input value="{{ $kategori->kategori_nama }}" type="text" name="kategori_nama" id="kategori_nama" 
                                class="form-control" placeholder="Masukkan nama kategori" required>
                        </div>
                        <small id="error-kategori_nama" class="error-text form-text text-danger"></small>
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

            $("#form-edit").validate({
                rules: {
                    kategori_kode: {
                        required: true,
                        minlength: 1,
                        maxlength: 10
                    },
                    kategori_nama: {
                        required: true,
                        minlength: 1,
                        maxlength: 100
                    }
                },
                messages: {
                    kategori_kode: {
                        required: "Kode kategori tidak boleh kosong",
                        minlength: "Kode kategori minimal 1 karakter",
                        maxlength: "Kode kategori maksimal 10 karakter"
                    },
                    kategori_nama: {
                        required: "Nama kategori tidak boleh kosong",
                        minlength: "Nama kategori minimal 1 karakter",
                        maxlength: "Nama kategori maksimal 100 karakter"
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
                                dataKategori.ajax.reload();
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
@endempty