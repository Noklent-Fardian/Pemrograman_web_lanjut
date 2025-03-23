@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($supplier)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, supplier yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar">
                                    <i class="fas fa-truck"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $supplier->name_supplier }}</h4>
                            <span class="badge badge-info px-3 py-2">{{ $supplier->supplier_kode }}</span>
                            <div class="mt-2">
                                @if($supplier->supplier_aktif)
                                    <span class="badge badge-success px-3 py-2">Aktif</span>
                                @else
                                    <span class="badge badge-danger px-3 py-2">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Supplier</span>
                                    </div>
                                    <div class="info-value">{{ $supplier->supplier_id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-tag text-info"></i>
                                        <span>Kode Supplier</span>
                                    </div>
                                    <div class="info-value">{{ $supplier->supplier_kode }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building text-success"></i>
                                        <span>Nama Supplier</span>
                                    </div>
                                    <div class="info-value">{{ $supplier->name_supplier }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone text-warning"></i>
                                        <span>Kontak</span>
                                    </div>
                                    <div class="info-value">{{ $supplier->supplier_contact }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-envelope text-danger"></i>
                                        <span>Email</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $supplier->supplier_email ?? '-' }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-map-marker-alt text-secondary"></i>
                                        <span>Alamat</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $supplier->supplier_alamat ?? '-' }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-clipboard text-purple"></i>
                                        <span>Keterangan</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $supplier->supplier_keterangan ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ url('supplier') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
                @if(!empty($supplier))
                <div>
                    <a href="{{ url('supplier/edit/' . $supplier->supplier_id) }}" class="btn btn-warning px-4 mr-2">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <form method="POST" action="{{ url('supplier/delete/' . $supplier->supplier_id) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Add animation to elements when page loads
            $('.user-detail-container').css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });
            
            setTimeout(function() {
                $('.user-detail-container').css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.6s ease-out'
                });
            }, 200);
        });
    </script>
@endpush