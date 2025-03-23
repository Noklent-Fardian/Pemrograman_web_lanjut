
@extends('layouts.template')

@section('content')
    <div class="card shadow-sm rounded-lg overflow-hidden">
        <div class="card-header bg-gradient-primary text-white">
            <h3 class="card-title mb-0 font-weight-bold">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <a href="{{ url('supplier/create') }}" class="btn btn-success btn-md animate__animated animate__fadeIn">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Supplier Baru
                </a>
                <div class="form-group has-search mb-0">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" id="searchBox" placeholder="Cari supplier...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_supplier">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0">No</th>
                            <th class="border-top-0">Kode</th>
                            <th class="border-top-0">Nama Supplier</th>
                            <th class="border-top-0">Kontak</th>
                            <th class="border-top-0">Email</th>
                            <th class="border-top-0">Status</th>
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
        $(document).ready(function() {
            // Initialize DataTable
            var dataSupplier = $('#table_supplier').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('supplier/list') }}",
                    "dataType": "json",
                    "type": "GET"
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "supplier_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "name_supplier",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "supplier_contact",
                    className: "",
                    orderable: false,
                    searchable: true
                }, {
                    data: "supplier_email",
                    className: "",
                    orderable: false,
                    searchable: true,
                    render: function(data) {
                        return data ? data : '<i class="text-muted">Tidak ada</i>';
                    }
                }, {
                    data: "status_badge",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data;
                    }
                }],
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
                dataSupplier.search(this.value).draw();
            });

            // Hide default search box
            $('.dataTables_filter').hide();
        });
    </script>
@endpush