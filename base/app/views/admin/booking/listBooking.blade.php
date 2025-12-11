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
@if(isset($_SESSION['success']) && isset($_GET['msg']) && $_GET['msg'] == 'success')
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ $_SESSION['success'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @php unset($_SESSION['success']); @endphp
@endif

@if(isset($_SESSION['errors']) && isset($_GET['msg']) && $_GET['msg'] == 'errors')
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i> 
        @if(is_array($_SESSION['errors']))
            <ul class="mb-0 ps-3">
                @foreach($_SESSION['errors'] as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        @else
            {{ $_SESSION['errors'] }}
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @php unset($_SESSION['errors']); @endphp
@endif

<div class="card border-0 shadow-sm p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">Bộ lọc</span>
            <a href="{{ route('list-booking') }}" class="filter-btn {{ !isset($currentStatus) ? 'active' : '' }}">Tất cả</a>
            <a href="{{ route('list-booking') }}?status=pending" class="filter-btn {{ (isset($currentStatus) && $currentStatus == 'pending') ? 'active' : '' }}">Chờ xử lý</a>
            <a href="{{ route('list-booking') }}?status=confirmed" class="filter-btn {{ (isset($currentStatus) && $currentStatus == 'confirmed') ? 'active' : '' }}">Đã xác nhận</a>
        </div>
        
        <div class="d-flex gap-3">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                <input type="text" class="form-control rounded-pill ps-5" placeholder="Tìm tên khách hoặc mã...">
            </div>
            <a href="{{ route('add-booking') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                <i class="bi bi-plus-lg"></i> Tạo Booking
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle w-100">
            <thead class="table-light text-secondary">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">Khách hàng</th>
                    <th style="width: 20%;">Tour / Ngày đi</th>
                    <th style="width: 10%;">Vị trí đón</th>
                    <th style="width: 10%;">Thời gian</th>
                    <th style="width: 15%;">Dịch vụ</th>
                    <th style="width: 10%;">Số khách</th>
                    <th style="width: 10%;">Thanh toán</th>
                    <th style="width: 10%;">Trạng thái</th>
                    <th style="width: 10%; text-align: right;">Tổng tiền</th>
                    <th style="width: 5%; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $index => $b)
                <tr onclick="window.location.href='{{ route('view-booking/'.$b->id) }}'" style="cursor: pointer;">
                    <td class="text-secondary">{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-bold text-dark">{{ $b->fullname }}</div>
                        <div class="text-muted small">{{ $b->phone }}</div>
                    </td>
                    <td>
                        <div class="text-dark small mb-1 fw-medium" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $b->tour_name }}</div>
                        <div class="text-secondary small"><i class="bi bi-calendar3 me-1"></i>{{ isset($b->start_date) ? date('d/m/Y', strtotime($b->start_date)) : '' }}</div>
                    </td>
                    <td>
                        <div class="text-dark small text-truncate" style="max-width: 150px;" title="{{ $b->pickup_location }}">{{ $b->pickup_location ?? '-' }}</div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border fw-normal">
                            {{ $b->days ?? 1 }} ngày
                        </span>
                    </td>
                    <td>
                        @if(!empty($b->service_names))
                            <div class="badge bg-light text-dark border mb-1 fw-normal text-wrap" style="max-width: 150px;">{{ $b->service_names }}</div>
                        @else
                            <span class="text-muted small fst-italic">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $b->num_people }} người</span>
                    </td>
                    <td>
                        @switch($b->payment_status)
                            @case('unpaid')
                                <span class="badge bg-danger bg-opacity-10 text-danger">Chưa thanh toán</span>
                                @break
                            @case('partial')
                                <span class="badge bg-warning bg-opacity-10 text-warning">Đặt cọc</span>
                                @break
                            @case('paid')
                                <span class="badge bg-success bg-opacity-10 text-success">Đã thanh toán</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        @switch($b->status)
                            @case('pending')
                                <div class="d-flex align-items-center text-nowrap">
                                    <span class="dot-status bg-warning me-2" style="width: 8px; height: 8px; border-radius: 50%;"></span> 
                                    <span class="text-dark small">Chờ xác nhận</span>
                                </div>
                                @break
                            @case('confirmed')
                                <div class="d-flex align-items-center text-nowrap">
                                    <span class="dot-status bg-success me-2" style="width: 8px; height: 8px; border-radius: 50%;"></span>
                                    <span class="text-success small fw-bold">Đã xác nhận</span>
                                </div>
                                @break
                            @case('cancelled')
                                <div class="d-flex align-items-center text-nowrap">
                                    <span class="dot-status bg-danger me-2" style="width: 8px; height: 8px; border-radius: 50%;"></span>
                                    <span class="text-danger small">Đã hủy</span>
                                </div>
                                @break
                            @case('completed')
                                <div class="d-flex align-items-center text-nowrap">
                                    <span class="dot-status bg-success me-2" style="width: 8px; height: 8px; border-radius: 50%;"></span>
                                    <span class="text-success small">Hoàn thành</span>
                                </div>
                                @break
                        @endswitch
                    </td>
                    <td class="text-end fw-bold text-primary">
                        {{ number_format($b->total_price, 0, ',', '.') }} đ
                    </td>
                    <td class="text-center" onclick="event.stopPropagation()">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical text-muted"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('detail-booking/'.$b->id) }}"><i class="bi bi-pencil me-2 text-info"></i>Sửa</a></li>
                                <li><a class="dropdown-item" href="{{ route('view-booking/'.$b->id) }}"><i class="bi bi-eye me-2 text-primary"></i>Xem chi tiết</a></li>
                                <li><a class="dropdown-item" href="{{ route('list-booking-customer') }}?booking_id={{ $b->id }}"><i class="bi bi-person-lines-fill me-2 text-secondary"></i>Xem khách</a></li>
                                <li><hr class="dropdown-divider"></li>
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
                    <td colspan="10" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                        Chưa có booking nào
                    </td>
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
