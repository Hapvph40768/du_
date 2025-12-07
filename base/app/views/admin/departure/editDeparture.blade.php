@extends('layout.dashboard')
@section('title','Sửa Lịch khởi hành')

@section('active-departure','active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-calendar-check"></i> Sửa Lịch khởi hành</h2>
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
        <div class="alert alert-success">{{ $_SESSION['success'] }}</div>
    @endif

    <form action="{{ route('edit-departure/'.$detail->id) }}" method="post" class="bg-light p-4 rounded shadow-sm">
        {{-- chọn tour --}}
        <div class="mb-3">
            <label for="tour_id" class="form-label fw-bold">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ $tour->id == $detail->tour_id ? 'selected' : '' }}>
                        {{ $tour->name }}
                    </option>
                @endforeach
            </select>
            @if(isset($_SESSION['errors']['tour_id']))
                <small class="text-danger">{{ $_SESSION['errors']['tour_id'] }}</small>
            @endif
        </div>

        {{-- ngày bắt đầu --}}
        <div class="mb-3">
            <label for="start_date" class="form-label fw-bold">Ngày bắt đầu</label>
            <input type="date" class="form-control" name="start_date" value="{{ $detail->start_date }}" required>
            @if(isset($_SESSION['errors']['start_date']))
                <small class="text-danger">{{ $_SESSION['errors']['start_date'] }}</small>
            @endif
        </div>

        {{-- ngày kết thúc --}}
        <div class="mb-3">
            <label for="end_date" class="form-label fw-bold">Ngày kết thúc</label>
            <input type="date" class="form-control" name="end_date" value="{{ $detail->end_date }}" required>
            @if(isset($_SESSION['errors']['end_date']))
                <small class="text-danger">{{ $_SESSION['errors']['end_date'] }}</small>
            @endif
            @if(isset($_SESSION['errors']['date_invalid']))
                <small class="text-danger">{{ $_SESSION['errors']['date_invalid'] }}</small>
            @endif
        </div>

        {{-- giá riêng cho departure --}}
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Giá (nếu khác giá tour)</label>
            <input type="number" class="form-control" name="price" step="1000" value="{{ $detail->price }}" placeholder="Ví dụ: 2000000">
        </div>

        {{-- tổng số ghế --}}
        <div class="mb-3">
            <label for="total_seats" class="form-label fw-bold">Tổng số ghế</label>
            <input type="number" class="form-control" name="total_seats" min="1" value="{{ $detail->total_seats }}" required placeholder="Ví dụ: 20">
            @if(isset($_SESSION['errors']['total_seats']))
                <small class="text-danger">{{ $_SESSION['errors']['total_seats'] }}</small>
            @endif
        </div>

        {{-- số ghế còn lại (readonly) --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Số ghế còn lại</label>
            <input type="number" class="form-control" value="{{ $detail->remaining_seats }}" readonly>
            <small class="text-muted">Giá trị này được cập nhật tự động khi có booking.</small>
        </div>

        {{-- chi phí guide --}}
        <div class="mb-3">
            <label for="guide_price" class="form-label fw-bold">Chi phí cho hướng dẫn viên</label>
            <input type="number" class="form-control" name="guide_price" step="1000" value="{{ $detail->guide_price }}" placeholder="Ví dụ: 500000">
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label fw-bold">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="open" {{ $detail->status === 'open' ? 'selected' : '' }}>Đang mở</option>
                <option value="closed" {{ $detail->status === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                <option value="full" {{ $detail->status === 'full' ? 'selected' : '' }}>Đầy chỗ</option>
                <option value="completed" {{ $detail->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
            @if(isset($_SESSION['errors']['status']))
                <small class="text-danger">{{ $_SESSION['errors']['status'] }}</small>
            @endif
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>
@endsection