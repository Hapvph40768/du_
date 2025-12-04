@extends('layout.dashboard')
@section('title', 'Sửa khách trong booking')

@section('active-booking-customer', 'active')
@section('content')
    <h3>Sửa khách trong booking</h3>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul>
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

    <form action="{{ route('edit-booking-customer/' . $detail->id) }}" method="post">
        {{-- chọn booking --}}
        <div class="mb-3">
            <label class="form-label">Booking</label>
            <select name="booking_id" class="form-select" required>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $detail->booking_id ? 'selected' : '' }}>
                        Booking #{{ $b->id }} - Tour {{ $b->tour_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- chọn customer --}}
        <div class="mb-3">
            <label class="form-label">Khách hàng</label>
            <select name="customer_id" class="form-select" required>
                @foreach($customers as $cus)
                    <option value="{{ $cus->id }}" {{ $cus->id == $detail->customer_id ? 'selected' : '' }}>
                        {{ $cus->fullname }} - {{ $cus->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- họ tên --}}
        <div class="mb-3">
            <label for="fullname" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="fullname" value="{{ $detail->fullname }}" required>
        </div>

        {{-- giới tính --}}
        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select name="gender" class="form-select" required>
                <option value="male" {{ $detail->gender === 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ $detail->gender === 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ $detail->gender === 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        {{-- ngày sinh --}}
        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" name="dob" value="{{ $detail->dob }}" required>
        </div>

        {{-- ghi chú --}}
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea class="form-control" name="note">{{ $detail->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
    </form>
@endsection