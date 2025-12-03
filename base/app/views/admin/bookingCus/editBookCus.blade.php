@extends('layout.dashboard')
@section('title', 'Sửa khách trong booking')

@section('active-booking-customer', 'active')
@section('content')
    <h1>Sửa khách trong booking</h1>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('list-customer') }}">
        <button type="button" class="btn btn-warning">Quay lại</button>
    </a>

    <form action="{{ route('update-customer/' . $customer->id) }}" method="post">
        {{-- chọn booking --}}
        <div class="mb-3">
            <label>Booking</label>
            <select name="booking_id" required>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $customer->booking_id ? 'selected' : '' }}>
                        Booking #{{ $b->id }} - Tour {{ $b->tour_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- chọn customer --}}
        <div class="mb-3">
            <label>Khách hàng</label>
            <select name="customer_id" required>
                @foreach($customers as $cus)
                    <option value="{{ $cus->id }}" {{ $cus->id == $customer->customer_id ? 'selected' : '' }}>
                        {{ $cus->fullname }} - {{ $cus->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- họ tên --}}
        <div class="mb-3">
            <label for="fullname" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="fullname" value="{{ $customer->fullname }}" required>
        </div>

        {{-- giới tính --}}
        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select name="gender" class="form-select" required>
                <option value="male" {{ $customer->gender === 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ $customer->gender === 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ $customer->gender === 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        {{-- ngày sinh --}}
        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" name="dob" value="{{ $customer->dob }}" required>
        </div>

        {{-- ghi chú --}}
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea class="form-control" name="note">{{ $customer->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
    </form>
@endsection