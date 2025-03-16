@extends('layouts.app')

@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Level</h3>
            </div>
            <form method="post" action="{{ url('/level/ubah_simpan/' . $level->level_id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="levelKode">Kode Level</label>
                        <input type="text" class="form-control @error('level_kode') is-invalid @enderror" id="level_kode" name="level_kode"
                            value="{{ $level->level_kode }}" placeholder="Masukkan kode level">
                        @error('level_kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="levelNama">Nama Level</label>
                        <input type="text" class="form-control @error('level_nama') is-invalid @enderror" id="level_nama" name="level_nama"
                            value="{{ $level->level_nama }}" placeholder="Masukkan nama level">
                        @error('level_nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection