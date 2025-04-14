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
                    <a href="{{ url('/penjualan/create') }}" class="btn btn-success btn-md animate__animated animate__fadeIn">
                        <i class="fas fa-plus-circle mr-1"></i> Transaksi Baru
                    </a>
                    <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-export ml-2">
                        <i class="fas fa-file-excel mr-1"></i> Export Excel
                    </a>
                    <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-danger ml-2">
                        <i class="fas fa-file-pdf mr-1"></i> Export PDF
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-search float-right mb-0">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" id="searchBox" placeholder="Cari transaksi...">
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="table_penjualan">
                <thead class="bg-light">
                    <tr>
                        <th class="border-top-0">Kode Transaksi</th>
                        <th class="border-top-0">Tanggal</th>
                        <th class="border-top-0">Pembeli</th>
                        <th class="border-top-0">Petugas</th>
                        <th class="border-top-0">Total Item</th>
                        <th class="border-top-0">Total Harga</th>
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
@endsection

@push('js')
<script>
    var dataPenjualan;
    
    // Initialize DataTable
    $(document).ready(function() {
        dataPenjualan = $('#table_penjualan').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('/penjualan/list') }}",
                dataType: "json",
                type: "GET"
            },
            columns: [
                { data: "penjualan_kode", className: "" },
                { data: "tanggal_formatted", className: "" },
                { data: "pembeli", className: "" },
                { data: "user_nama", className: "" },
                { data: "total_item", className: "text-center" },
                { data: "total_harga", className: "text-right" },
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
            dataPenjualan.search(this.value).draw();
        });

        // Hide default search box
        $('.dataTables_filter').hide();
    });
</script>
@endpush