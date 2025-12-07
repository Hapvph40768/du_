<div class="sidebar d-flex flex-column h-100">
    <!-- Brand -->
    <div class="brand p-3 d-flex align-items-center gap-2">
        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
            <i class="bi bi-globe"></i>
        </div>
        <div class="d-flex flex-column">
            <span class="text-primary fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Admin</span>
            <span class="text-white fw-bold">Quản lý tour</span>
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-content flex-grow-1 overflow-auto py-2">
        <div class="px-3 mb-2 mt-2">
            <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">ĐIỀU HƯỚNG</small>
        </div>
        
        <nav class="nav flex-column px-2 gap-1">
            <a href="{{ route('list-tours') }}" class="nav-link @yield('active-tours')">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard tour
                <span class="badge bg-secondary ms-auto text-dark bg-opacity-10" style="font-size: 0.6rem;">Trực tiếp</span>
            </a>
            
            <a href="{{ route('list-departure') }}" class="nav-link @yield('active-departure')">
                <i class="bi bi-calendar-event me-2"></i> Lịch khởi hành
            </a>
            
            <a href="{{ route('list-booking') }}" class="nav-link @yield('active-booking')">
                <i class="bi bi-people me-2"></i> Khách & booking
            </a>
            
            <a href="{{ route('list-supplier') }}" class="nav-link @yield('active-supplier')">
                <i class="bi bi-building me-2"></i> Đối tác & nhà cung cấp
            </a>
        </nav>
        
        <div class="px-3 mb-2 mt-4">
            <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">CẤU HÌNH</small>
        </div>
        
        <nav class="nav flex-column px-2 gap-1">
            <a href="{{ route('list-service') }}" class="nav-link @yield('active-service')">
                <i class="bi bi-geo-alt me-2"></i> Điểm đến & tuyến
            </a>
             <a href="#" class="nav-link">
                <i class="bi bi-tag me-2"></i> Giá & khuyến mãi
            </a>
             <a href="{{ route('list-guides') }}" class="nav-link @yield('active-guides')">
                <i class="bi bi-person-badge me-2"></i> Hướng dẫn viên
            </a>
        </nav>
    </div>

    <!-- User Profile (Bottom) -->
    <div class="mt-auto p-3 border-top border-secondary border-opacity-10">
        <div class="user-block d-flex align-items-center gap-3 p-2 bg-white bg-opacity-10 rounded-3">
            <div class="avatar-container position-relative">
                <img src="/public/img/avatar.png" alt="Admin" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                <span class="position-absolute bottom-0 end-0 bg-success border border-dark rounded-circle" style="width: 10px; height: 10px;"></span>
            </div>
            <div class="d-flex flex-column flex-grow-1" style="min-width: 0;">
                <span class="text-white fw-bold text-truncate">Quản trị viên</span>
                <small class="text-muted text-truncate">admin@travel.com</small>
            </div>
            <a href="{{ route('logout') }}" class="btn btn-sm btn-dark text-white p-1" title="Đăng xuất">
               <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
