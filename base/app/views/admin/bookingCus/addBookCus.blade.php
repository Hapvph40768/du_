@extends('layout.dashboard')
@section('title', 'Thêm khách vào booking')

@section('active-booking-customer', 'active')
@section('content')
    <h1>Thêm khách vào booking</h1>

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

    <form action="{{ route('post-customer') }}" method="post">
        {{-- chọn booking --}}
        <div class="mb-3">
            <label>Booking</label>
            <select name="booking_id" required>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}">Booking #{{ $b->id }} - Tour {{ $b->tour_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- chọn customer --}}
        <div class="mb-3">
            <label>Khách hàng</label>
            <select name="customer_id" required>
                @foreach($customers as $cus)
                    <option value="{{ $cus->id }}">{{ $cus->fullname }} - {{ $cus->phone }}</option>
                @endforeach
            </select>
        </div>

        {{-- họ tên --}}
        <div class="mb-3">
            <label for="fullname" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="fullname" required>
        </div>

        {{-- giới tính --}}
        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select name="gender" class="form-select" required>
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
                <option value="other">Khác</option>
            </select>
        </div>

        {{-- ngày sinh --}}
        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" name="dob" required>
        </div>

        {{-- ghi chú --}}
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea class="form-control" name="note"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Xác nhận</button>
    </form>
@endsection