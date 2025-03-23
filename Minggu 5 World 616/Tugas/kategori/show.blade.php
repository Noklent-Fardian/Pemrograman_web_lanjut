@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($kategori)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, kategori yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar">
                                    <i class="fas fa-tags"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $kategori->kategori_nama }}</h4>
                            <span class="badge badge-info px-3 py-2">{{ $kategori->kategori_kode }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Kategori</span>
                                    </div>
                                    <div class="info-value">{{ $kategori->kategori_id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-tag text-info"></i>
                                        <span>Kode Kategori</span>
                                    </div>
                                    <div class="info-value">{{ $kategori->kategori_kode }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-bookmark text-success"></i>
                                        <span>Nama Kategori</span>
                                    </div>
                                    <div class="info-value">{{ $kategori->kategori_nama }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-boxes text-warning"></i>
                                        <span>Jumlah Barang</span>
                                    </div>
                                    <div class="info-value">{{ count($kategori->barangs) }} barang</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ url('kategori') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
                @if(!empty($kategori))
                <div>
                    <a href="{{ url('kategori/edit/' . $kategori->kategori_id) }}" class="btn btn-warning px-4 mr-2">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <form method="POST" action="{{ url('kategori/delete/' . $kategori->kategori_id) }}" style="display: inline-block;">
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