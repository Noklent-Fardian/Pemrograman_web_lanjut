@extends('layouts.app')

@section('subtitle', 'Stock')
@section('content_header_title', 'Stock')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Stock</h3>
            </div>
            <form method="post" action="{{ route('stock.update', $stock->stock_id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="barang_id">Barang</label>
                        <select class="form-control @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id">
                            <option value="">Pilih Barang</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->barang_id }}" {{ old('barang_id', $stock->barang_id) == $barang->barang_id ? 'selected' : '' }}>
                                    {{ $barang->barang_nama }} ({{ $barang->barang_kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                            <option value="">Pilih User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->user_id }}" {{ old('user_id', $stock->user_id) == $user->user_id ? 'selected' : '' }}>
                                    {{ $user->nama }} ({{ $user->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="stok_tanggal_masuk">Tanggal Masuk</label>
                        <input type="datetime-local" class="form-control @error('stok_tanggal_masuk') is-invalid @enderror" 
                            id="stok_tanggal_masuk" name="stok_tanggal_masuk"
                            value="{{ old('stok_tanggal_masuk', date('Y-m-d\TH:i', strtotime($stock->stok_tanggal_masuk))) }}">
                        @error('stok_tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="stok_jumlah">Jumlah</label>
                        <input type="number" class="form-control @error('stok_jumlah') is-invalid @enderror" 
                            id="stok_jumlah" name="stok_jumlah"
                            value="{{ old('stok_jumlah', $stock->stok_jumlah) }}" min="1">
                        @error('stok_jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('stock.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection