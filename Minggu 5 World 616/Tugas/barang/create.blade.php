@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ url('barang/store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Kategori</label>
                    <div class="col-md-10">
                        <select class="form-control custom-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                            <option value="">- Pilih Kategori -</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->kategori_id }}"
                                    {{ old('kategori_id') == $item->kategori_id ? 'selected' : '' }}>
                                    {{ $item->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Kode Barang</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" class="form-control @error('barang_kode') is-invalid @enderror"
                                id="barang_kode" name="barang_kode" value="{{ old('barang_kode') }}"
                                placeholder="Masukkan kode barang">
                            @error('barang_kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Nama Barang</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-box"></i></span>
                            </div>
                            <input type="text" class="form-control @error('barang_nama') is-invalid @enderror" id="barang_nama"
                                name="barang_nama" value="{{ old('barang_nama') }}" placeholder="Masukkan nama barang">
                            @error('barang_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Harga Beli</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i class="fas fa-tags"></i></span>
                            </div>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli"
                                name="harga_beli" value="{{ old('harga_beli') }}" placeholder="Masukkan harga beli">
                            @error('harga_beli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Harga Jual</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-danger text-white"><i class="fas fa-tag"></i></span>
                            </div>
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual"
                                name="harga_jual" value="{{ old('harga_jual') }}" placeholder="Masukkan harga jual">
                            @error('harga_jual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted mt-1">Harga jual harus lebih besar atau sama dengan harga beli</small>
                    </div>
                </div>
                <hr class="my-4">
                <div class="form-group row mb-0">
                    <div class="offset-md-2 col-md-10">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a class="btn btn-back btn-outline-secondary ml-2 px-4" href="{{ url('barang') }}">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection