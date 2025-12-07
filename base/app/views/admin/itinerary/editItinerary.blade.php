@extends('layout.dashboard')
@section('title', 'Sửa Lịch trình theo ngày')

@section('active-itinerary', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-edit"></i> Sửa Lịch trình theo ngày</h2>
        <a href="{{ route('list-itinerary') }}" class="btn btn-warning">
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

    <form action="{{ route('edit-itinerary/' . $detail->id) }}" method="post" class="bg-light p-4 rounded shadow-sm">
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
        </div>

        {{-- ngày thứ --}}
        <div class="mb-3">
            <label for="day_number" class="form-label fw-bold">Ngày thứ trong lịch trình</label>
            <input type="number" class="form-control" name="day_number" value="{{ $detail->day_number }}" min="1" required>
        </div>

        {{-- tiêu đề --}}
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">Tiêu đề của ngày</label>
            <input type="text" class="form-control" name="title" value="{{ $detail->title }}" required placeholder="Ví dụ: Khám phá phố cổ Hội An">
        </div>

        {{-- nội dung chi tiết --}}
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Nội dung chi tiết của ngày</label>
            <textarea class="form-control" name="description" rows="5" required placeholder="Mô tả chi tiết hoạt động trong ngày...">{{ $detail->description }}</textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>
@endsection