@empty($supplier)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(-45deg, #ff7675, #d63031); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Data Tidak Ditemukan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger">
                    Data supplier tidak ditemukan dalam database.
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
    <form action="{{ url('/supplier/' . $supplier->supplier_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(-45deg, #f39c12, #e74c3c); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus Data Supplier
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                            <div>
                                <h5 class="mb-1">Konfirmasi Penghapusan</h5>
                                <p class="mb-0">Apakah Anda yakin ingin menghapus supplier berikut?</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Kode Supplier</th>
                                    <td>{{ $supplier->supplier_kode }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Supplier</th>
                                    <td>{{ $supplier->name_supplier }}</td>
                                </tr>
                                <tr>
                                    <th>Kontak</th>
                                    <td>{{ $supplier->supplier_contact }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            // Simple form submission without validation
            $("#form-delete").on('submit', function(e) {
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