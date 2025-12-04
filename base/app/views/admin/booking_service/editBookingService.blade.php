@extends('layout.dashboard')
@section('title', 'Sửa Dịch vụ Booking')

@section('active-booking-service', 'active')
@section('content')
    <h3>Sửa Dịch vụ Booking #{{ $detail->id }}</h3>

    <form action="{{ route('edit-booking-service/' . $detail->id) }}" method="post">
        <div class="mb-3">
            <label>Booking</label>
            <select name="booking_id" class="form-select" required>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $detail->booking_id ? 'selected' : '' }}>
                        {{ $b->code }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Dịch vụ</label>
            <select name="service_id" class="form-select" required>
                @foreach($services as $s)
                    <option value="{{ $s->id }}" {{ $s->id == $detail->service_id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" class="form-control" name="quantity" value="{{ $detail->quantity }}" min="1">
        </div>

        <div class="mb-3">
            <label>Giá tại thời điểm đặt</label>
            <input type="number" step="0.01" class="form-control" name="price" value="{{ $detail->price }}">
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
        <a href="{{ route('list-booking-service') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection