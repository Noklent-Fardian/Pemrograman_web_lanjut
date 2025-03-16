@extends('layouts.app')

@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Create')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah User Baru</h3>
            </div>
            <form method="post" action="{{ url('/user/tambah_simpan') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                            value="{{ old('username') }}" placeholder="Masukkan username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                            value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                            placeholder="Masukkan password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="level_id">Level</label>
                        <select class="form-control @error('level_id') is-invalid @enderror" id="level_id" name="level_id">
                            <option value="">Pilih Level</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                    {{ $level->level_nama }} ({{ $level->level_kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection