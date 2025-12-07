@extends('layout.dashboard')
@section('title', 'Sửa Dịch vụ')

@section('active-service', 'active')
@section('content')
    <h3>Sửa Dịch vụ: {{ $detail->name }}</h3>

    {{-- Hiển thị thông báo lỗi --}}
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

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <form action="{{ route('edit-service/' . $detail->id) }}" method="post">
        {{-- Tên dịch vụ --}}
        <div class="mb-3">
            <label class="form-label">Tên dịch vụ</label>
            <input type="text" class="form-control" name="name" value="{{ $detail->name }}" required>
        </div>

        {{-- Gói dịch vụ --}}
        <div class="mb-3">
            <label class="form-label">Gói dịch vụ</label>
            <input type="text" class="form-control" name="package_name" value="{{ $detail->package_name }}">
        </div>

        {{-- Tour --}}
        <div class="mb-3">
            <label class="form-label">Tour</label>
            <select name="tour_id" class="form-select">
                <option value="">-- Không chọn --</option>
                @foreach($tours as $t)
                    <option value="{{ $t->id }}" {{ $t->id == $detail->tour_id ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nhà cung cấp --}}
        <div class="mb-3">
            <label class="form-label">Nhà cung cấp</label>
            <select name="supplier_id" class="form-select">
                <option value="">-- Không chọn --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}" {{ $sup->id == $detail->supplier_id ? 'selected' : '' }}>
                        {{ $sup->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Loại dịch vụ --}}
        <div class="mb-3">
            <label class="form-label">Loại dịch vụ</label>
            <input type="text" class="form-control" name="type" value="{{ $detail->type }}">
        </div>

        {{-- Mô tả --}}
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="description" rows="4">{{ $detail->description }}</textarea>
        </div>

        {{-- Giá --}}
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" step="0.01" class="form-control" name="price" value="{{ $detail->price }}">
        </div>

        {{-- Giá mặc định --}}
        <div class="mb-3">
            <label class="form-label">Giá mặc định</label>
            <input type="number" step="0.01" class="form-control" name="default_price" value="{{ $detail->default_price }}">
        </div>

        {{-- Tiền tệ --}}
        <div class="mb-3">
            <label class="form-label">Tiền tệ</label>
            <input type="text" class="form-control" name="currency" value="{{ $detail->currency }}" maxlength="3">
        </div>

        {{-- Tùy chọn --}}
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="is_optional" value="1" {{ $detail->is_optional ? 'checked' : '' }}>
            <label class="form-check-label">Dịch vụ tùy chọn</label>
        </div>

        {{-- Trạng thái hoạt động --}}
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ $detail->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Đang hoạt động</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3" name="btn-submit">Cập nhật</button>
        <a href="{{ route('list-service') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
@endsection