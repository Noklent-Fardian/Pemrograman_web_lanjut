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
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter: </label>
                        <div class="col-3">
                            <select class="form-control" id="kategori_id" name="kategori_id">
                                <option value="">- Semua Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <a href="{{ url('barang/create') }}" class="btn btn-success btn-md animate__animated animate__fadeIn">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Barang Baru
                </a>
                <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-primary btn-md">
                    <i class="fas fa-file-excel mr-1"></i> Import Barang
                </button>
                <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah
                    Ajax</button>
                <div class="form-group has-search mb-0">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" id="searchBox" placeholder="Cari barang...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_barang">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0">#</th>
                            <th class="border-top-0">Kode</th>
                            <th class="border-top-0">Nama Barang</th>
                            <th class="border-top-0">Kategori</th>
                            <th class="border-top-0">Harga Beli</th>
                            <th class="border-top-0">Harga Jual</th>
                            <th class="border-top-0 text-center">Aksi</th>
                            <th class="border-top-0 text-center">AJAX</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will fill this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataBarang;
        $(document).ready(function() {
            // Initialize DataTable
            dataBarang = $('#table_barang').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('barang/list') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function(d) {
                        d.kategori_id = $('#kategori_id').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "barang_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "barang_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "kategori.kategori_nama",
                    className: "",
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return '<span class="badge badge-info">' + data + '</span>';
                    }
                }, {
                    data: "harga_beli",
                    className: "text-right",
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                }, {
                    data: "harga_jual",
                    className: "text-right",
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                }, {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data;
                    }
                }, {
                    data: "AJAX",
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
                dataBarang.search(this.value).draw();
            });

            // Hide default search box
            $('.dataTables_filter').hide();

            // Change kategori filter on select change
            $('#kategori_id').on('change', function() {
                dataBarang.draw();
            });
        });
    </script>
@endpush
