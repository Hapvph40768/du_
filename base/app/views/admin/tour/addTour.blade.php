@extends('layout.dashboard')
@section('title', 'Thêm tour')

@section('active-tours', 'active')
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

    <a href="{{ route('list-tours') }}">
        <button type="button" class="btn btn-warning">Quay lại</button>
    </a>

    <form action="{{ route('post-tour') }}" method="post" enctype="multipart/form-data">
        {{-- tên tour --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên tour</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        {{-- slug --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug (SEO URL)</label>
            <input type="text" class="form-control" name="slug">
        </div>

        {{-- mô tả --}}
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả tour</label>
            <textarea class="form-control" name="description" rows="3" required></textarea>
        </div>

        {{-- giá tour --}}
        <div class="mb-3">
            <label for="price" class="form-label">Giá tour</label>
            <input type="number" class="form-control" name="price" step="0.01" required>
        </div>

        {{-- thời gian tour --}}
        <div class="mb-3">
            <label for="days" class="form-label">Số ngày tour</label>
            <input type="number" class="form-control" name="days" min="1" required>
        </div>

        {{-- điểm khởi hành --}}
        <div class="mb-3">
            <label for="start_location" class="form-label">Điểm khởi hành</label>
            <input type="text" class="form-control" name="start_location">
        </div>

        {{-- điểm đến --}}
        <div class="mb-3">
            <label for="destination" class="form-label">Điểm đến</label>
            <input type="text" class="form-control" name="destination">
        </div>

        {{-- thumbnail --}}
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Ảnh đại diện (thumbnail)</label>
            <input type="file" class="form-control" name="thumbnail" accept="image/*">
        </div>

        {{-- loại tour --}}
        <div class="mb-3">
            <label for="category" class="form-label">Loại tour</label>
            <input type="text" class="form-control" name="category" placeholder="Ví dụ: nature, city">
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="active">Còn mở</option>
                <option value="inactive">Đã đóng</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Xác nhận</button>
        </div>
    </form>
@endsection