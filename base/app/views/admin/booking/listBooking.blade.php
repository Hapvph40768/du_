@extends('layout.dashboard')
@section('title', 'Quản lý Booking')
@section('active-booking', 'active')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h1 class="text-white mb-1">Quản lý Booking</h1>
        <p class="text-muted mb-0">Xem và xử lý các đơn đặt tour từ khách hàng.</p>
    </div>
    
    {{-- Stats Calculation (Simple view logic) --}}
    @php
        $totalBookings = count($bookings);
        $totalRevenue = 0;
        $pendingCount = 0;
        foreach($bookings as $b) {
            $totalRevenue += $b->total_price;
            if($b->status == 'pending') $pendingCount++;
        }
    @endphp

    <div class="d-flex gap-3">
        <div class="stats-mini-card">
            <div class="label">Tổng Booking</div>
            <div class="value text-white text-center">{{ $totalBookings }}</div>
        </div>
        <div class="stats-mini-card">
            <div class="label">Chờ xử lý</div>
            <div class="value text-warning text-center">{{ $pendingCount }}</div>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert" style="background: rgba(34, 197, 94, 0.2); border: 1px solid var(--success); color: #fff;">
        <i class="bi bi-check-circle me-2"></i> {{ $_SESSION['success'] }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert" style="background: rgba(239, 68, 68, 0.2); border: 1px solid var(--danger); color: #fff;">
        <i class="bi bi-exclamation-circle me-2"></i> Đã xảy ra lỗi
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card-dark p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">Bộ lọc</span>
            <button class="filter-btn active">Tất cả</button>
            <button class="filter-btn">Chờ xử lý</button>
            <button class="filter-btn">Đã xác nhận</button>
        </div>
        
        <div class="d-flex gap-3">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                <input type="text" class="search-dark ps-5" placeholder="Tìm tên khách hoặc mã...">
            </div>
            <a href="{{ route('add-booking') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                <i class="bi bi-plus-lg"></i> Tạo Booking
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom w-100">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 20%;">Khách hàng</th>
                    <th style="width: 20%;">Tour / Ngày đi</th>
                    <th style="width: 10%;">Số khách</th>
                    <th style="width: 15%;">Thanh toán</th>
                    <th style="width: 15%;">Trạng thái</th>
                    <th style="width: 15%; text-align: right;">Tổng tiền</th>
                    <th style="width: 10%; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $index => $b)
                <tr>
                    <td class="text-white-50">{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $b->customer_name }}</div>
                    </td>
                    <td>
                        <div class="text-white small mb-1" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $b->tour_name }}</div>
                        <div class="text-white-50 small"><i class="bi bi-calendar3 me-1"></i>{{ date('d/m/Y', strtotime($b->start_date)) }}</div>
                    </td>
                    <td>
                        <span class="badge bg-secondary text-white">{{ $b->num_people }} người</span>
                    </td>
                    <td>
                        @switch($b->payment_status)
                            @case('unpaid')
                                <span class="badge bg-danger text-white">Chưa thanh toán</span>
                                @break
                            @case('partial')
                                <span class="badge bg-warning text-dark">Đặt cọc</span>
                                @break
                            @case('paid')
                                <span class="badge bg-success text-white">Đã thanh toán</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        @switch($b->status)
                            @case('pending')
                                <span class="dot-status dot-warning"></span> <span class="text-white-50 small">Chờ xác nhận</span>
                                @break
                            @case('confirmed')
                                <span class="dot-status dot-success"></span> <span class="text-success small">Đã xác nhận</span>
                                @break
                            @case('cancelled')
                                <span class="dot-status dot-danger"></span> <span class="text-danger small">Đã hủy</span>
                                @break
                            @case('completed')
                                <span class="dot-status dot-success"></span> <span class="text-success small">Hoàn thành</span>
                                @break
                        @endswitch
                    </td>
                    <td class="text-end fw-bold" style="color: #fff !important;">
                        {{ number_format($b->total_price, 0, ',', '.') }} đ
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-white-50" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('detail-booking/'.$b->id) }}"><i class="bi bi-pencil me-2"></i>Sửa</a></li>
                                <li>
                                    <button class="dropdown-item text-danger" onclick="confirmDelete('{{ route('delete-booking/'.$b->id) }}')">
                                        <i class="bi bi-trash me-2"></i>Xóa
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Chưa có booking nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(url) {
        if (confirm("Bạn có chắc muốn xóa booking này không?")) {
            window.location.href = url;
        }
    }
</script>
@endsection
