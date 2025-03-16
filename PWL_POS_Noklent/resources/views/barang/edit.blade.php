@extends('layouts.app')

@section('subtitle', 'Barang')
@section('content_header_title', 'Barang')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Barang</h3>
            </div>
            <form method="post" action="{{ route('barang.update', $barang->barang_id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->kategori_nama }} ({{ $kategori->kategori_kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="barang_kode">Kode Barang</label>
                        <input type="text" class="form-control @error('barang_kode') is-invalid @enderror" id="barang_kode" name="barang_kode"
                            value="{{ old('barang_kode', $barang->barang_kode) }}" placeholder="Masukkan kode barang">
                        @error('barang_kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="barang_nama">Nama Barang</label>
                        <input type="text" class="form-control @error('barang_nama') is-invalid @enderror" id="barang_nama" name="barang_nama"
                            value="{{ old('barang_nama', $barang->barang_nama) }}" placeholder="Masukkan nama barang">
                        @error('barang_nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli"
                                value="{{ old('harga_beli', $barang->harga_beli) }}" placeholder="Masukkan harga beli">
                        </div>
                        @error('harga_beli')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual"
                                value="{{ old('harga_jual', $barang->harga_jual) }}" placeholder="Masukkan harga jual">
                        </div>
                        @error('harga_jual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection