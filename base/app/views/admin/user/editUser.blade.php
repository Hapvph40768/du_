@extends('layout.dashboard')

@section('title', 'Sửa người dùng')

@section('active-user', 'active')

@section('content')
<h2>Chỉnh sửa người dùng</h2>

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <a href="{{route('list-user')}}">
        <button type="button" class="btn btn-warning">Quay lai</button>
    </a>
<form action="{{ route('edit-user/' . $detail->id) }}" method="post">
    {{-- Chọn role --}}
    <div class="mb-3">
        <label for="role_id" class="form-label">Chọn chức năng:</label>
        <select name="role_id" id="role_id" class="form-select">
            <option value="">-- Chọn chức năng --</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" 
                    {{ isset($detail->role_id) && $role->id == $detail->role_id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Username --}}
    <div class="mb-3">
        <label for="username" class="form-label">Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" value="{{ $detail->username }}">
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu <small>(để trống nếu không đổi)</small></label>
        <input type="password" name="password" class="form-control">
    </div>

    {{-- Fullname --}}
    <div class="mb-3">
        <label for="fullname" class="form-label">Họ tên</label>
        <input type="text" name="fullname" class="form-control" value="{{ $detail->fullname }}">
    </div>

    {{-- Phone --}}
    <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại</label>
        <input type="text" name="phone" class="form-control" value="{{ $detail->phone }}">
    </div>

    {{-- Status --}}
    <div class="mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select name="status" id="status" class="form-select">
            <option value="1" {{ $detail->status == 0 ? 'selected' : '' }}>Hoạt động</option>
            <option value="0" {{ $detail->status == 1 ? 'selected' : '' }}>Đóng</option>
        </select>
    </div>

    <button type="submit" name="btn-submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection
