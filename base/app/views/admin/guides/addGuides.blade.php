@extends('layout.dashboard')
@section('title', 'Thêm hướng dẫn viên')

@section('active-guides', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{ $_SESSION['success'] }}</span>
    @endif

    <form action="{{ route('post-guides') }}" method="post" enctype="multipart/form-data">
        <label>Tài khoản liên kết</label>
        <select name="user_id" required>
            <option value="">-- chọn user --</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->fullname }} ({{ $u->username }})</option>
            @endforeach
        </select><br>

        <label>Họ tên</label>
        <input type="text" name="fullname" required><br>

        <label>Ngày sinh</label>
        <input type="date" name="dob"><br>

        <label>Số điện thoại</label>
        <input type="text" name="phone"><br>

        <label>Email</label>
        <input type="email" name="email"><br>

        <label>Giới tính</label>
        <select name="gender">
            <option value="">-- chọn giới tính --</option>
            <option value="male">Nam</option>
            <option value="female">Nữ</option>
            <option value="other">Khác</option>
        </select><br>

        <label>Ảnh đại diện</label>
        <input type="file" name="avatar" accept="image/*"><br>

        <label>Ngôn ngữ</label>
        <input type="text" name="languages" placeholder="Ví dụ: Tiếng Việt, Tiếng Anh"><br>

        <label>Số năm kinh nghiệm</label>
        <input type="number" name="experience_years" min="0"><br>

        <label>Mô tả kinh nghiệm</label>
        <textarea name="experience"></textarea><br>

        <label>Chứng chỉ (URL)</label>
        <input type="text" name="certificate_url" placeholder="http://..."><br>

        <label>Trạng thái</label>
        <select name="status">
            <option value="active">Đang hoạt động</option>
            <option value="inactive">Ngừng hoạt động</option>
        </select><br>

        <button type="submit" name="btn-submit">Thêm hướng dẫn viên</button>
    </form>
@endsection