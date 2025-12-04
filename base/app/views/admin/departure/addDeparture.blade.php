@extends('layout.dashboard')
@section('title', 'Thêm Lịch khởi hành của tour')

@section('active-departure', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-calendar-plus"></i> Thêm Lịch khởi hành</h2>
        <a href="{{ route('list-departure') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <form action="{{ route('post-departure') }}" method="post" class="bg-light p-4 rounded shadow-sm">
        {{-- chọn tour --}}
        <div class="mb-3">
            <label for="tour_id" class="form-label fw-bold">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                <option value="">-- Chọn tour --</option>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- ngày bắt đầu --}}
        <div class="mb-3">
            <label for="start_date" class="form-label fw-bold">Ngày bắt đầu</label>
            <input type="date" class="form-control" name="start_date" required>
        </div>

        {{-- ngày kết thúc --}}
        <div class="mb-3">
            <label for="end_date" class="form-label fw-bold">Ngày kết thúc</label>
            <input type="date" class="form-control" name="end_date" required>
        </div>

        {{-- giá riêng cho departure --}}
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Giá (nếu khác giá tour)</label>
            <input type="number" class="form-control" name="price" step="1000" placeholder="Ví dụ: 2000000">
        </div>

        {{-- số ghế trống --}}
        <div class="mb-3">
            <label for="available_seats" class="form-label fw-bold">Số ghế trống</label>
            <input type="number" class="form-control" name="available_seats" min="0" required placeholder="Ví dụ: 20">
        </div>

        {{-- chi phí guide --}}
        <div class="mb-3">
            <label for="guide_price" class="form-label fw-bold">Chi phí cho hướng dẫn viên</label>
            <input type="number" class="form-control" name="guide_price" step="1000" placeholder="Ví dụ: 500000">
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label fw-bold">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="open">Đang mở</option>
                <option value="closed">Đã đóng</option>
                <option value="full">Đầy chỗ</option>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit" value="them">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>
@endsection