@extends('layout.dashboard')
@section('title', 'Cập Nhật Nhà Cung Cấp')

@section('active-supplier', 'active')
@section('content')
    <h3>Cập Nhật Nhà Cung Cấp: {{ $detail->name ?? 'Không tìm thấy' }}</h3>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
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
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px;">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    {{-- Kiểm tra xem $detail có tồn tại không trước khi render form --}}
    @if(isset($detail))
        <form action="{{ route('edit-supplier/' . $detail->id) }}" method="post">
            {{-- Tên nhà cung cấp --}}
            <div class="mb-3">
                <label for="name" class="form-label">Tên Nhà Cung Cấp</label>
                <input type="text" class="form-control" name="name" value="{{ $detail->name }}" required>
            </div>

            {{-- Loại nhà cung cấp --}}
            <div class="mb-3">
                <label for="type" class="form-label">Loại Nhà Cung Cấp</label>
                <select name="type" class="form-select" required>
                    <option value="hotel" {{ $detail->type === 'hotel' ? 'selected' : '' }}>Khách sạn</option>
                    <option value="restaurant" {{ $detail->type === 'restaurant' ? 'selected' : '' }}>Nhà hàng</option>
                    <option value="transport" {{ $detail->type === 'transport' ? 'selected' : '' }}>Vận chuyển</option>
                    <option value="activity" {{ $detail->type === 'activity' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="other" {{ $detail->type === 'other' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>

            {{-- Số điện thoại --}}
            <div class="mb-3">
                <label for="phone" class="form-label">Số Điện Thoại</label>
                <input type="text" class="form-control" name="phone" value="{{ $detail->phone }}">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $detail->email }}">
            </div>

            {{-- Địa chỉ --}}
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" name="address" value="{{ $detail->address }}">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="sua">Cập Nhật</button>
                <a href="{{ route('list-supplier') }}" class="btn btn-secondary mb-3">Quay lại Danh sách</a>
            </div>
        </form>
    @else
        <p>Không tìm thấy thông tin Nhà Cung Cấp này.</p>
    @endif
@endsection