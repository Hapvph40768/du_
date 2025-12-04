@extends('layout.dashboard')
@section('title', 'Thêm Dịch vụ vào Booking')

@section('active-booking-service', 'active')
@section('content')
    <h3>Thêm Dịch vụ vào Booking</h3>

    <form action="{{ route('post-booking-service') }}" method="post">
        <div class="mb-3">
            <label>Booking</label>
            <select name="booking_id" class="form-select" required>
                <option value="">-- Chọn Booking --</option>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}">{{ $b->code }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Dịch vụ</label>
            <select name="service_id" class="form-select" required>
                <option value="">-- Chọn Dịch vụ --</option>
                @foreach($services as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" class="form-control" name="quantity" value="1" min="1">
        </div>

        <div class="mb-3">
            <label>Giá tại thời điểm đặt</label>
            <input type="number" step="0.01" class="form-control" name="price" value="0">
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Thêm</button>
        <a href="{{ route('list-booking-service') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection