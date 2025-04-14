@extends('layouts.template')

@section('content')
    <div class="card shadow-sm rounded-lg overflow-hidden">
        <div class="card-header text-white">
            <h3 class="card-title mb-0 font-weight-bold">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <button class="btn btn-success btn-md animate__animated animate__fadeIn" id="btnAddStock">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah Stok Baru
                        </button>
                        <a href="{{ url('/stok/export_excel') }}" class="btn btn-export ml-2">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel
                        </a>
                        <a href="{{ url('/stok/export_pdf') }}" class="btn btn-danger ml-2">
                            <i class="fas fa-file-pdf mr-1"></i> Export PDF
                        </a>
                        <a href="{{ url('/stok/show_allBarang') }}" class="btn btn-primary ml-2">
                            <i class="fas fa-boxes mr-1"></i> Goedang
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-search float-right mb-0">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" id="searchBox" placeholder="Cari stok...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_stok">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0">ID</th>
                            <th class="border-top-0">Tanggal</th>
                            <th class="border-top-0">Barang</th>
                            <th class="border-top-0">Supplier</th>
                            <th class="border-top-0">Jumlah</th>
                            <th class="border-top-0">Petugas</th>
                            <th class="border-top-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will fill this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal for Add/Edit Stock -->
    <div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(-45deg, #3498db, #9b59b6, #1abc9c, #2980b9); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                    <h5 class="modal-title text-white font-weight-bold" id="stockModalLabel">
                        <i class="fas fa-cubes mr-2"></i> Tambah Stok Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="stockForm">
                    @csrf
                    <input type="hidden" id="stock_id" name="stock_id">
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Pilih Barang</label>
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-box"></i></span>
                                </div>
                                <select class="form-control" id="barang_id" name="barang_id" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                    <option value="{{ $barang->barang_id }}">{{ $barang->barang_kode }} - {{ $barang->barang_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small id="error-barang_id" class="error-text form-text text-danger"></small>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Pilih Supplier</label>
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-truck"></i></span>
                                </div>
                                <select class="form-control" id="supplier_id" name="supplier_id" required>
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_kode }} - {{ $supplier->name_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Masuk</label>
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" id="stok_tanggal_masuk" name="stok_tanggal_masuk" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <small id="error-stok_tanggal_masuk" class="error-text form-text text-danger"></small>
                        </div>
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Jumlah</label>
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white"><i class="fas fa-sort-numeric-up"></i></span>
                                </div>
                                <input type="number" class="form-control" id="stok_jumlah" name="stok_jumlah" min="1" value="1" required>
                            </div>
                            <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
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
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal for View Stock Details -->
    <div class="modal fade" id="stockDetailModal" tabindex="-1" role="dialog" aria-labelledby="stockDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(-45deg, #3498db, #9b59b6, #1abc9c, #2980b9); background-size: 400% 400%; animation: gradient 15s ease infinite;">
                    <h5 class="modal-title text-white font-weight-bold" id="stockDetailModalLabel">
                        <i class="fas fa-info-circle mr-2"></i> Detail Stok
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <tr>
                                    <th width="30%">ID Stok</th>
                                    <td id="detail_stock_id"></td>
                                </tr>
                                <tr>
                                    <th>Kode Barang</th>
                                    <td id="detail_barang_kode"></td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td id="detail_barang_nama"></td>
                                </tr>
                                <tr>
                                    <th>Supplier</th>
                                    <td id="detail_supplier"></td>
                                </tr>
                                <tr>
                                    <th>Petugas</th>
                                    <td id="detail_petugas"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Masuk</th>
                                    <td id="detail_tanggal"></td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td id="detail_jumlah"></td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td id="detail_created_at"></td>
                                </tr>
                                <tr>
                                    <th>Diperbarui Pada</th>
                                    <td id="detail_updated_at"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteStockModal" tabindex="-1" role="dialog" aria-labelledby="deleteStockModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteStockModalLabel">
                        <i class="fas fa-trash mr-2"></i> Hapus Data Stok
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data stok ini?</p>
                    <p><strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    var dataStok;
    var stockIdToDelete;
    
    // Initialize DataTable
    $(document).ready(function() {
        dataStok = $('#table_stok').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('/stok/list') }}",
                dataType: "json",
                type: "GET"
            },
            columns: [
                { data: "stock_id", className: "text-center" },
                { data: "tanggal_formatted", className: "" },
                { data: "barang_nama", className: "" },
                { data: "supplier_nama", className: "" },
                { 
                    data: "stok_jumlah", 
                    className: "text-center",
                    render: function(data) {
                        return data + ' unit';
                    }
                },
                { data: "user_nama", className: "" },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"></div>',
                search: "",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                },
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });

        // Connect custom search box to DataTable
        $('#searchBox').on('keyup', function() {
            dataStok.search(this.value).draw();
        });

        // Hide default search box
        $('.dataTables_filter').hide();
        
        // Add Stock Button Click
        $('#btnAddStock').click(function() {
            resetStockForm();
            $('#stockModalLabel').html('<i class="fas fa-plus-circle mr-2"></i> Tambah Stok Baru');
            $('#stockModal').modal('show');
        });
        
        // Stock Form Submit
        $('#stockForm').submit(function(e) {
            e.preventDefault();
            $('.error-text').text('');
            
            var stockId = $('#stock_id').val();
            var url = stockId ? "{{ url('/stok') }}/" + stockId : "{{ url('/stok') }}";
            var method = stockId ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                type: method,
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#stockModal').modal('hide');
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        
                        dataStok.ajax.reload();
                    } else {
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
        
        // Confirm Delete Button Click
        $('#confirmDeleteBtn').click(function() {
            if (stockIdToDelete) {
                $.ajax({
                    url: "{{ url('/stok') }}/" + stockIdToDelete,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#deleteStockModal').modal('hide');
                        
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            
                            dataStok.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteStockModal').modal('hide');
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
                    }
                });
            }
        });
    });
    

    function resetStockForm() {
        $('#stock_id').val('');
        $('#stockForm')[0].reset();
        $('#stockForm .error-text').text('');
        $('#stok_tanggal_masuk').val("{{ date('Y-m-d') }}");
        $('#stok_jumlah').val(1);
    }
    
    // Show Stock Detail
    function showDetail(id) {
        $.ajax({
            url: "{{ url('/stok') }}/" + id,
            type: 'GET',
            success: function(response) {
                $('#detail_stock_id').text(response.stock_id);
                $('#detail_barang_kode').text(response.barang.barang_kode);
                $('#detail_barang_nama').text(response.barang.barang_nama);
                $('#detail_supplier').text(response.supplier.name_supplier);
                $('#detail_petugas').text(response.user.nama);
                
                // Format date
                var date = new Date(response.stok_tanggal_masuk);
                var formattedDate = formatDate(date);
                $('#detail_tanggal').text(formattedDate);
                
                $('#detail_jumlah').text(response.stok_jumlah + ' unit');
                
                // Format datetime
                var createdAt = new Date(response.created_at);
                var updatedAt = new Date(response.updated_at);
                $('#detail_created_at').text(formatDateTime(createdAt));
                $('#detail_updated_at').text(formatDateTime(updatedAt));
                
                $('#stockDetailModal').modal('show');
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengambil data'
                });
            }
        });
    }
    
    // Edit Stock
    function editStock(id) {
        resetStockForm();
        
        $.ajax({
            url: "{{ url('/stok') }}/" + id + "/edit",
            type: 'GET',
            success: function(response) {
                var stock = response.stock;
                
                $('#stock_id').val(stock.stock_id);
                $('#barang_id').val(stock.barang_id);
                $('#supplier_id').val(stock.supplier_id);
                $('#stok_tanggal_masuk').val(stock.stok_tanggal_masuk);
                $('#stok_jumlah').val(stock.stok_jumlah);
                
                $('#stockModalLabel').html('<i class="fas fa-edit mr-2"></i> Edit Data Stok');
                $('#stockModal').modal('show');
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengambil data'
                });
            }
        });
    }
    
    // Delete Stock
    function deleteStock(id) {
        stockIdToDelete = id;
        $('#deleteStockModal').modal('show');
    }
    
  
    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        
        return day + '-' + month + '-' + year;
    }
    
    // Helper function to format datetime
    function formatDateTime(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        var hours = String(date.getHours()).padStart(2, '0');
        var minutes = String(date.getMinutes()).padStart(2, '0');
        var seconds = String(date.getSeconds()).padStart(2, '0');
        
        return day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' + seconds;
    }
</script>
@endpush