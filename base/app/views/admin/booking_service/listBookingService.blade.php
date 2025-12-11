@extends('layout.dashboard')
@section('title', 'Danh sách Dịch vụ kèm Booking')
@section('active-service-group', 'active')
@section('active-booking-service', 'active')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h1 class="text-white mb-1">Dịch vụ Booking</h1>
        <p class="text-muted mb-0">Quản lý các dịch vụ đi kèm trong booking.</p>
    </div>
    
    <div class="d-flex gap-3">
        {{-- Stats could go here --}}
    </div>
</div>

{{-- Alerts --}}
@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ $_SESSION['success'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i> Đã xảy ra lỗi
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card-dark p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">Bộ lọc</span>
            <button class="filter-btn active">Tất cả</button>
        </div>
        
        <div class="d-flex gap-3">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                <input type="text" class="search-dark ps-5" placeholder="Tìm dịch vụ, booking...">
            </div>
            <a href="{{ route('add-booking-service') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                <i class="bi bi-plus-lg"></i> Thêm dịch vụ vào Booking
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom w-100">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">Mã Booking</th>
                    <th style="width: 25%;">Dịch vụ</th>
                    <th style="width: 10%;">Số lượng</th>
                    <th style="width: 15%;">Đơn giá</th>
                    <th style="width: 15%;">Tổng</th>
                    <th style="width: 15%;">Ngày tạo</th>
                    <th style="width: 10%; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookingServices as $bs)
                <tr>
                    <td class="text-white-50">{{ $bs->id }}</td>
                    <td>
                        <span class="badge bg-secondary text-white border border-light border-opacity-25">Booking #{{ $bs->booking_id }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $bs->service_name }}</div>
                    </td>
                    <td>
                        <span class="badge bg-info text-dark bg-opacity-75">{{ $bs->quantity }}</span>
                    </td>
                    <td class="text-white-50">
                        {{ number_format($bs->price, 0, ',', '.') }} đ
                    </td>
                    <td class="text-success fw-bold">
                        {{ number_format($bs->price * $bs->quantity, 0, ',', '.') }} đ
                    </td>
                    <td class="text-muted small">
                        {{ date('d/m/Y H:i', strtotime($bs->created_at)) }}
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-white-50" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('detail-booking-service/' . $bs->id) }}"><i class="bi bi-pencil me-2"></i>Sửa</a></li>
                                <li>
                                    <button class="dropdown-item text-danger" onclick="confirmDelete('{{ route('delete-booking-service/' . $bs->id) }}', '{{ $bs->service_name }}')">
                                        <i class="bi bi-trash me-2"></i>Xóa
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Chưa có dịch vụ nào được thêm vào booking</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, serviceName) {
        if (confirm(`Bạn có chắc chắn muốn xóa dịch vụ: ${serviceName}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection
