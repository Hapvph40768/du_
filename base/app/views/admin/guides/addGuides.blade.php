@extends('layout.dashboard')
@section('title', 'Thêm hướng dẫn viên')

@section('active-guides', 'active')
@section('content')
    <h3 class="mb-4">Thêm hướng dẫn viên</h3>

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

    <form action="{{ route('post-guide') }}" method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Tài khoản liên kết</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- chọn user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->fullname }} ({{ $u->username }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Họ tên</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="dob" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-select">
                <option value="">-- chọn giới tính --</option>
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
                <option value="other">Khác</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" name="avatar" class="form-control" accept="image/*">
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngôn ngữ</label>
            <input type="text" name="languages" class="form-control" placeholder="Ví dụ: Tiếng Việt, Tiếng Anh">
        </div>

        <div class="col-md-6">
            <label class="form-label">Số năm kinh nghiệm</label>
            <input type="number" name="experience_years" class="form-control" min="0">
        </div>

        <div class="col-md-12">
            <label class="form-label">Mô tả kinh nghiệm</label>
            <textarea name="experience" class="form-control" rows="3"></textarea>
        </div>

        <div class="col-md-6">
            <label class="form-label">Chứng chỉ (URL)</label>
            <input type="text" name="certificate_url" class="form-control" placeholder="http://...">
        </div>

        <div class="col-md-6">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active">Đang hoạt động</option>
                <option value="inactive">Ngừng hoạt động</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" name="btn-submit" class="btn btn-primary">Thêm hướng dẫn viên</button>
            <a href="{{ route('list-guides') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
@endsection