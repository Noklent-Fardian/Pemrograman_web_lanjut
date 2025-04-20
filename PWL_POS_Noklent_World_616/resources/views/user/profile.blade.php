@extends('layouts.template')

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Profil dan photo -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-user-circle mr-2"></i>Profil Pengguna</h5>
                </div>
                <div class="card-body text-center">
                    <div class="profile-image-container mb-4">
                        <img src="{{ asset('img/user/' . ($user->photo ?? 'default.png')) }}" alt="{{ $user->nama }}" 
                             class="img-fluid rounded-circle user-profile-image" id="profileImage">
                        <div class="image-overlay" id="uploadTrigger">
                            <i class="fas fa-camera"></i>
                            <span>Ubah</span>
                        </div>
                    </div>

                    <h4 class="font-weight-bold">{{ $user->nama }}</h4>
                    <p class="text-muted">{{ $user->username }}</p>
                    <div class="badge badge-info mb-3">{{ $user->level->level_nama }}</div>

                    <form id="Form" action="{{ route('updatePhoto') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" name="photo" id="Input" accept="image/jpeg,image/png,image/jpg">
                    </form>
                    
                    <div class="user-info-card mt-4">
                        <div class="user-info-item">
                            <div class="info-label">
                                <i class="fas fa-user-tag text-primary"></i> Username
                            </div>
                            <div class="info-value">{{ $user->username }}</div>
                        </div>
                        <div class="user-info-item">
                            <div class="info-label">
                                <i class="fas fa-id-badge text-success"></i> Level
                            </div>
                            <div class="info-value">{{ $user->level->level_nama }}</div>
                        </div>
                        <div class="user-info-item">
                            <div class="info-label">
                                <i class="fas fa-code text-warning"></i> Kode Level
                            </div>
                            <div class="info-value">{{ $user->level->level_kode }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ubah Password -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-key mr-2"></i>Ubah Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('updatePassword') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn password-toggle" tabindex="-1" onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-success text-white"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn password-toggle" tabindex="-1" onclick="togglePassword('new_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <div class="input-group input-group-custom">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white"><i class="fas fa-check-double"></i></span>
                                </div>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn password-toggle" tabindex="-1" onclick="togglePassword('new_password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mt-4">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-shield-alt mr-2"></i>Tips Keamanan</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb mr-2"></i>Rekomendasi Password yang Kuat:</h6>
                        <ul class="mb-0 mt-2">
                            <li>Minimal 6 karakter</li>
                            <li>Kombinasi huruf besar dan kecil</li>
                            <li>Tambahkan angka dan simbol</li>
                            <li>Hindari informasi pribadi yang mudah ditebak</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
   
    document.getElementById('uploadTrigger').addEventListener('click', function() {
        document.getElementById('Input').click();
    });
    
  
    document.getElementById('Input').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
            
            document.getElementById('Form').submit();
        }
    });
    
  
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = event.currentTarget.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush