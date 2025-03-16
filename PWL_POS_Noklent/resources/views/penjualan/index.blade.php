@extends('layouts.app')

@section('subtitle', 'Penjualan')
@section('content_header_title', 'Data Penjualan')
@section('content_header_subtitle', 'Daftar Transaksi Penjualan')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Transaksi</h3>
                <div class="card-tools">
                    <a href="{{ route('penjualan.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Transaksi Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Nama Pembeli</th>
                                <th>Total Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction['id'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction['tanggal'])->format('d/m/Y') }}</td>
                                    <td>{{ $transaction['nama_pembeli'] }}</td>
                                    <td>Rp {{ number_format($transaction['total_harga'], 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('penjualan.show', $transaction['id']) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection