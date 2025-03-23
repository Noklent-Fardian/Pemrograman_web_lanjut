@extends('layouts.template')
@section('content')
<div class="card shadow-lg rounded-lg overflow-hidden">
    <div class="card-header position-relative p-4">
        <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
        <div class="animated-bg"></div>
    </div>
    <div class="card-body p-4">
        @empty($level)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/level/update/' . $level->level_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!}
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Kode Level</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control @error('level_kode') is-invalid @enderror" id="level_kode"
                            name="level_kode" value="{{ old('level_kode', $level->level_kode) }}"
                            placeholder="Masukkan kode level" required>
                        @error('level_kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Nama Level</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control @error('level_nama') is-invalid @enderror" id="level_nama"
                            name="level_nama" value="{{ old('level_nama', $level->level_nama) }}"
                            placeholder="Masukkan nama level" required>
                        @error('level_nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <hr class="my-4">
                <div class="form-group row mb-0">
                    <div class="offset-md-2 col-md-10">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a class="btn btn-back btn-outline-secondary ml-2 px-4" href="{{ url('level') }}">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection
