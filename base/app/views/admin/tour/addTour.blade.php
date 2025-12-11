@extends('layout.dashboard')
@section('title', 'Thêm tour')

@section('active-tours', 'active')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-map-marked-alt"></i> Thêm tour mới</h2>
        <a href="{{ route('list-tours') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <form action="{{ route('post-tour') }}" method="post" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
        {{-- tên tour --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Tên tour</label>
            <input type="text" class="form-control" name="name" placeholder="Ví dụ: Khám phá Tam Cốc" required>
        </div>

        {{-- slug --}}
        <div class="mb-3">
            <label for="slug" class="form-label fw-bold">Slug (SEO URL)</label>
            <input type="text" class="form-control" name="slug" placeholder="tam-coc-tour">
        </div>

        {{-- mô tả --}}
        <div class="mb-3">
            <label for="description" class="form-label fw-bold">Mô tả tour</label>
            <textarea class="form-control" name="description" rows="4" placeholder="Giới thiệu ngắn gọn về hành trình..." required></textarea>
        </div>

        {{-- giá tour --}}
        <div class="mb-3">
            <label for="price" class="form-label fw-bold">Giá tour (VNĐ)</label>
            <input type="number" class="form-control" name="price" step="1000" placeholder="Ví dụ: 2000000" required>
        </div>



        {{-- điểm khởi hành --}}
        <div class="mb-3">
            <label for="start_location" class="form-label fw-bold">Điểm khởi hành</label>
            <input type="text" class="form-control" name="start_location" placeholder="Ví dụ: Hà Nội">
        </div>

        {{-- điểm đến --}}
        <div class="mb-3">
            <label for="destination" class="form-label fw-bold">Điểm đến</label>
            <input type="text" class="form-control" name="destination" placeholder="Ví dụ: Tam Cốc">
        </div>

        {{-- thumbnail --}}
        <div class="mb-3">
            <label for="thumbnail" class="form-label fw-bold">Ảnh đại diện (thumbnail)</label>
            <input type="file" class="form-control" name="thumbnail" accept="image/*">
        </div>

        {{-- loại tour --}}
        <div class="mb-3">
            <label for="category" class="form-label fw-bold">Loại tour</label>
            <select name="category" class="form-select">
                <option value="">-- Chọn loại tour --</option>
                <option value="domestic">Trong nước</option>
                <option value="international">Quốc tế</option>
            </select>
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label fw-bold">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="active">Còn mở</option>
                <option value="inactive">Đã đóng</option>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit" value="them">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>
@endsection