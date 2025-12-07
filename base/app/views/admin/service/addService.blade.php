@extends('layout.dashboard')
@section('title', 'Thêm Dịch vụ')

@section('active-service', 'active')
@section('content')
    <h3>Thêm Dịch vụ Mới</h3>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul>
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    <form action="{{ route('post-service') }}" method="post">
        <div class="mb-3">
            <label>Tên dịch vụ</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label>Gói dịch vụ</label>
            <input type="text" class="form-control" name="package_name">
        </div>

        <div class="mb-3">
            <label>Tour</label>
            <select name="tour_id" class="form-select">
                <option value="">-- Không chọn --</option>
                @foreach($tours as $t)
                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nhà cung cấp</label>
            <select name="supplier_id" class="form-select">
                <option value="">-- Không chọn --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Loại dịch vụ</label>
            <input type="text" class="form-control" name="type">
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea class="form-control" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label>Giá</label>
            <input type="number" step="0.01" class="form-control" name="price" value="0">
        </div>

        <div class="mb-3">
            <label>Giá mặc định</label>
            <input type="number" step="0.01" class="form-control" name="default_price" value="0">
        </div>

        <div class="mb-3">
            <label>Tiền tệ</label>
            <input type="text" class="form-control" name="currency" value="VND" maxlength="3">
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="is_optional" value="1">
            <label class="form-check-label">Dịch vụ tùy chọn</label>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
            <label class="form-check-label">Đang hoạt động</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3" name="btn-submit">Thêm</button>
        <a href="{{ route('list-service') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
@endsection