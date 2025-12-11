<nav class="navbar navbar-expand-lg navbar-light navbar-custom mb-4">
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2">
        <button id="sidebarToggle" class="btn btn-sm btn-outline-light me-2" title="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand text-white" href="#">Welcome, {{ $_SESSION['user']['username'] ?? 'Guide' }}</a>
    </div>

    <div class="d-flex align-items-center gap-2">
        <div class="dropdown">
            <a class="text-white text-decoration-none d-flex align-items-center" href="#" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-4 me-2"></i>
                <span class="d-none d-md-inline">{{ $_SESSION['user']['username'] ?? 'Guide' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Đăng xuất</a></li>
            </ul>
        </div>
    </div>
  </div>
</nav>
