@extends('layout.guide')
@section('title', 'Thêm yêu cầu dịch vụ')

@section('active-guide-scr', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="bi bi-plus-circle"></i> Thêm Yêu cầu mới
        </h1>
        <a href="{{ route('list-guide-scr') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
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

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('post-guide-scr') }}" method="POST">
                
                {{-- Booking --}}
                <div class="mb-3">
                    <label for="booking_id" class="form-label">Booking <span class="text-danger">*</span></label>
                    <select name="booking_id" id="booking_id" class="form-select" required>
                        <option value="">-- Chọn booking --</option>
                        @foreach($bookings as $b)
                            <option value="{{ $b->id }}">Booking #{{ $b->id }} - {{ $b->customer_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Service --}}
                <div class="mb-3">
                    <label class="form-label">Dịch vụ (Tùy chọn)</label>
                    <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                        @foreach($services as $s)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $s->id }}" id="srv_{{ $s->id }}">
                            <label class="form-check-label" for="srv_{{ $s->id }}">
                                {{ $s->name }} ({{ number_format($s->default_price, 0, ',', '.') }} đ)
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-text">Có thể chọn nhiều dịch vụ cùng lúc.</div>
                </div>

                {{-- Request Content --}}
                <div class="mb-3">
                    <label for="request" class="form-label">Nội dung yêu cầu <span class="text-danger">*</span></label>
                    <textarea name="request" id="request" class="form-control" rows="5" placeholder="Nhập chi tiết yêu cầu thay đổi..." required></textarea>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-2"></i> Gửi yêu cầu
                    </button>
                    <a href="{{ route('list-guide-scr') }}" class="btn btn-secondary px-3">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
