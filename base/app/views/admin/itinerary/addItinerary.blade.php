@extends('layout.dashboard')
@section('title', 'Thêm Lịch trình theo ngày')

@section('active-itinerary', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-calendar-plus"></i> Thêm Lịch trình theo ngày</h2>
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

    <form action="{{ route('post-itinerary') }}" method="post" class="bg-light p-4 rounded shadow-sm">
        {{-- Chọn tour --}}
        <div class="mb-3">
            <label for="tour_id" class="form-label fw-bold">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                <option value="">-- Chọn tour --</option>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Chọn lịch khởi hành --}}
        <div class="mb-3">
            <label for="departure_id" class="form-label fw-bold">Chọn Lịch khởi hành</label>
            <select name="departure_id" id="departure_id" class="form-select" required>
                <option value="">-- Chọn lịch khởi hành --</option>
                {{-- JS sẽ điền các departures tương ứng tour --}}
            </select>
        </div>

        {{-- Ngày thứ --}}
        <div class="mb-3">
            <label for="day_number" class="form-label fw-bold">Ngày thứ mấy trong lịch trình</label>
            <input type="number" class="form-control" name="day_number" min="1" required placeholder="Ví dụ: 1">
        </div>

        {{-- Tiêu đề --}}
        <div class="mb-3">
            <label for="title" class="form-label fw-bold">Tiêu đề của ngày</label>
            <input type="text" class="form-control" name="title" required placeholder="Ví dụ: Khám phá phố cổ Hội An">
        </div>

        {{-- Nội dung chi tiết --}}
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Nội dung chi tiết của ngày</label>
            <textarea class="form-control" name="description" rows="5" required placeholder="Mô tả chi tiết hoạt động trong ngày..."></textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit" value="them">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>

{{-- JS tự động lọc departures theo tour --}}
<script>
    const tours = @json($tours);
    const departures = @json($departures);
    const tourSelect = document.getElementById('tour_id');
    const departureSelect = document.getElementById('departure_id');

    tourSelect.addEventListener('change', function() {
        const tourId = parseInt(this.value);
        departureSelect.innerHTML = '<option value="">-- Chọn lịch khởi hành --</option>';
        if (!isNaN(tourId)) {
            departures.forEach(dep => {
                if (dep.tour_id === tourId) {
                    const option = document.createElement('option');
                    option.value = dep.id;
                    option.text = dep.start_date + ' → ' + dep.end_date + ' | Giá: ' + dep.price;
                    departureSelect.appendChild(option);
                }
            });
        }
    });
</script>
@endsection
