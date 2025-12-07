@extends('layout.dashboard')
@section('title', 'Sửa Booking')
@section('active-booking', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-edit"></i> Sửa Booking</h2>
        <a href="{{ route('list-booking') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['success']))
        <div class="alert alert-success">{{ $_SESSION['success'] }}</div>
    @endif
    @if(isset($_SESSION['error']))
        <div class="alert alert-danger">
            @if(is_array($_SESSION['error']))
                <ul class="mb-0">
                    @foreach($_SESSION['error'] as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @else
                {{ $_SESSION['error'] }}
            @endif
        </div>
    @endif

    <form action="{{ route('edit-booking/'.$detail->id) }}" method="post" class="bg-light p-4 rounded shadow-sm">

        {{-- Khách hàng --}}
        <div class="mb-3">
            <label class="fw-bold">Khách hàng</label>
            <select name="customer_id" class="form-select" required>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ $detail->customer_id == $c->id ? 'selected' : '' }}>
                        {{ $c->fullname }} - {{ $c->email }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Lịch khởi hành --}}
        <div class="mb-3">
            <label class="fw-bold">Lịch khởi hành</label>
            <select name="departure_id" class="form-select" required>
                @foreach($departures as $d)
                    <option 
                        value="{{ $d->id }}"
                        data-price="{{ $d->price }}"
                        data-seats="{{ $d->remaining_seats }}"
                        {{ $detail->departure_id == $d->id ? 'selected' : '' }}
                    >
                        {{ $d->tour_name }}
                        - {{ date('d/m/Y', strtotime($d->start_date)) }}
                        | Giá: {{ number_format($d->price,0,',','.') }}đ
                        | Còn {{ $d->remaining_seats }} ghế
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Số người --}}
        <div class="mb-3">
            <label class="fw-bold">Số người</label>
            <input type="number" name="num_people" class="form-control" min="1" required
                value="{{ $detail->num_people }}">
        </div>

        {{-- Tổng tiền --}}
        <div class="mb-3">
            <label class="fw-bold">Tổng tiền</label>
            <input type="text" id="total_price_display" class="form-control" readonly
                value="{{ number_format($detail->total_price, 0, ',', '.') }} đ">
        </div>

        {{-- Thanh toán --}}
        <div class="mb-3">
            <label class="fw-bold">Thanh toán</label>
            <select name="payment_status" class="form-select" required>
                <option value="unpaid" {{ $detail->payment_status == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                <option value="partial" {{ $detail->payment_status == 'partial' ? 'selected' : '' }}>Thanh toán một phần</option>
                <option value="paid" {{ $detail->payment_status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
            </select>
        </div>

        {{-- Trạng thái --}}
        <div class="mb-3">
            <label class="fw-bold">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $detail->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="confirmed" {{ $detail->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="cancelled" {{ $detail->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                <option value="completed" {{ $detail->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
        </div>

        {{-- Ghi chú --}}
        <div class="mb-3">
            <label class="fw-bold">Ghi chú</label>
            <textarea name="note" class="form-control" rows="3">{{ $detail->note }}</textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit">
                <i class="fas fa-check-circle"></i> Cập nhật
            </button>
        </div>
    </form>
</div>

{{-- Script tính tổng tiền --}}
<script>
    const departureSelect = document.querySelector('select[name="departure_id"]');
    const numPeopleInput = document.querySelector('input[name="num_people"]');
    const totalPriceDisplay = document.getElementById('total_price_display');

    function updateTotalPrice() {
        const selected = departureSelect.options[departureSelect.selectedIndex];
        const price = parseFloat(selected.dataset.price || 0);
        const numPeople = parseInt(numPeopleInput.value || 0);
        const total = price * numPeople;
        totalPriceDisplay.value = total.toLocaleString('vi-VN') + ' đ';
    }

    departureSelect.addEventListener('change', updateTotalPrice);
    numPeopleInput.addEventListener('input', updateTotalPrice);

    updateTotalPrice();
</script>
@endsection
