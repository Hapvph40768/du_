@extends('layout.dashboard')
@section('title', 'Thêm khách hàng')

@section('active-customer', 'active')
@section('content')
    <h3 class="mb-4">Thêm khách hàng</h3>

    <form action="{{ route('post-customer') }}" method="POST">
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Quốc tịch</label>
            <input type="text" name="nationality" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="dob" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-select" required>
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
                <option value="other">Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('list-customer') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
