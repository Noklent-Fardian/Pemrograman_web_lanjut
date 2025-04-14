@extends('layouts.template')

@section('content')
    <div class="card shadow-sm rounded-lg overflow-hidden">
        <div class="card-header text-white">
            <h3 class="card-title mb-0 font-weight-bold">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <a href="{{ url('/stok') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Stok
                        </a>
                        {{-- <button onclick="printTable()" class="btn btn-info ml-2">
                            <i class="fas fa-print mr-1"></i> Cetak
                        </button>
                        <a href="{{ url('/stok/export_excel') }}" class="btn btn-export ml-2">
                            <i class="fas fa-file-excel mr-1"></i> Export Excel
                        </a> --}}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-search float-right mb-0">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" id="searchBox" placeholder="Cari barang...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table_stock_barang">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-top-0">No</th>
                            <th class="border-top-0">Kode Barang</th>
                            <th class="border-top-0">Nama Barang</th>
                            <th class="border-top-0">Kategori</th>
                            <th class="border-top-0 text-center">Total Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockByBarang as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->barang_kode }}</td>
                                <td>{{ $item->barang_nama }}</td>
                                <td>{{ $item->kategori_nama }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge badge-pill badge-{{ $item->total_stok > 10 ? 'success' : ($item->total_stok > 0 ? 'warning' : 'danger') }} px-3 py-2">
                                        {{ $item->total_stok }} unit
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        @if (count($stockByBarang) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data stok barang</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#table_stock_barang').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "language": {
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
                }
            });

            // Connect custom search box to DataTable
            $('#searchBox').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Hide default search box
            $('.dataTables_filter').hide();
        });

        function printTable() {
            var printContents = document.getElementById('table_stock_barang').outerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = '<h1 class="text-center mb-4">Laporan Total Stok Per Barang</h1>' +
                '<p class="text-right">Tanggal Cetak: ' + new Date().toLocaleDateString() + '</p>' +
                printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
