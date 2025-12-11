@extends('layout.dashboard')
@section('title', 'Thêm Attendance')
@section('active-booking-group', 'active')
@section('active-attendance', 'active')

@section('content')
<div class="page-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            @if(isset($_GET['booking_customer_id']) || isset($_GET['customer_id']))
                <h1 class="text-white mb-1">Cập nhật Điểm Danh</h1>
                <p class="text-muted mb-0">Cập nhật trạng thái tham gia của khách hàng.</p>
            @else
                <h1 class="text-white mb-1">Thêm Điểm Danh Mới</h1>
                <p class="text-muted mb-0">Thêm khách hàng vào danh sách tham gia.</p>
            @endif
        </div>
        <a href="{{ route('list-attendance') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-2"></i> Quay lại
        </a>
    </div>
</div>

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

<div class="card-dark p-4">
    <form action="{{ route('post-attendance') }}" method="post">
        <div class="row g-4">
            {{-- Chọn departure --}}
            <div class="col-md-6">
                <label class="form-label text-white-50">Lịch khởi hành <span class="text-danger">*</span></label>
                <select name="departure_id" class="form-select form-select-dark" required>
                    <option value="">-- Chọn lịch khởi hành --</option>
                    @foreach($departures as $d)
                        @php
                            $sDate = $d->start_date ?? ($d->booking_start_date ?? null);
                            $eDate = $d->end_date ?? ($d->booking_end_date ?? null);
                        @endphp
                        <option value="{{ $d->id }}" {{ (isset($_GET['departure_id']) && $_GET['departure_id'] == $d->id) ? 'selected' : '' }}>
                            {{ $d->tour_name }} ({{ !empty($sDate) ? date('d/m/Y', strtotime($sDate)) : '?' }} - {{ !empty($eDate) ? date('d/m/Y', strtotime($eDate)) : '?' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Chọn customer --}}
            <div class="col-md-6">
                <label class="form-label text-white-50">Khách hàng</label>
                <select name="customer_id" class="form-select form-select-dark">
                    <option value="">-- Chọn khách hàng --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ (isset($_GET['customer_id']) && $_GET['customer_id'] == $c->id) ? 'selected' : '' }}>
                            {{ $c->fullname }} - {{ $c->phone }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Chọn booking_customer --}}
            <div class="col-md-6">
                <label class="form-label text-white-50">Thành viên (Khách đi kèm)</label>
                <select name="booking_customer_id" class="form-select form-select-dark">
                    <option value="">-- Không chọn (Nếu là khách chính) --</option>
                    @foreach($bookingCustomers as $bc)
                        <option value="{{ $bc->id }}" {{ (isset($_GET['booking_customer_id']) && $_GET['booking_customer_id'] == $bc->id) ? 'selected' : '' }}>
                            {{ $bc->fullname }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Trạng thái --}}
            <div class="col-md-6">
                <label class="form-label text-white-50">Trạng thái <span class="text-danger">*</span></label>
                <select name="status" class="form-select form-select-dark" required>
                    <option value="present">Có mặt</option>
                    <option value="absent">Vắng</option>
                </select>
            </div>

            {{-- Checkin time --}}
            <div class="col-md-6">
                <label class="form-label text-white-50">Thời gian Check-in</label>
                <input type="datetime-local" class="form-control form-control-dark" name="checkin_time">
            </div>

            {{-- Ghi chú --}}
            <div class="col-12">
                <label class="form-label text-white-50">Ghi chú</label>
                <textarea class="form-control form-control-dark" name="note" rows="3" placeholder="Nhập ghi chú..."></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('list-attendance') }}" class="btn btn-outline-secondary px-4 rounded-pill">Hủy</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill" name="btn-submit">
                <i class="bi bi-check-lg me-2"></i> Xác nhận
            </button>
        </div>
    </form>
</div>
@endsection
