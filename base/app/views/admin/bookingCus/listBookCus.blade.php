@extends('layout.dashboard')
@section('title', 'Danh sách khách trong booking')
@section('active-booking-group', 'active')
@section('active-booking-customer', 'active')

@section('content')


<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0 text-white">Quản lý khách hàng</h5>
        <small class="text-white-50">Quản lý danh sách khách hàng đi kèm trong các booking.</small>
    </div>
    <a href="{{ route('add-booking-customer') . ($booking_id ? '?booking_id=' . $booking_id : '') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Thêm khách hàng
    </a>
</div>

<!-- Filter Form -->
<div class="card mb-3 bg-white bg-opacity-10 border border-white border-opacity-25 filter_form">
    <div class="card-body p-3">
        <form action="" method="GET" class="row g-3 align-items-end">
            @if(isset($booking_id))
                <input type="hidden" name="booking_id" value="{{ $booking_id }}">
            @endif

            <div class="col-md-4">
                <label class="form-label text-white small fw-bold">Chọn Tour</label>
                <select name="filter_tour_id" class="form-select form-select-sm">
                    <option value="">-- Tất cả Tour --</option>
                    @foreach($tours as $t)
                        <option value="{{ $t->id }}" {{ (isset($filter_tour_id) && $filter_tour_id == $t->id) ? 'selected' : '' }}>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-white small fw-bold">Ngày bắt đầu (từ)</label>
                <input type="date" name="filter_start_date" class="form-control form-control-sm" value="{{ $filter_start_date ?? '' }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white small fw-bold">Ngày kết thúc (đến)</label>
                <input type="date" name="filter_end_date" class="form-control form-control-sm" value="{{ $filter_end_date ?? '' }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold">
                    <i class="bi bi-funnel me-1"></i> Lọc
                </button>
            </div>
        </form>
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
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">Bộ lọc</span>
            <button class="filter-btn active">Tất cả</button>
        </div>
        
        <div class="position-relative">
            <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
            <input type="text" class="search-dark ps-5" placeholder="Tìm tên khách...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom w-100">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 15%;">Mã Booking</th>
                    <th style="width: 15%;">Khách đặt</th>
                    <th style="width: 15%;">Thành viên</th>
                    <th style="width: 10%;">SĐT</th>
                    <th style="width: 12%;">CCCD/CMND</th>
                    <th style="width: 8%;">Giới tính</th>
                    <th style="width: 10%;">Ngày sinh</th>
                    <th style="width: 5%;">Ghi chú</th>
                    <th style="width: 5%; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                <tr>
                    <td class="text-white-50">{{ $c->id }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="badge bg-secondary text-white border border-light border-opacity-25 align-self-start mb-1">Booking #{{ $c->booking_id }}</span>
                            <small class="text-white-50">
                                {{ $c->tour_name }} <br>
                                ({{ date('d/m/Y', strtotime($c->start_date)) }} - {{ date('d/m/Y', strtotime($c->end_date)) }})
                            </small>
                        </div>
                    </td>
                    <td class="text-white">{{ $c->customer_name ?? '-' }}</td>
                    <td class="fw-bold text-white">{{ $c->fullname }}</td>
                    <td class="text-white-50">{{ $c->phone ?: '-' }}</td>
                    <td class="text-white-50">{{ $c->id_card ?: '-' }}</td>
                    <td>
                        @if($c->gender == 'male' || $c->gender == 'Nam')
                            <span class="badge bg-info text-dark bg-opacity-75">Nam</span>
                        @elseif($c->gender == 'female' || $c->gender == 'Nu' || $c->gender == 'Nữ')
                            <span class="badge bg-warning text-dark bg-opacity-75">Nữ</span>
                        @else
                            <span class="badge bg-secondary text-white">Khác</span>
                        @endif
                    </td>
                    <td class="text-white-50">{{ $c->dob }}</td>
                    <td class="text-muted small fst-italic">{{ $c->note ?: '-' }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-white-50" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('detail-booking-customer/' . $c->id) }}"><i class="bi bi-pencil me-2"></i>Sửa</a></li>
                                <li>
                                    <button class="dropdown-item text-danger" onclick="confirmDelete('{{ route('delete-booking-customer/' . $c->id) }}', '{{ $c->fullname }}')">
                                        <i class="bi bi-trash me-2"></i>Xóa
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">Chưa có khách nào trong booking này</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, name) {
        if (confirm(`Bạn có chắc chắn muốn xóa khách: ${name}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection
