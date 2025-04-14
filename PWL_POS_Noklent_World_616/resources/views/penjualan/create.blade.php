@extends('layouts.template')

@section('content')
<div class="card shadow-sm rounded-lg overflow-hidden">
    <div class="card-header text-white">
        <h3 class="card-title mb-0 font-weight-bold">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <a href="{{ url('/penjualan') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
        </div>

        <form id="formPenjualan" method="POST" action="{{ url('/penjualan') }}">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="penjualan_kode">Kode Transaksi</label>
                        <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" 
                            value="{{ $transactionCode }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_penjualan">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" 
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="pembeli">Nama Pembeli</label>
                        <input type="text" class="form-control" id="pembeli" name="pembeli" 
                            placeholder="Masukkan nama pembeli" required>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <h5>Tambah Barang</h5>
                    <hr>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="barang_id">Pilih Barang</label>
                        <select class="form-control" id="barang_id">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->barang_id }}">{{ $b->barang_kode }} - {{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" id="harga" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" min="1" value="1">
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-primary btn-block" id="btnAddItem">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_items">
                    <thead class="bg-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th class="text-right">Harga (Rp)</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Subtotal (Rp)</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="empty_row">
                            <td colspan="6" class="text-center">Belum ada barang yang ditambahkan</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="4" class="text-right">Total:</th>
                            <th class="text-right" id="total_harga">Rp. 0</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 text-right">
                <button type="submit" class="btn btn-success px-5" id="btnSimpan" disabled>
                    <i class="fas fa-save mr-1"></i> Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Loading -->
<div class="modal fade" id="loadingModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <h5>Sedang Memproses...</h5>
                <p class="mb-0 text-muted">Mohon tunggu sebentar</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    var items = [];
    var total = 0;

    $(document).ready(function() {
        // Handle barang selection change
        $('#barang_id').change(function() {
            var barangId = $(this).val();
            if (barangId) {
                $.ajax({
                    url: "{{ url('/penjualan/barang') }}/" + barangId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            $('#harga').val(response.data.harga_jual);
                            $('#stok').val(response.data.stok);
                            $('#jumlah').attr('max', response.data.stok);
                            $('#jumlah').val(1);
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        Swal.fire('Error', 'Terjadi kesalahan saat mengambil data barang', 'error');
                    }
                });
            } else {
                $('#harga').val('');
                $('#stok').val('');
                $('#jumlah').val('1');
            }
        });

        // Add item to cart
        $('#btnAddItem').click(function() {
            var barangId = $('#barang_id').val();
            var barangText = $('#barang_id option:selected').text();
            var harga = parseInt($('#harga').val() || 0);
            var stok = parseInt($('#stok').val() || 0);
            var jumlah = parseInt($('#jumlah').val() || 0);
            
            // Validate inputs
            if (!barangId) {
                Swal.fire('Perhatian', 'Silakan pilih barang terlebih dahulu', 'warning');
                return;
            }
            
            if (jumlah <= 0) {
                Swal.fire('Perhatian', 'Jumlah harus lebih dari 0', 'warning');
                return;
            }
            
            if (jumlah > stok) {
                Swal.fire('Perhatian', 'Jumlah melebihi stok yang tersedia', 'warning');
                return;
            }
            
            // Check if item already exists in cart
            var existingItem = items.find(item => item.barang_id == barangId);
            if (existingItem) {
                // Check if the new total quantity exceeds stock
                if (existingItem.jumlah + jumlah > stok) {
                    Swal.fire('Perhatian', 'Total jumlah melebihi stok yang tersedia', 'warning');
                    return;
                }
                
                existingItem.jumlah += jumlah;
                existingItem.subtotal = existingItem.jumlah * existingItem.harga;
                
                // Update row in table
                $(`#item-${barangId} .jumlah`).text(existingItem.jumlah);
                $(`#item-${barangId} .subtotal`).text('Rp. ' + formatNumber(existingItem.subtotal));
            } else {
                // Extract code and name from selection
                var parts = barangText.split(' - ');
                var barangKode = parts[0];
                var barangNama = parts[1];
                
                // Add new item to array
                var newItem = {
                    barang_id: barangId,
                    barang_kode: barangKode,
                    nama_barang: barangNama,
                    harga: harga,
                    jumlah: jumlah,
                    subtotal: harga * jumlah
                };
                items.push(newItem);
                
                // Add row to table
                var newRow = `
                    <tr id="item-${barangId}">
                        <td>${barangKode}</td>
                        <td>${barangNama}</td>
                        <td class="text-right">Rp. ${formatNumber(harga)}</td>
                        <td class="text-center jumlah">${jumlah}</td>
                        <td class="text-right subtotal">Rp. ${formatNumber(harga * jumlah)}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${barangId})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $('#empty_row').hide();
                $('#table_items tbody').append(newRow);
            }
            
            // Reset inputs
            $('#barang_id').val('').trigger('change');
            $('#harga').val('');
            $('#stok').val('');
            $('#jumlah').val('1');
            
            // Update total
            updateTotal();
        });
        
        // Form submission
        $('#formPenjualan').submit(function(e) {
            e.preventDefault();
            
            if (items.length === 0) {
                Swal.fire('Perhatian', 'Tambahkan minimal satu barang ke keranjang', 'warning');
                return;
            }
            
            // Show loading modal
            $('#loadingModal').modal('show');
            
            // Prepare form data
            var formData = {
                _token: $('input[name=_token]').val(),
                penjualan_kode: $('#penjualan_kode').val(),
                tanggal_penjualan: $('#tanggal_penjualan').val(),
                pembeli: $('#pembeli').val(),
                items: items
            };
            
            // Submit AJAX request
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#loadingModal').modal('hide');
                    
                    if (response.status) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Lihat Struk',
                            cancelButtonText: 'Transaksi Baru'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.open(`{{ url('/penjualan') }}/${response.data.penjualan_id}`, '_blank');
                                window.location.href = "{{ url('/penjualan') }}";
                            } else {
                                window.location.href = "{{ url('/penjualan/create') }}";
                            }
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    $('#loadingModal').modal('hide');
                    
                    var message = 'Terjadi kesalahan pada server';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    
                    Swal.fire('Error', message, 'error');
                }
            });
        });
    });
    
    // Remove item from cart
    function removeItem(barangId) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus barang ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Find and remove from items array
                items = items.filter(item => item.barang_id != barangId);
                
                // Remove row from table
                $(`#item-${barangId}`).remove();
                
                // Show empty row if needed
                if (items.length === 0) {
                    $('#empty_row').show();
                }
                
                // Update total
                updateTotal();
            }
        });
    }
    
    // Update total calculation
    function updateTotal() {
        total = items.reduce((sum, item) => sum + item.subtotal, 0);
        $('#total_harga').text('Rp. ' + formatNumber(total));
        
        // Enable/disable submit button based on items
        $('#btnSimpan').prop('disabled', items.length === 0);
    }
    
    // Format number with thousands separator
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
</script>
@endpush