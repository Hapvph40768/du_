@extends('layout.dashboard')
@section('title', 'Sửa khách hàng')

@section('active-customer', 'active')
@section('content')
    <h3 class="mb-4">Sửa khách hàng</h3>

    <form action="{{ route('edit-customer/' . $detail->id) }}" method="POST">
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="fullname" class="form-control" value="{{ $detail->fullname }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ $detail->phone }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $detail->email }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Quốc tịch</label>
            <input type="text" name="nationality" class="form-control" value="{{ $detail->nationality }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="dob" class="form-control" value="{{ $detail->dob }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-select">
                <option value="male" {{ $detail->gender == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ $detail->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ $detail->gender == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" name="address" class="form-control" value="{{ $detail->address }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú</label>
            <textarea name="note" class="form-control">{{ $detail->note }}</textarea>
        </div>

        <button type="submit" name="btn-submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('list-customer') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection