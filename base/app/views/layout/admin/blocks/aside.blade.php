<div class="sidebar">
    {{-- user --}}
    <a href="{{ route('list-user') }}" class="@yield('active-user')">
        <i class="bi bi-person-fill me-2"></i> Quản lý Tài khoản người dùng
    </a>
    {{-- Tour --}}
    <a href="{{ route('list-tours') }}" class="@yield('active-tour')">
        <i class="bi bi-geo-alt-fill me-2"></i> Quản lý Tour
    </a>
    {{-- departure --}}
    <a href="{{ route('list-departure') }}" class="@yield('active-departure')">
        <i class="bi bi-calendar-event-fill me-2"></i> Quản lý Lịch khởi hành
    </a>
    {{-- itinerary --}}
    <a href="{{ route('list-itinerary') }}" class="@yield('active-itinerary')">
        <i class="bi bi-list-task me-2"></i> Quản lý Lịch trình theo ngày
    </a>
    {{-- booking --}}
    <a href="{{ route('list-booking') }}" class="@yield('active-booking')">
        <i class="bi bi-journal-check me-2"></i> Quản lý Booking
    </a>
    {{-- roles --}}
    <a href="{{ route('list-roles') }}" class="@yield('active-roles')">
        <i class="bi bi-people-fill me-2"></i> Quản lý Vai trò người dùng
    </a>
    <a href="{{ route('list-supplier') }}" class="@yield('active-supplier')">
        <i class="bi bi-people-fill me-2"></i> Quản lý nha cung cap
    </a>
    {{-- services --}}
    <a href="{{ route('list-service') }}" class="@yield('active-service')">
        <i class="bi bi-gear-fill me-2"></i> Quản lý Dịch vụ (Packages)
    </a>
    {{-- service change requests --}}
    <a href="{{ route('list-service-change-requests') }}" class="@yield('active-service-change-request')">
        <i class="bi bi-pencil-square me-2"></i> Yêu cầu thay đổi dịch vụ
    </a>
    {{-- tour images --}}
    <a href="{{ route('list-tour-img') }}" class="@yield('active-tour-img')">
        <i class="bi bi-image-fill me-2"></i> Quản lý Hình ảnh Tour
    </a>
    {{-- tour logs --}}
    <a href="{{ route('list-tour-log') }}" class="@yield('active-tour-log')">
        <i class="bi bi-journal-text me-2"></i> Nhật ký Tour / Logs
    </a>
</div>
