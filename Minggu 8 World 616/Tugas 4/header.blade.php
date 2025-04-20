<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @if ($isLoggedIn)
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('img/user/' . ($userData['photo'] ?? 'default.png')) }}"
                        class="user-header-image mr-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ $userData['nama'] }}</span>
                    <span class="text-muted mx-1">|</span>
                    <span class="badge badge-info">{{ $userData['levelName'] }}</span>
                    <span class="badge badge-info">{{ $userData['levelKode'] }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="card-header text-white">
                        <div class="text-center mb-2">
                            <a href="{{ asset('img/user/' . ($userData['photo'] ?? 'default.png')) }}" target="_blank" rel="noopener">
                                <img src="{{ asset('img/user/' . ($userData['photo'] ?? 'default.png')) }}"
                                    class="dropdown-user-image" alt="User Image">
                            </a>
                        </div>
                        <p class="text-center">
                            {{ $userData['nama'] }}
                            <small>{{ $userData['levelName'] }}</small>
                        </p>
                    </li>

                    <li class="user-footer">
                        <a href="{{ url('profile') }}" class="btn btn-info btn-flat float-left">
                            <i class="fas fa-user-cog mr-1"></i> Profile
                        </a>
                        <a href="javascript:void(0)" onclick="confirmLogout()"
                            class="btn btn-danger btn-flat float-right">
                            <i class="fas fa-sign-out-alt mr-1"></i> Sign out
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</nav>
<!-- /.navbar -->
