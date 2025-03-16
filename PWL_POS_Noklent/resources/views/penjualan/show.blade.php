@extends('layouts.app')

@section('subtitle', 'Penjualan')
@section('content_header_title', 'Detail Transaksi')
@section('content_header_subtitle', 'Transaksi #' . $penjualan->penjualan_id)

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-invoice mr-2"></i>
                    Detail Transaksi #{{ $penjualan->penjualan_id }}
                </h3>
                <div class="card-tools">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Transaksi</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%">ID Transaksi</th>
                                <td>{{ $penjualan->penjualan_id }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Waktu</th>
                                <td>{{ \Carbon\Carbon::parse($penjualan->created_at)->format('H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Pelanggan</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 40%">ID Pelanggan</th>
                                <td>{{ $penjualan->user->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $penjualan->user->nama }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $penjualan->user->username }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h5 class="mb-3">Detail Item</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-right">Harga Satuan</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['kode_barang'] }}</td>
                                    <td>{{ $item['nama_barang'] }}</td>
                                    <td class="text-center">{{ $item['qty'] }}</td>
                                    <td class="text-right">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <th class="text-right">Rp {{ number_format($penjualan->getTotalHarga(), 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection