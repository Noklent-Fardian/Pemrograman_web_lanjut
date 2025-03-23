@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ url('supplier/store') }}" class="form-horizontal">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Kode Supplier</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-hashtag"></i></span>
                            </div>
                            <input type="text" class="form-control @error('supplier_kode') is-invalid @enderror"
                                id="supplier_kode" name="supplier_kode" value="{{ old('supplier_kode') }}"
                                placeholder="Masukkan kode supplier">
                            @error('supplier_kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Contoh: SUP-001, SP001, dll.</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Nama Supplier</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-building"></i></span>
                            </div>
                            <input type="text" class="form-control @error('name_supplier') is-invalid @enderror"
                                id="name_supplier" name="name_supplier" value="{{ old('name_supplier') }}"
                                placeholder="Masukkan nama supplier">
                            @error('name_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Kontak</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control @error('supplier_contact') is-invalid @enderror"
                                id="supplier_contact" name="supplier_contact" value="{{ old('supplier_contact') }}"
                                placeholder="Masukkan nomor kontak">
                            @error('supplier_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Email</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control @error('supplier_email') is-invalid @enderror"
                                id="supplier_email" name="supplier_email" value="{{ old('supplier_email') }}"
                                placeholder="Masukkan email (opsional)">
                            @error('supplier_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Alamat</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-danger text-white"><i
                                        class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <textarea class="form-control @error('supplier_alamat') is-invalid @enderror" id="supplier_alamat"
                                name="supplier_alamat" placeholder="Masukkan alamat (opsional)" rows="3">{{ old('supplier_alamat') }}</textarea>
                            @error('supplier_alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label text-md-right font-weight-bold">Keterangan</label>
                    <div class="col-md-10">
                        <div class="input-group input-group-custom">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-secondary text-white"><i
                                        class="fas fa-sticky-note"></i></span>
                            </div>
                            <textarea class="form-control @error('supplier_keterangan') is-invalid @enderror" id="supplier_keterangan"
                                name="supplier_keterangan" placeholder="Masukkan keterangan tambahan (opsional)" rows="3">{{ old('supplier_keterangan') }}</textarea>
                            @error('supplier_keterangan')
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
                        <a class="btn btn-back btn-outline-secondary ml-2 px-4" href="{{ url('supplier') }}">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
