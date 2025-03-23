@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ url('user/store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Level User</label>
                    <div class="col-md-10">
                        <select class="form-control custom-select @error('level_id') is-invalid @enderror" id="level_id" name="level_id">
                            <option value="">- Pilih Level -</option>
                            @foreach ($level as $item)
                                <option value="{{ $item->level_id }}"
                                    {{ old('level_id') == $item->level_id ? 'selected' : '' }}>
                                    {{ $item->level_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Username</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username') }}"
                                placeholder="Masukkan username">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Nama Lengkap</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Password</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-danger text-white"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Masukkan password">
                            <div class="input-group-append">
                                <span class="input-group-text password-toggle" style="cursor: pointer;">
                                    <i class="fas fa-eye-slash" id="togglePassword"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted mt-1">Password minimal 5 karakter</small>
                    </div>
                </div>
                <hr class="my-4">
                <div class="form-group row mb-0">
                    <div class="offset-md-2 col-md-10">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a class="btn btn-back btn-outline-secondary ml-2 px-4" href="{{ url('user') }}">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')

@endpush

@push('js')
    
@endpush