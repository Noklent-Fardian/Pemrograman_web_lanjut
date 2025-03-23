@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @empty($supplier)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('supplier') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/supplier/update/' . $supplier->supplier_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right font-weight-bold">Kode Supplier</label>
                        <div class="col-md-10">
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-hashtag"></i></span>
                                </div>
                                <input type="text" class="form-control @error('supplier_kode') is-invalid @enderror"
                                    id="supplier_kode" name="supplier_kode"
                                    value="{{ old('supplier_kode', $supplier->supplier_kode) }}"
                                    placeholder="Masukkan kode supplier" required>
                                @error('supplier_kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                                    id="name_supplier" name="name_supplier"
                                    value="{{ old('name_supplier', $supplier->name_supplier) }}"
                                    placeholder="Masukkan nama supplier" required>
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
                                    id="supplier_contact" name="supplier_contact"
                                    value="{{ old('supplier_contact', $supplier->supplier_contact) }}"
                                    placeholder="Masukkan nomor kontak" required>
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
                                    id="supplier_email" name="supplier_email"
                                    value="{{ old('supplier_email', $supplier->supplier_email) }}"
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
                                    name="supplier_alamat" placeholder="Masukkan alamat (opsional)" rows="3">{{ old('supplier_alamat', $supplier->supplier_alamat) }}</textarea>
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
                                    name="supplier_keterangan" placeholder="Masukkan keterangan tambahan (opsional)" rows="3">{{ old('supplier_keterangan', $supplier->supplier_keterangan) }}</textarea>
                                @error('supplier_keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-right font-weight-bold">Status</label>
                        <div class="col-md-10">
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-secondary text-white"><i
                                            class="fas fa-toggle-on"></i></span>
                                </div>
                                <select class="form-control @error('supplier_status') is-invalid @enderror" id="supplier_status"
                                name="supplier_status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value='1' {{ old('supplier_status', $supplier->supplier_aktif) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value='0' {{ old('supplier_status', $supplier->supplier_aktif) == 0 ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>
                                @error('supplier_status')
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
            @endempty
        </div>
    </div>
@endsection
