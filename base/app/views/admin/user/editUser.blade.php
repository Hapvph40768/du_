@extends('layout.dashboard')

@section('title', 'Sửa người dùng')

@section('active-user', 'active')

@section('content')

    <div class="page-header mb-4">
        <h1 class="text-white mb-1">Chỉnh sửa người dùng</h1>
        <p class="text-white-50 mb-0">Cập nhật thông tin và phân quyền người dùng.</p>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card-dark p-4">
                <form action="{{ route('edit-user/' . $detail->id) }}" method="post">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Tên đăng nhập <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" value="{{ $detail->username }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Mật khẩu <small>(để trống nếu không đổi)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập để đổi mật khẩu mới">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Họ và tên</label>
                            <input type="text" name="fullname" class="form-control" value="{{ $detail->fullname }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ $detail->phone }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white-50">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $detail->email }}">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Vai trò <span class="text-danger">*</span></label>
                            <select name="role_id" id="role_id" class="form-select" required>
                                <option value="">-- Chọn vai trò --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" 
                                        {{ isset($detail->role_id) && $role->id == $detail->role_id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ $detail->is_active == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $detail->is_active == 0 ? 'selected' : '' }}>Tạm khóa</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('list-user') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        <button type="submit" name="btn-submit" class="btn btn-primary px-4">Cập nhật</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
