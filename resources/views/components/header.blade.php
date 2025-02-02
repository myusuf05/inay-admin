<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    @if(auth()->user() != null)
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Halo, {{ auth()->user()->nama }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if (auth()->user()->akses == 'santri')
                <a href="features-profile.html" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="/auth/logout" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
    @else
    <div class="mr-auto">
    </div>
    <div class="navbar-nav navbar-right">
        <a href="/auth" class="font-weight-bold text-white"> Login </i>
    </div>
    @endif
</nav>