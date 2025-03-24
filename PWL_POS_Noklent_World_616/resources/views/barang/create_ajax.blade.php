<form action="{{ url('/barang/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(-45deg, #3498db, #9b59b6, #1abc9c, #2980b9); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                <h5 class="modal-title text-white font-weight-bold">Tambah Data Barang</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">Kategori Barang</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-layer-group"></i></span>
                        </div>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $k)
                                <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Kode Barang</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-barcode"></i></span>
                        </div>
                        <input type="text" name="barang_kode" id="barang_kode" class="form-control" 
                            placeholder="Masukkan kode barang" required>
                    </div>
                    <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Nama Barang</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white"><i class="fas fa-box"></i></span>
                        </div>
                        <input type="text" name="barang_nama" id="barang_nama" class="form-control" 
                            placeholder="Masukkan nama barang" required>
                    </div>
                    <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Harga Beli</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-danger text-white"><i class="fas fa-shopping-cart"></i></span>
                        </div>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control"
                            placeholder="Masukkan harga beli" required>
                    </div>
                    <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Harga Jual</label>
                    <div class="input-group input-group-custom">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-warning text-white"><i class="fas fa-money-bill-wave"></i></span>
                        </div>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control"
                            placeholder="Masukkan harga jual" required>
                    </div>
                    <small id="error-harga_jual" class="error-text form-text text-danger"></small>
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


        $("#form-tambah").validate({
            rules: {
                kategori_id: {
                    required: true
                },
                barang_kode: {
                    required: true,
                    maxlength: 10
                },
                barang_nama: {
                    required: true,
                    maxlength: 100
                },
                harga_beli: {
                    required: true,
                    number: true,
                    min: 0
                },
                harga_jual: {
                    required: true,
                    number: true,
                    min: 0
                }
            },
            messages: {
                kategori_id: {
                    required: "Kategori barang harus dipilih"
                },
                barang_kode: {
                    required: "Kode barang tidak boleh kosong",
                    maxlength: "Kode barang maksimal 10 karakter"
                },
                barang_nama: {
                    required: "Nama barang tidak boleh kosong",
                    maxlength: "Nama barang maksimal 100 karakter"
                },
                harga_beli: {
                    required: "Harga beli tidak boleh kosong",
                    number: "Harga beli harus berupa angka",
                    min: "Harga beli tidak boleh negatif"
                },
                harga_jual: {
                    required: "Harga jual tidak boleh kosong",
                    number: "Harga jual harus berupa angka",
                    min: "Harga jual tidak boleh negatif"
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
                            dataBarang.ajax.reload();
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
            }
        });
    });
</script>