@extends('layout.dashboard')
@section('title', 'Thêm Booking')
@section('active-booking', 'active')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">
            <i class="fas fa-plus-circle"></i> Thêm Booking
        </h2>
        <a href="{{ route('list-booking') }}" class="btn btn-warning shadow-sm">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fas fa-check-circle"></i> {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="fas fa-exclamation-circle"></i> Đã xảy ra lỗi:
            <ul class="mt-2 mb-0">
                @foreach($_SESSION['errors'] as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FORM ADD BOOKING --}}
    <form action="{{ route('post-booking') }}" method="post" class="bg-white p-4 rounded shadow-sm border">

        {{-- KHÁCH HÀNG --}}
        <div class="mb-3">
            <label class="fw-bold">Khách hàng</label>
            <select name="customer_id" class="form-select" required>
                <option value="">-- Chọn khách hàng --</option>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}">
                        {{ $c->fullname }} — {{ $c->email }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- LỊCH KHỞI HÀNH --}}
        <div class="mb-3">
            <label class="fw-bold">Lịch khởi hành</label>
            <select name="departure_id" id="departureSelect" class="form-select" required>
                <option value="">-- Chọn lịch khởi hành --</option>
                @foreach($departures as $d)
                    <option 
                        value="{{ $d->id }}"
                        data-price="{{ $d->price }}"
                        data-seats="{{ $d->remaining_seats }}"
                    >
                        {{ $d->tour_name }} 
                        ({{ date('d/m/Y', strtotime($d->start_date)) }})
                        — Giá: {{ number_format($d->price,0,',','.') }} đ
                        — Còn: {{ $d->remaining_seats }} ghế
                    </option>
                @endforeach
            </select>
        </div>

        {{-- SỐ NGƯỜI --}}
        <div class="mb-3">
            <label class="fw-bold">Số người</label>
            <input 
                type="number" 
                name="num_people" 
                id="numPeopleInput" 
                class="form-control" 
                min="1" 
                required
            >
            <small id="seatWarning" class="text-danger d-none"></small>
        </div>

        {{-- TỔNG TIỀN --}}
        <div class="mb-3">
            <label class="fw-bold">Tổng tiền</label>
            <input 
                type="text" 
                id="total_price_display" 
                class="form-control fw-bold text-success" 
                readonly 
                value="0 đ"
            >
        </div>

        {{-- THANH TOÁN --}}
        <div class="mb-3">
            <label class="fw-bold">Thanh toán</label>
            <select name="payment_status" class="form-select" required>
                <option value="unpaid">Chưa thanh toán</option>
                <option value="partial">Thanh toán một phần</option>
                <option value="paid">Đã thanh toán</option>
            </select>
        </div>

        {{-- TRẠNG THÁI --}}
        <div class="mb-3">
            <label class="fw-bold">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="pending">Chờ xác nhận</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="cancelled">Đã hủy</option>
                <option value="completed">Hoàn thành</option>
            </select>
        </div>

        {{-- GHI CHÚ --}}
        <div class="mb-3">
            <label class="fw-bold">Ghi chú</label>
            <textarea 
                name="note" 
                class="form-control" 
                rows="3" 
                placeholder="Nhập ghi chú (nếu có)..."
            ></textarea>
        </div>

        {{-- SUBMIT --}}
        <div class="text-end">
            <button type="submit" class="btn btn-primary shadow-sm" name="btn-submit">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT TÍNH GIÁ + CHECK GHẾ --}}
<script>
    const departureSelect = document.getElementById('departureSelect');
    const numPeopleInput = document.getElementById('numPeopleInput');
    const totalPriceDisplay = document.getElementById('total_price_display');
    const seatWarning = document.getElementById('seatWarning');

    function updateTotalPrice() {
        const selected = departureSelect.options[departureSelect.selectedIndex];

        const price = Number(selected?.dataset.price || 0);
        const seats = Number(selected?.dataset.seats || 0);
        const numPeople = Number(numPeopleInput.value || 0);

        // Tính tổng tiền
        const total = price * numPeople;
        totalPriceDisplay.value = total.toLocaleString("vi-VN") + " đ";

        // Kiểm tra ghế trống
        if (numPeople > seats && seats > 0) {
            seatWarning.textContent = `Không đủ ghế. Chỉ còn ${seats} ghế.`;
            seatWarning.classList.remove('d-none');
        } else {
            seatWarning.textContent = "";
            seatWarning.classList.add('d-none');
        }
    }

    departureSelect.addEventListener('change', updateTotalPrice);
    numPeopleInput.addEventListener('input', updateTotalPrice);
</script>

@endsection
