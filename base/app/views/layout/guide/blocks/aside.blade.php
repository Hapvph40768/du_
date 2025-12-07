
<div class="sidebar d-flex flex-column p-3">
    <a href="#" class="fs-4 mb-3 text-decoration-none text-white">Guide</a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Attendance --}}
        <li>
            <a href="{{ route('list-guide-attendance') }}" class="@yield('active-guide-attendance')">
                <i class="bi bi-person-badge-fill me-2"></i> Quản lý điểm danh
            </a>
        </li>
    </ul>
</div>
