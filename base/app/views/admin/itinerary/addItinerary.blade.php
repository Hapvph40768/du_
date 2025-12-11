@extends('layout.dashboard')
@section('title', 'Thêm Lịch trình theo ngày')

@section('active-itinerary', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white"><i class="fas fa-calendar-plus me-2"></i> Thêm Lịch trình theo ngày</h2>
        <a href="{{ route('list-itinerary') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('post-itinerary') }}" method="post" class="card-dark p-4 rounded shadow-sm">
        <div class="row">
            {{-- Chọn tour --}}
            <div class="col-md-6 mb-3">
                <label for="tour_id" class="form-label text-white-50 fw-bold">Tour</label>
                <select name="tour_id" id="tour_id" class="form-select bg-dark text-white border-secondary" required>
                    <option value="">-- Chọn tour --</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Chọn lịch khởi hành --}}
            <div class="col-md-6 mb-3">
                <label for="departure_id" class="form-label text-white-50 fw-bold">Lịch trình</label>
                <select name="departure_id" id="departure_id" class="form-select bg-dark text-white border-secondary" required>
                    <option value="">-- Chọn lịch khởi hành --</option>
                    {{-- JS sẽ điền các departures tương ứng tour --}}
                </select>
            </div>
        </div>

        {{-- Ngày thứ --}}
        <div class="mb-3">
            <label for="day_number" class="form-label text-white-50 fw-bold">Ngày thứ mấy trong lịch trình</label>
            <input type="number" class="form-control bg-dark text-white border-secondary" name="day_number" min="1" required placeholder="Ví dụ: 1">
        </div>

        {{-- Tiêu đề --}}
        <div class="mb-3">
            <label for="title" class="form-label text-white-50 fw-bold">Tiêu đề của ngày</label>
            <input type="text" class="form-control bg-dark text-white border-secondary" name="title" required placeholder="Ví dụ: Khám phá phố cổ Hội An">
        </div>

        {{-- Nội dung chi tiết --}}
        <div class="mb-3">
            <label for="description" class="form-label text-white-50 fw-bold">Nội dung chi tiết của ngày</label>
            <textarea class="form-control bg-dark text-white border-secondary" name="description" rows="5" required placeholder="Mô tả chi tiết hoạt động trong ngày..."></textarea>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary px-4 py-2" name="btn-submit" value="them">
                <i class="fas fa-check-circle me-2"></i> Xác nhận
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
                    // Format date nicely with fallback
                    const rawStart = dep.start_date || dep.booking_start_date;
                    const rawEnd = dep.end_date || dep.booking_end_date;

                    const sDate = rawStart ? new Date(rawStart).toLocaleDateString('vi-VN') : '--';
                    const eDate = rawEnd ? new Date(rawEnd).toLocaleDateString('vi-VN') : '--';
                    option.text = `#${dep.id} | ${sDate} - ${eDate}`;
                    departureSelect.appendChild(option);
                }
            });
        }
    });

    // Auto-select if departure_id is in URL
    const urlParams = new URLSearchParams(window.location.search);
    const preDepartureId = urlParams.get('departure_id');

    if (preDepartureId) {
        // Find which tour this departure belongs to
        const targetDep = departures.find(d => d.id == preDepartureId);
        if (targetDep) {
             // Select Tour
             tourSelect.value = targetDep.tour_id;
             // Trigger change to populate departure list
             tourSelect.dispatchEvent(new Event('change'));
             // Select Departure
             departureSelect.value = preDepartureId;

             // LOCK THEM so user cannot change context
             tourSelect.classList.add('bg-secondary', 'bg-opacity-25');
             tourSelect.style.pointerEvents = 'none';
             departureSelect.classList.add('bg-secondary', 'bg-opacity-25');
             departureSelect.style.pointerEvents = 'none';
             // Note: pointer-events:none prevents interaction but keeps value submit-able usually, 
             // but 'readonly' on select is tricky. 
             // Better to just use pointer-events and maybe a hidden input in case browser doesn't send it?
             // Actually, pointer-events:none allows submission. 'disabled' does not.
             // User just wants "lấy cứng" (hard fix).
             // Let's use the pointer-events trick + styling to make it look read-only. 
             // It's safer for form submission than disabling.
             
             // Visual cue
             const label1 = document.querySelector('label[for="tour_id"]');
             if(label1) label1.innerHTML += ' <span class="badge bg-warning text-dark ms-2">Đã khóa</span>';
        }
    }
</script>
@endsection
