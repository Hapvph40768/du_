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
            
            <!-- Khách & Booking Dropdown -->
            <a href="#bookingCollapse" class="nav-link d-flex align-items-center justify-content-between @yield('active-booking-group')" data-bs-toggle="collapse" aria-expanded="false">
                <span>
                    <i class="bi bi-people me-2"></i> Khách & Booking
                </span>
                <i class="bi bi-chevron-down" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse ps-3" id="bookingCollapse">
                <nav class="nav flex-column gap-1 mt-1">
                    <a href="{{ route('add-booking') }}" class="nav-link @yield('active-add-booking') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-plus-circle me-2"></i> Tạo Booking
                    </a>
                    <a href="{{ route('list-booking') }}" class="nav-link @yield('active-booking') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-calendar-check me-2"></i> QL Booking
                    </a>
                    <a href="{{ route('list-booking-customer') }}" class="nav-link @yield('active-booking-customer') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-people me-2"></i> Danh sách khách
                    </a>
                    <a href="{{ route('list-customer') }}" class="nav-link @yield('active-customer') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-person-lines-fill me-2"></i> Customer
                    </a>

                     <a href="{{ route('list-attendance') }}" class="nav-link @yield('active-attendance') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-clipboard-check me-2"></i> Điểm danh
                    </a>
                </nav>
            </div>
            
            <a href="{{ route('list-supplier') }}" class="nav-link @yield('active-supplier')">
                <i class="bi bi-building me-2"></i> Đối tác & nhà cung cấp
            </a>
        </nav>
        
        <div class="px-3 mb-2 mt-4">
            <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">CẤU HÌNH</small>
        </div>
        
        <nav class="nav flex-column px-2 gap-1">
            <!-- Dịch vụ Dropdown -->
            <a href="#servicesCollapse" class="nav-link d-flex align-items-center justify-content-between @yield('active-service-group')" data-bs-toggle="collapse" aria-expanded="false">
                <span>
                    <i class="bi bi-geo-alt me-2"></i> Dịch vụ
                </span>
                <i class="bi bi-chevron-down" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse ps-3" id="servicesCollapse">
                <nav class="nav flex-column gap-1 mt-1">
                    <a href="{{ route('list-service') }}" class="nav-link @yield('active-service') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-list-task me-2"></i> QL Dịch vụ
                    </a>
                    <a href="{{ route('list-booking-service') }}" class="nav-link @yield('active-booking-service') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-cart-plus me-2"></i> Dịch vụ Booking
                    </a>
                </nav>
            </div>
            <!-- Yêu cầu Dropdown -->
            <a href="#requestsCollapse" class="nav-link d-flex align-items-center justify-content-between @yield('active-requests-group')" data-bs-toggle="collapse" aria-expanded="false">
                <span>
                    <i class="bi bi-file-earmark-text me-2"></i> Yêu cầu
                </span>
                <i class="bi bi-chevron-down" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse ps-3" id="requestsCollapse">
                <nav class="nav flex-column gap-1 mt-1">
                    <a href="{{ route('list-request') }}" class="nav-link @yield('active-service-request') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-arrow-return-right me-2"></i> Thay đổi dịch vụ
                    </a>
                    <a href="{{ route('list-special-request') }}" class="nav-link @yield('active-special-request') text-white opacity-75" style="font-size: 0.9rem;">
                        <i class="bi bi-arrow-return-right me-2"></i> Yêu cầu đặc biệt
                    </a>
                </nav>
            </div>
            
            <!-- Điều hành Tour Dropdown -->
            <a href="#assignmentCollapse" class="nav-link d-flex align-items-center justify-content-between @yield('active-assignment-group')" data-bs-toggle="collapse" aria-expanded="false">
                <span>
                    <i class="bi bi-person-check me-2"></i> Điều hành Tour
                </span>
                <i class="bi bi-chevron-down" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse ps-3" id="assignmentCollapse">
                <a href="{{ route('list-tour-guide') }}" class="nav-link @yield('active-tour-guide') text-white opacity-75" style="font-size: 0.9rem;">
                    <i class="bi bi-person-plus me-2"></i> Phân công HDV
                </a>
                <a href="{{ route('add-tour-log') }}" class="nav-link @yield('active-add-tour-log') text-white opacity-75" style="font-size: 0.9rem;">
                    <i class="bi bi-pencil-square me-2"></i> Ghi hoạt động
                </a>
                <a href="{{ route('list-tour-logs') }}" class="nav-link @yield('active-tour-log') text-white opacity-75" style="font-size: 0.9rem;">
                    <i class="bi bi-journal-text me-2"></i> Nhật ký hoạt động
                </a>
            </div>
             <a href="{{ route('list-guides') }}" class="nav-link @yield('active-guides')">
                <i class="bi bi-person-badge me-2"></i> Hướng dẫn viên
            </a>
            <a href="{{ route('list-user') }}" class="nav-link @yield('active-user')">
                <i class="bi bi-people-fill me-2"></i> Quản lý người dùng
            </a>
            <a href="{{ route('list-payment') }}" class="nav-link @yield('active-payment')">
                <i class="bi bi-credit-card me-2"></i> Thanh toán
            </a>
            <a href="{{ route('revenue-report') }}" class="nav-link @yield('active-report')">
                <i class="bi bi-graph-up-arrow me-2"></i> Báo cáo doanh thu
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
