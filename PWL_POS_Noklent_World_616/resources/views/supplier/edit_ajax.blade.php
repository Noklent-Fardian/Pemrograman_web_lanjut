@empty($supplier)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"
                style="background: linear-gradient(-45deg, #ff7675, #d63031); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Kesalahan!
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/supplier/' . $supplier->supplier_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: linear-gradient(-45deg, #4a69bd, #6a89cc, #1e3799, #0c2461); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Data Supplier
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Kode Supplier</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-hashtag"></i></span>
                            </div>
                            <input type="text" class="form-control" id="supplier_kode" name="supplier_kode"
                                value="{{ $supplier->supplier_kode }}" placeholder="Masukkan kode supplier" required>
                        </div>
                        <small id="error-supplier_kode" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Supplier</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-building"></i></span>
                            </div>
                            <input type="text" class="form-control" id="name_supplier" name="name_supplier"
                                value="{{ $supplier->name_supplier }}" placeholder="Masukkan nama supplier" required>
                        </div>
                        <small id="error-name_supplier" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Kontak</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" id="supplier_contact" name="supplier_contact"
                                value="{{ $supplier->supplier_contact }}" placeholder="Masukkan nomor kontak" required>
                        </div>
                        <small id="error-supplier_contact" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Email</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="supplier_email" name="supplier_email"
                                value="{{ $supplier->supplier_email }}" placeholder="Masukkan email (opsional)">
                        </div>
                        <small id="error-supplier_email" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Alamat</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-danger text-white"><i
                                        class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <textarea class="form-control" id="supplier_alamat" name="supplier_alamat" placeholder="Masukkan alamat (opsional)"
                                rows="3">{{ $supplier->supplier_alamat }}</textarea>
                        </div>
                        <small id="error-supplier_alamat" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary text-white"><i
                                        class="fas fa-sticky-note"></i></span>
                            </div>
                            <textarea class="form-control" id="supplier_keterangan" name="supplier_keterangan"
                                placeholder="Masukkan keterangan tambahan (opsional)" rows="3">{{ $supplier->supplier_keterangan }}</textarea>
                        </div>
                        <small id="error-supplier_keterangan" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary text-white"><i
                                        class="fas fa-toggle-on"></i></span>
                            </div>
                            <select class="form-control" id="supplier_aktif" name="supplier_aktif" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="1" {{ $supplier->supplier_aktif == 1 ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="0" {{ $supplier->supplier_aktif == 0 ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                        </div>
                        <small id="error-supplier_aktif" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">
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
                // punya Nokurento
                setTimeout(function() {
                    $('.form-group').eq(i).css({
                        'opacity': 1,
                        'transform': 'translateY(0)',
                        'transition': 'all 0.4s ease-out'
                    });
                }, 100 * (i + 1));
            });

            // Simple form submission without validation
            $("#form-edit").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
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
                            dataSupplier.ajax.reload();
                        } else {
                            // Clear previous error messages
                            $('.error-text').text('');

                            // If there are validation errors
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }

                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
                    }
                });
            });
        });
    </script>
@endempty
