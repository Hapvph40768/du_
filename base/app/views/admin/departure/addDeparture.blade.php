@extends('layout.dashboard')
@section('title','Thêm Lịch khởi hành')

@section('active-departure','active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-calendar-plus"></i> Thêm Lịch khởi hành</h2>
        <a href="{{ route('list-departure') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">{{ $_SESSION['success'] }}</div>
    @endif

    <form action="{{ route('post-departure') }}" method="post" class="bg-light p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="fw-bold">Chọn Tour</label>
            <select name="tour_id" class="form-select" required>
                <option value="">-- Chọn tour --</option>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Giá (nếu khác giá tour)</label>
            <input type="number" name="price" class="form-control" step="1000" placeholder="Ví dụ: 2000000">
        </div>

        <div class="mb-3">
            <label class="fw-bold">Tổng số ghế</label>
            <input type="number" name="total_seats" class="form-control" min="1" required placeholder="Ví dụ: 20">
            <small class="text-muted">Khi tạo mới, số ghế còn lại = tổng số ghế.</small>
        </div>

        <div class="mb-3">
            <label class="fw-bold">Chi phí hướng dẫn viên</label>
            <input type="number" name="guide_price" class="form-control" step="1000" placeholder="Ví dụ: 500000">
        </div>

        <div class="mb-3">
            <label class="fw-bold">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="open">Đang mở</option>
                <option value="closed">Đã đóng</option>
                <option value="full">Đầy chỗ</option>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>
@endsection