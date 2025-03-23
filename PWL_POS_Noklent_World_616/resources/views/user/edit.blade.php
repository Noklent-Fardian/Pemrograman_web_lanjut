@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($user)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/user/update/' . $user->user_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right font-weight-bold">Level User</label>
                        <div class="col-md-10">
                            <select class="form-control custom-select @error('level_id') is-invalid @enderror" id="level_id" name="level_id" required>
                                <option value="">- Pilih Level -</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->level_id }}" @if ($item->level_id == $user->level_id) selected @endif>
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
                                    id="username" name="username" value="{{ old('username', $user->username) }}"
                                    placeholder="Masukkan username" required>
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
                                    name="nama" value="{{ old('nama', $user->nama) }}" placeholder="Masukkan nama lengkap" required>
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
                                    id="password" name="password" placeholder="Masukkan password baru">
                                <div class="input-group-append">
                                    <span class="input-group-text password-toggle" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <small class="form-text text-muted mt-1">Abaikan jika tidak ingin mengganti password.</small>
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
                            <a class="btn btn-back btn-outline-secondary ml-2 px-4" href="{{ url('user') }}">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('js')
   
@endpush