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
            <a href="{{ url('/penjualan/'.$penjualan->penjualan_id.'/pdf') }}" target="_blank" class="btn btn-danger ml-2">
                <i class="fas fa-file-pdf mr-1"></i> Cetak Nota
            </a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 text-white">Informasi Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%">Kode Transaksi</th>
                                <td>: {{ $penjualan->penjualan_kode }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>: {{ date('d M Y', strtotime($penjualan->tanggal_penjualan)) }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pembeli</th>
                                <td>: {{ $penjualan->pembeli }}</td>
                            </tr>
                            <tr>
                                <th>Petugas</th>
                                <td>: {{ $penjualan->user->nama }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4 bg-success text-white">
                    <div class="card-body text-center p-4">
                        <h5 class="mb-3">Total Pembayaran</h5>
                        <h2 class="display-4 font-weight-bold mb-0">
                            Rp. {{ number_format($penjualan->details->sum(function($detail) { 
                                return $detail->jumlah_barang * $detail->harga_barang; 
                            }), 0, ',', '.') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-white">Detail Pembelian</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th class="text-right">Harga (Rp)</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-right">Subtotal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->barang->barang_kode }}</td>
                                <td>{{ $detail->barang->barang_nama }}</td>
                                <td class="text-right">{{ number_format($detail->harga_barang, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $detail->jumlah_barang }}</td>
                                <td class="text-right">{{ number_format($detail->jumlah_barang * $detail->harga_barang, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="5" class="text-right">Total:</th>
                                <th class="text-right">
                                    {{ number_format($penjualan->details->sum(function($detail) { 
                                        return $detail->jumlah_barang * $detail->harga_barang; 
                                    }), 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection