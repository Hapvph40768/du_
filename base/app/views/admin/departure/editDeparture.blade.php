@extends('layout.dashboard')
@section('title', 'Sửa Lịch khởi hành của tour')

@section('active-departure', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{ $_SESSION['success'] }}</span>
    @endif

    <a href="{{ route('list-departure') }}">
        <button type="button" class="btn btn-warning">Quay lại</button>
    </a>

    <form action="{{ route('edit-departure/' . $detail->id) }}" method="post">
        {{-- chọn tour --}}
        <div class="mb-3">
            <label>Chọn Tour:</label><br>
            <select name="tour_id" required>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ $tour->id == $detail->tour_id ? 'selected' : '' }}>
                        {{ $tour->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ngày bắt đầu --}}
        <div class="mb-3">
            <label for="start_date" class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" name="start_date" value="{{ $detail->start_date }}" required>
        </div>

        {{-- ngày kết thúc --}}
        <div class="mb-3">
            <label for="end_date" class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" name="end_date" value="{{ $detail->end_date }}" required>
        </div>

        {{-- giá riêng cho departure --}}
        <div class="mb-3">
            <label for="price" class="form-label">Giá (nếu khác giá tour)</label>
            <input type="number" class="form-control" name="price" step="0.01" value="{{ $detail->price }}">
        </div>

        {{-- số ghế trống --}}
        <div class="mb-3">
            <label for="available_seats" class="form-label">Số ghế trống</label>
            <input type="number" class="form-control" name="available_seats" min="0" value="{{ $detail->available_seats }}" required>
        </div>

        {{-- chi phí guide --}}
        <div class="mb-3">
            <label for="guide_price" class="form-label">Chi phí cho hướng dẫn viên</label>
            <input type="number" class="form-control" name="guide_price" step="0.01" value="{{ $detail->guide_price }}">
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="open" {{ $detail->status === 'open' ? 'selected' : '' }}>Đang mở</option>
                <option value="closed" {{ $detail->status === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                <option value="full" {{ $detail->status === 'full' ? 'selected' : '' }}>Đầy chỗ</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit">Xác nhận</button>
        </div>
    </form>
@endsection