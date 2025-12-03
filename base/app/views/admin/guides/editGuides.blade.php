@extends('layout.dashboard')
@section('title', 'Sửa hướng dẫn viên')

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

    <form action="{{ route('edit-guide/' . $detail->id) }}" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="user_id" class="form-label">Tài khoản liên kết</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- chọn user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ $detail->user_id == $u->id ? 'selected' : '' }}>
                        {{ $u->fullname }} ({{ $u->username }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fullname" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="fullname" value="{{ $detail->fullname }}">
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" name="dob" value="{{ $detail->dob }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone" value="{{ $detail->phone }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $detail->email }}">
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select name="gender" class="form-select">
                <option value="">-- chọn giới tính --</option>
                <option value="male" {{ $detail->gender == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ $detail->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ $detail->gender == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" name="avatar" accept="image/*">
            @if($detail->avatar)
                <img src="{{ $detail->avatar }}" alt="avatar" width="80">
            @endif
        </div>

        <div class="mb-3">
            <label for="languages" class="form-label">Ngôn ngữ</label>
            <input type="text" class="form-control" name="languages" value="{{ $detail->languages }}">
        </div>

        <div class="mb-3">
            <label for="experience_years" class="form-label">Số năm kinh nghiệm</label>
            <input type="number" class="form-control" name="experience_years" min="0" value="{{ $detail->experience_years }}">
        </div>

        <div class="mb-3">
            <label for="experience" class="form-label">Mô tả kinh nghiệm</label>
            <textarea class="form-control" name="experience">{{ $detail->experience }}</textarea>
        </div>

        <div class="mb-3">
            <label for="certificate_url" class="form-label">Chứng chỉ (URL)</label>
            <input type="text" class="form-control" name="certificate_url" value="{{ $detail->certificate_url }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active" {{ $detail->status == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                <option value="inactive" {{ $detail->status == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit">Cập nhật</button>
        </div>
    </form>
@endsection