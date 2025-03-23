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
                <a href="{{ url('level/create') }}" class="btn btn-success btn-md">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Level Baru
                </a>
                <div class="form-group has-search mb-0">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" id="searchBox" placeholder="Cari level...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_level">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0">Id</th>
                            <th class="border-top-0">Kode Level</th>
                            <th class="border-top-0">Nama Level</th>
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
            var dataLevel = $('#table_level').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('level/list') }}",
                    "dataType": "json",
                    "type": "GET"
                },
                columns: [{
                    data: "level_id",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "level_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "level_nama",
                    className: "",
                    orderable: true,
                    searchable: true
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
                dataLevel.search(this.value).draw();
            });

            // Hide default search box
            $('.dataTables_filter').hide();
        });
    </script>
@endpush