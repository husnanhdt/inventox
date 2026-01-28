<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-boxes"></i>
        </div>
        <div class="sidebar-brand-text mx-3">InventOx</div>
    </a>
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if(auth()->user()?->role === 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Kategori</span>
        </a>
    </li>
    @endif

    <!-- 🔹 Tambahkan proteksi di sini -->
    @if(auth()->user()?->role === 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Barang</span>
        </a>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('stock-in.index') }}">
            <i class="fas fa-fw fa-arrow-down"></i>
            <span>Barang Masuk</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('stock-out.index') }}">
            <i class="fas fa-fw fa-arrow-up"></i>
            <span>Barang Keluar</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>