@extends('layout.dashboard')
@section('title', 'Thêm Yêu cầu thay đổi dịch vụ')
@section('active-request', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="fas fa-plus-circle"></i> Thêm Yêu cầu mới
        </h1>
        <a href="{{ route('list-request') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('post-request') }}" method="post">
                {{-- chọn booking --}}
                <div class="mb-3">
                    <label for="booking_id" class="form-label">Booking</label>
                    <select name="booking_id" id="booking_id" class="form-select" required>
                        <option value="">-- Chọn Booking --</option>
                        @foreach($bookings as $b)
                            <option value="{{ $b->id }}">Booking #{{ $b->id }} - {{ $b->code }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- chọn dịch vụ (tùy chọn) --}}
                <div class="mb-3">
                    <label for="service_id" class="form-label">Dịch vụ (Tùy chọn)</label>
                    <select name="service_id" id="service_id" class="form-select">
                        <option value="">-- Chọn Dịch vụ --</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} ({{ number_format($s->default_price, 0, ',', '.') }} đ)</option>
                        @endforeach
                    </select>
                </div>

                {{-- nội dung yêu cầu --}}
                <div class="mb-3">
                    <label for="request" class="form-label">Nội dung yêu cầu</label>
                    <textarea class="form-control" name="request" id="request" rows="4" required></textarea>
                </div>

                {{-- trạng thái --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending">Đang chờ</option>
                        <option value="approved">Đã duyệt</option>
                        <option value="rejected">Từ chối</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" name="btn-submit">
                    <i class="fas fa-save"></i> Thêm
                </button>
                <a href="{{ route('list-request') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </form>
        </div>
    </div>
</div>
@endsection