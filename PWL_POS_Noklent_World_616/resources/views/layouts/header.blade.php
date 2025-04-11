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
        @if($isLoggedIn)
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span class="d-none d-md-inline">{{ $userData['nama'] }}</span>
                <span class="text-muted mx-1">|</span>
                <span class="badge badge-info">{{ $userData['levelName'] }}</span>
                <span class="badge badge-info">{{ $userData['levelKode'] }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="card-header text-white">
                    <p>
                        {{ $userData['nama'] }}
                        <small>{{ $userData['levelName'] }}</small>
                    </p>
                </li>

                <li class="user-footer">
                    <a href="javascript:void(0)" onclick="confirmLogout()" class="btn btn-danger btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
</nav>
<!-- /.navbar -->