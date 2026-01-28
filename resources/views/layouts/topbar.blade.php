<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        @if(auth()->check())
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->nama }}</span>
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                    @csrf
                </form>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
        @else
        <li class="nav-item">
            <span class="nav-link">Guest</span>
        </li>
        @endif
    </ul>
</nav>