@extends('layout.dashboard')
@section('title','Thêm Lịch khởi hành')

@section('active-departure','active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-calendar-plus text-primary"></i> Thêm Lịch khởi hành</h2>
        <a href="{{ route('list-departure') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Quay lại
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success mb-4">{{ $_SESSION['success'] }}</div>
    @endif

    <div class="card-dark p-4">
        <form action="{{ route('post-departure') }}" method="post">
            <div class="mb-3">
                <label class="fw-bold text-white mb-1">Chọn Tour</label>
                <select name="tour_id" class="form-select bg-dark text-white border-secondary" required>
                    <option value="" class="text-white">-- Chọn tour --</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}" class="text-white">{{ $tour->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label fw-bold text-white mb-1">Ngày khởi hành</label>
                    <input type="date" class="form-control bg-dark text-white border-secondary" id="start_date" name="start_date">
                </div>
                <div class="col-md-4">
                    <label for="start_time" class="form-label fw-bold text-white mb-1">Giờ khởi hành</label>
                    <input type="time" class="form-control bg-dark text-white border-secondary" id="start_time" name="start_time">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label fw-bold text-white mb-1">Ngày kết thúc</label>
                    <input type="date" class="form-control bg-dark text-white border-secondary" id="end_date" name="end_date">
                </div>
            </div>

            <div class="mb-3">
                <label for="total_seats" class="fw-bold text-white mb-1">Tổng số chỗ</label>
                <input type="number" class="form-control bg-dark text-white border-secondary" id="total_seats" name="total_seats" placeholder="Nhập tổng số ghế..." >
                <small class="text-muted">Khi tạo mới, số ghế còn lại = tổng số ghế.</small>
            </div>

            <div class="mb-3">
                <label class="fw-bold text-white mb-1">Trạng thái</label>
                <select name="status" class="form-select bg-dark text-white border-secondary" required>
                    <option value="" class="text-muted">-- Chọn trạng thái --</option>
                    <option value="open">Đang mở</option>
                    <option value="closed">Đã đóng</option>
                    <option value="full">Đầy chỗ</option>
                </select>
            </div>

            <div class="text-end pt-3 border-top border-secondary">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold" name="btn-submit">
                    <i class="fas fa-check-circle me-1"></i> Xác nhận
                </button>
            </div>
        </form>
    </div>
</div>
@endsection