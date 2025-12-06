@extends('layout.dashboard')
@section('title', 'Thêm Dịch vụ vào Booking')
@section('active-booking-service', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="fas fa-plus-circle"></i> Thêm Dịch vụ vào Booking
        </h1>
        <a href="{{ route('list-booking-service') }}" class="btn btn-secondary shadow-sm">
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
            <form action="{{ route('post-booking-service') }}" method="post">
                <div class="mb-3">
                    <label class="form-label">Booking</label>
                    <select name="booking_id" class="form-select" required>
                        <option value="">-- Chọn Booking --</option>
                        @foreach($bookings as $b)
                            <option value="{{ $b->id }}">Booking #{{ $b->id }} - {{ $b->code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dịch vụ</label>
                    <select name="service_id" class="form-select" required>
                        <option value="">-- Chọn Dịch vụ --</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Số lượng</label>
                    <input type="number" class="form-control" name="quantity" value="1" min="1">
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá tại thời điểm đặt</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="0">
                </div>

                <button type="submit" class="btn btn-primary" name="btn-submit">
                    <i class="fas fa-save"></i> Thêm
                </button>
                <a href="{{ route('list-booking-service') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </form>
        </div>
    </div>
</div>
@endsection