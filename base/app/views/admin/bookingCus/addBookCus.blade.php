@extends('layout.dashboard')
@section('title', 'Thêm khách vào booking')

@section('active-booking-customer', 'active')
@section('content')
    <h3>Thêm khách vào booking</h3>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <a href="{{ route('list-booking-customer') }}" class="btn btn-warning mb-3">Quay lại danh sách</a>

    <form action="{{ route('post-booking-customer') }}" method="post">
        {{-- chọn booking --}}
        <div class="mb-3">
            <label class="form-label">Booking</label>
            <select name="booking_id" class="form-select" required>
                <option value="">-- Chọn Booking --</option>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}">Booking #{{ $b->id }} - Tour {{ $b->tour_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- chọn customer --}}
        <div class="mb-3">
            <label class="form-label">Khách hàng</label>
            <select name="customer_id" class="form-select" required>
                <option value="">-- Chọn Khách hàng --</option>
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
                <option value="">-- Chọn giới tính --</option>
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
            <textarea class="form-control" name="note" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Xác nhận</button>
    </form>
@endsection
