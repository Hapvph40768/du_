@extends('layout.dashboard')

@section('title', 'Thêm người dùng')

@section('active-user', 'active')

@section('content')
    <div class="page-header mb-4">
        <h1 class="text-white mb-1">Thêm người dùng mới</h1>
        <p class="text-white-50 mb-0">Điền thông tin để tạo tài khoản người dùng mới.</p>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success mb-4">
            {{$_SESSION['success']}}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card-dark p-4">
                <form action="{{ route('post-user') }}" method="post">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Tên đăng nhập <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Họ và tên</label>
                            <input type="text" class="form-control" name="fullname">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Số điện thoại</label>
                            <input type="number" class="form-control" name="phone">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white-50">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Vai trò <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm khóa</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('list-user') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary px-4" name="btn-submit" value="them">Thêm mới</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection