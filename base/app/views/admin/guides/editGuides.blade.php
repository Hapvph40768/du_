@extends('layout.dashboard')
@section('title', 'Sửa hướng dẫn viên')

@section('active-guides', 'active')
@section('content')
    <h3 class="mb-4">Sửa hướng dẫn viên</h3>

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

    <form action="{{ route('edit-guide/' . $detail->id) }}" method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Tài khoản liên kết</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- chọn user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ $detail->user_id == $u->id ? 'selected' : '' }}>
                        {{ $u->fullname }} ({{ $u->username }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="fullname" value="{{ $detail->fullname }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" name="dob" value="{{ $detail->dob }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone" value="{{ $detail->phone }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $detail->email }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Giới tính</label>
            <select name="gender" class="form-select">
                <option value="">-- chọn giới tính --</option>
                <option value="male" {{ $detail->gender == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ $detail->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ $detail->gender == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" name="avatar" accept="image/*">
            @if($detail->avatar)
                <div class="mt-2">
                    <img src="{{ $detail->avatar }}" alt="avatar" width="80" class="img-thumbnail">
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngôn ngữ</label>
            <input type="text" class="form-control" name="languages" value="{{ $detail->languages }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Số năm kinh nghiệm</label>
            <input type="number" class="form-control" name="experience_years" min="0" value="{{ $detail->experience_years }}">
        </div>

        <div class="col-md-12">
            <label class="form-label">Mô tả kinh nghiệm</label>
            <textarea class="form-control" name="experience" rows="3">{{ $detail->experience }}</textarea>
        </div>

        <div class="col-md-6">
            <label class="form-label">Chứng chỉ (URL)</label>
            <input type="text" class="form-control" name="certificate_url" value="{{ $detail->certificate_url }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active" {{ $detail->status == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                <option value="inactive" {{ $detail->status == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
            <a href="{{ route('list-guides') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
@endsection