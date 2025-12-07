
<div class="sidebar d-flex flex-column p-3">
    <a href="#" class="fs-4 mb-3 text-decoration-none text-white">Admin Dashboard</a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Tour --}}

        <li class="nav-item">
            <a href="{{ route('list-tours') }}" class="@yield('active-tour')">
                <i class="bi bi-map-fill me-2"></i> Quản lý Tour
            </a>
        </li>
        {{-- Departure --}}

        <li>
            <a href="{{ route('list-departure') }}" class="@yield('active-departure')">
                <i class="bi bi-calendar-check-fill me-2"></i> Quản lý Lịch khởi hành
            </a>
        </li>

        {{-- Itinerary --}}
        <li>
            <a href="{{ route('list-itinerary') }}" class="@yield('active-itinerary')">
                <i class="bi bi-list-ul me-2"></i> Quản lý Lịch trình theo ngày
            </a>
        </li>

        {{-- Booking --}}
        <li>
            <a href="{{ route('list-booking') }}" class="@yield('active-booking')">
                <i class="bi bi-journal-bookmark-fill me-2"></i> Quản lý Booking
            </a>
        </li>

        {{-- Booking Customer --}}

        <li>
            <a href="{{ route('list-booking-customer') }}" class="@yield('active-booking-customer')">
                <i class="bi bi-people-fill me-2"></i> Khách Booking
            </a>
        </li>

        {{-- Booking Service --}}
        <li>
            <a href="{{ route('list-booking-service') }}" class="@yield('active-booking-service')">
                <i class="bi bi-bag-check-fill me-2"></i> Dịch vụ kèm theo Booking
            </a>
        </li>

        {{-- Service --}}
        <li>
            <a href="{{ route('list-service') }}" class="@yield('active-service')">
                <i class="bi bi-tools me-2"></i> Quản lý Dịch vụ
            </a>
        </li>

        {{-- Service Change Request --}}
        <li>
            <a href="{{ route('list-request') }}" class="@yield('active-request')">
                <i class="bi bi-arrow-repeat me-2"></i> Yêu cầu thay đổi dịch vụ
            </a>
        </li>

        {{-- Special Request --}}
        <li>
            <a href="{{ route('list-special-request') }}" class="@yield('active-special-request')">
                <i class="bi bi-star-fill me-2"></i> Yêu cầu đặc biệt
            </a>
        </li>

        {{-- Payment --}}
        <li>
            <a href="{{ route('list-payment') }}" class="@yield('active-payment')">
                <i class="bi bi-credit-card-2-front-fill me-2"></i> Quản lý Thanh toán
            </a>
        </li>

        {{-- Customer --}}
        <li>
            <a href="{{ route('list-customer') }}" class="@yield('active-customer')">
                <i class="bi bi-person-lines-fill me-2"></i> Quản lý Khách hàng
            </a>
        </li>

        {{-- Supplier --}}
        <li>
            <a href="{{ route('list-supplier') }}" class="@yield('active-supplier')">
                <i class="bi bi-building-fill me-2"></i> Quản lý Nhà cung cấp
            </a>
        </li>

        {{-- Guide --}}
        <li>
            <a href="{{ route('list-guides') }}" class="@yield('active-guides')">
                <i class="bi bi-person-badge-fill me-2"></i> Quản lý Hướng dẫn viên
            </a>
        </li>

        {{-- Guide --}}
        <li>
            <a href="{{ route('list-attendance') }}" class="@yield('active-attendance')">
                <i class="bi bi-person-badge-fill me-2"></i> Quản lý điểm danh
            </a>
        </li>
    </ul>
</div>
