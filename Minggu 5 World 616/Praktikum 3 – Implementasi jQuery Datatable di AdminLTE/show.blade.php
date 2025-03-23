@extends('layouts.template')

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($user)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, pengguna yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $user->nama }}</h4>
                            <span class="badge badge-info px-3 py-2">{{ $user->level->level_nama }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-fingerprint text-primary"></i>
                                        <span>ID Pengguna</span>
                                    </div>
                                    <div class="info-value">{{ $user->user_id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user text-info"></i>
                                        <span>Username</span>
                                    </div>
                                    <div class="info-value">{{ $user->username }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-id-card text-success"></i>
                                        <span>Nama Lengkap</span>
                                    </div>
                                    <div class="info-value">{{ $user->nama }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-layer-group text-warning"></i>
                                        <span>Level</span>
                                    </div>
                                    <div class="info-value">{{ $user->level->level_nama }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-lock text-danger"></i>
                                        <span>Password</span>
                                    </div>
                                    <div class="info-value">••••••••••</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ url('user') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
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
