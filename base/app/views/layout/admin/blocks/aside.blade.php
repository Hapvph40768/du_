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
    <a href="{{ route('list-supplier') }}" class="@yield('active-supplier')">
        <i class="bi bi-people-fill me-2"></i> Quản lý nha cung cap
    </a>
    <a href="{{ route('list-guides') }}" class="@yield('active-guides')">
        <i class="bi bi-people-fill me-2"></i> Quản lý hdv
    </a>
</div>
