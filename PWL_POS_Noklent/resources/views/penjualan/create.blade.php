@extends('layouts.app')

@section('subtitle', 'Penjualan')
@section('content_header_title', 'Penjualan')
@section('content_header_subtitle', 'Buat Transaksi')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Buat Transaksi Baru</h3>
            </div>
            
            <form id="transactionForm" method="post" action="{{ route('penjualan.store') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id">Pelanggan</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                                            {{ $user->nama }} ({{ $user->username }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Transaksi</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                    id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5>Detail Item</h5>
                    
                    <div id="itemContainer">
                        <div class="item-row row mb-3">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Barang</label>
                                    <select class="form-control barang-select" name="barang_id[]" required>
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->barang_id }}" data-harga="{{ $barang->harga_jual }}">
                                                {{ $barang->barang_nama }} ({{ $barang->barang_kode }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" class="form-control qty-input" name="jumlah[]" min="1" value="1" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control price-input" name="harga[]" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger btn-block remove-item">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-success" id="addItem">
                                <i class="fas fa-plus"></i> Tambah Item
                            </button>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="bg-light p-3">
                                <h5 class="mb-3">Ringkasan</h5>
                                <div class="d-flex justify-content-between">
                                    <strong>Total Item:</strong>
                                    <span id="totalItems">0</span>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <strong>Total Harga:</strong>
                                    <span id="totalPrice">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan Transaksi</button>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize the first row
        updatePrice($('.barang-select').first());
        
        // Add new item row
        $('#addItem').click(function() {
            var newRow = $('.item-row').first().clone();
            newRow.find('input').val('');
            newRow.find('.qty-input').val(1);
            newRow.find('select').val('');
            $('#itemContainer').append(newRow);
            
            updateSummary();
        });
        
        // Remove item row
        $(document).on('click', '.remove-item', function() {
            if ($('.item-row').length > 1) {
                $(this).closest('.item-row').remove();
                updateSummary();
            } else {
                alert('Minimal harus ada 1 item');
            }
        });
        
        // Update price when product is selected
        $(document).on('change', '.barang-select', function() {
            updatePrice($(this));
        });
        
        // Update totals when quantity changes
        $(document).on('input', '.qty-input', function() {
            updateSummary();
        });
        
        // Function to update price based on selected product
        function updatePrice(selectElement) {
            var selectedOption = selectElement.find('option:selected');
            var price = selectedOption.data('harga') || 0;
            selectElement.closest('.item-row').find('.price-input').val(price);
            updateSummary();
        }
        
        // Calculate and update summary
        function updateSummary() {
            var totalItems = 0;
            var totalPrice = 0;
            
            $('.item-row').each(function() {
                var qty = parseInt($(this).find('.qty-input').val()) || 0;
                var price = parseInt($(this).find('.price-input').val()) || 0;
                
                if (qty > 0 && price > 0) {
                    totalItems += qty;
                    totalPrice += (qty * price);
                }
            });
            
            $('#totalItems').text(totalItems);
            $('#totalPrice').text('Rp ' + totalPrice.toLocaleString('id-ID'));
        }
        
        // Form validation before submit
        $('#transactionForm').on('submit', function(e) {
            var valid = true;
            var errorMessage = '';
            
            // Check if pelanggan is selected
            if (!$('#user_id').val()) {
                valid = false;
                errorMessage = 'Pilih pelanggan terlebih dahulu';
            }
            
            // Check if all items have a product selected
            $('.barang-select').each(function() {
                if (!$(this).val()) {
                    valid = false;
                    errorMessage = 'Semua item harus memilih barang';
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    });
</script>
@endpush