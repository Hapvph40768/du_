@extends('admin.dashboard')
@section('title', 'Thêm điểm danh khách')
@section('active-attendance', 'active')
@section('content')

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger">
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div class="alert alert-success">
        {{ $_SESSION['success'] }}
    </div>
@endif

<a href="{{ BASE_URL }}list-attendance/{{ $departureId }}">
    <button type="button" class="btn btn-warning mb-3">Quay lại danh sách</button>
</a>

<form action="{{ BASE_URL }}add-attendance/{{ $departureId }}" method="POST">
    <input type="hidden" name="departure_id" value="{{ $departureId }}">

    {{-- Chọn khách hàng --}}
    <div class="mb-3">
        <label for="customer_id" class="form-label">Chọn khách hàng</label>
        <select name="customer_id" id="customer_id" class="form-select" required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">
                    {{ $customer->fullname }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Trạng thái điểm danh --}}
    <div class="mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select name="status" id="status" class="form-select" required>
            <option value="pending">Chưa điểm danh</option>
            <option value="present">Có mặt</option>
            <option value="absent">Vắng mặt</option>
            <option value="late">Đi muộn</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Lưu điểm danh</button>
</form>

@endsection
