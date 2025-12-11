@extends('layout.dashboard')
@section('title', 'Danh sách Điểm Danh')
@section('active-booking-group', 'active')
@section('active-attendance', 'active')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h1 class="text-white mb-1">Điểm danh (Attendance)</h1>
        <p class="text-muted mb-0">Quản lý trạng thái tham gia của khách hàng theo lịch khởi hành.</p>
    </div>
    <a href="{{ route('add-attendance') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
        <i class="bi bi-plus-lg"></i> Thêm mới
    </a>
</div>

@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ $_SESSION['success'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i> 
        @if(is_array($_SESSION['errors']))
            <ul class="mb-0 ps-3">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @else
            {{ $_SESSION['errors'] }}
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card-dark p-3 mb-4">
    <form action="{{ route('list-attendance') }}" method="GET" class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">Bộ lọc</span>
            
            {{-- Status Filters (Links ensuring date & tour params are kept) --}}
            @php
                $queryParams = [];
                if(isset($start_date)) $queryParams['start_date'] = $start_date;
                if(isset($end_date)) $queryParams['end_date'] = $end_date;
                if(isset($tour_id)) $queryParams['tour_id'] = $tour_id;
                
                $linkAll = route('list-attendance') . (count($queryParams) ? '?' . http_build_query($queryParams) : '');
                
                $paramsPresent = $queryParams; $paramsPresent['status'] = 'present';
                $linkPresent = route('list-attendance') . '?' . http_build_query($paramsPresent);

                $paramsAbsent = $queryParams; $paramsAbsent['status'] = 'absent';
                $linkAbsent = route('list-attendance') . '?' . http_build_query($paramsAbsent);
            @endphp

            <a href="{{ $linkAll }}" class="filter-btn text-decoration-none {{ !$currentStatus ? 'active' : '' }}">Tất cả</a>
            <a href="{{ $linkPresent }}" class="filter-btn text-decoration-none {{ $currentStatus === 'present' ? 'active' : '' }}">Có mặt</a>
            <a href="{{ $linkAbsent }}" class="filter-btn text-decoration-none {{ $currentStatus === 'absent' ? 'active' : '' }}">Vắng</a>
        </div>

        {{-- Date Range & Search --}}
        <div class="d-flex gap-2">
            @if($currentStatus)
                <input type="hidden" name="status" value="{{ $currentStatus }}">
            @endif
            
            <select name="tour_id" class="form-select bg-dark text-white border-secondary" style="border-color: rgba(255,255,255,0.1); max-width: 200px;">
                <option value="">-- Chọn Tour --</option>
                @foreach($tours as $t)
                    <option value="{{ $t->id }}" {{ (isset($tour_id) && $tour_id == $t->id) ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>

            <input type="date" name="start_date" value="{{ $start_date ?? '' }}" class="form-control bg-dark text-white border-secondary" style="border-color: rgba(255,255,255,0.1);">
            <input type="date" name="end_date" value="{{ $end_date ?? '' }}" class="form-control bg-dark text-white border-secondary" style="border-color: rgba(255,255,255,0.1);">
            
            <button type="submit" class="btn btn-secondary"><i class="bi bi-filter"></i></button>

            <div class="position-relative ms-2">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                <input type="text" name="keyword" class="search-dark ps-5" placeholder="Tìm kiếm..." value="{{ $_GET['keyword'] ?? '' }}">
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-dark-custom w-100">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 20%;">Tour / Lịch khởi hành</th>
                    <th style="width: 20%;">Khách hàng</th>

                    <th style="width: 15%;">Thành viên</th>
                    <th style="width: 10%;">Trạng thái</th>
                    <th style="width: 15%;">Check-in</th>
                    <th style="width: 10%;">Ghi chú</th>
                    <th style="width: 5%; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $a)
                <tr>
                    <td class="text-white-50">{{ $a->booking_customer_id }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-white">{{ $a->tour_name }}</span>
                            <span class="small text-muted">
                                @php
                                    $sDate = $a->start_date ?? ($a->booking_start_date ?? null);
                                    $eDate = $a->end_date ?? ($a->booking_end_date ?? null);
                                @endphp
                                {{ !empty($sDate) ? date('d/m/Y', strtotime($sDate)) : 'N/A' }} 
                                <i class="bi bi-arrow-right mx-1"></i> 
                                {{ !empty($eDate) ? date('d/m/Y', strtotime($eDate)) : 'N/A' }}
                            </span>
                        </div>
                    </td>

                    <td class="text-white">
                        <div class="fw-bold">{{ $a->customer_name }}</div>
                        <div class="small text-muted">Booking: #{{ $a->booking_id }}</div>
                    </td>
                    <td class="text-white-50">{{ $a->booking_customer_name }}</td>
                    <td>
                        @if($a->status === 'present')
                            <span class="badge bg-success bg-opacity-75">Có mặt</span>
                        @elseif($a->status === 'absent')
                            <span class="badge bg-danger bg-opacity-75">Vắng</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-50">Chưa điểm danh</span>
                        @endif
                    </td>
                    <td class="text-white-50">{{ (!empty($a->checkin_time)) ? date('H:i d/m/Y', strtotime($a->checkin_time)) : '---' }}</td>
                    <td class="text-muted small fst-italic">{{ $a->note ?: '-' }}</td>
                    <td class="text-center">
                        @if($a->id)
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-white-50" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="{{ route('detail-attendance/' . $a->id) }}"><i class="bi bi-pencil me-2"></i>Sửa</a></li>
                                    <li>
                                        <button class="dropdown-item text-danger" onclick="confirmDelete('{{ route('delete-attendance/' . $a->id) }}')">
                                            <i class="bi bi-trash me-2"></i>Xóa
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('detail-attendance') }}?departure_id={{ $a->departure_id }}&booking_customer_id={{ $a->booking_customer_id }}&customer_id={{ $a->customer_id }}" 
                               class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-check-circle me-1"></i> Điểm danh
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        if (confirm('Bạn có chắc chắn muốn xóa mục này?')) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection
