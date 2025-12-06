@extends('admin.dashboard')
@section('title', 'Thêm Hướng Dẫn Viên')

@section('active-guides', 'active')
@section('content')
<div class="container mt-4">

    {{-- Hiển thị lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <form action="{{ route('post-guides') }}" method="post" enctype="multipart/form-data" class="mt-3">
        {{-- CSRF nếu dùng Laravel chuẩn --}}
        @csrf

        <div class="mb-3">
            <label class="form-label">Tài khoản liên kết</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- chọn user --</option>
                <?php foreach($users as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['fullname'].' ('.$u['username'].')') ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="dob" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" name="avatar" accept="image/*" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Ngôn ngữ</label>
            <input type="text" name="languages" placeholder="Tiếng Việt, Tiếng Anh" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Số năm kinh nghiệm</label>
            <input type="number" name="experience_years" min="0" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Thêm HDV</button>
    </form>
</div>
@endsection
