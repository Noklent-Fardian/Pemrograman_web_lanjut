@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ url('kategori/store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Kode Kategori</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-tag"></i></span>
                            </div>
                            <input type="text" class="form-control @error('kategori_kode') is-invalid @enderror" id="kategori_kode" name="kategori_kode" value="{{ old('kategori_kode') }}" placeholder="Masukkan kode kategori" required>
                            @error('kategori_kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Nama Kategori</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-bookmark"></i></span>
                            </div>
                            <input type="text" class="form-control @error('kategori_nama') is-invalid @enderror" id="kategori_nama" name="kategori_nama" value="{{ old('kategori_nama') }}" placeholder="Masukkan nama kategori" required>
                            @error('kategori_nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="form-group row mb-0">
                    <div class="offset-md-2 col-md-10">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a class="btn btn-back btn-outline-secondary ml-2 px-4" href="{{ url('kategori') }}">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection