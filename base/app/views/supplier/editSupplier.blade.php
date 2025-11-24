@extends('admin.dashboard')
@section('title')

@section('active-supplier', 'active')
@section('content')
    <h3>Cập Nhật Nhà Cung Cấp: {{ $detail->name ?? 'Không tìm thấy' }}</h3>

    {{-- Hiển thị thông báo lỗi (errors) --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <ul>
                @foreach($_SESSION['errors'] as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        {{-- Xóa session errors sau khi hiển thị --}}
        @php unset($_SESSION['errors']) @endphp
    @endif

    {{-- Hiển thị thông báo thành công (success) --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px;">
            <span>{{$_SESSION['success']}}</span>
        </div>
        {{-- Xóa session success sau khi hiển thị --}}
        @php unset($_SESSION['success']) @endphp
    @endif

    {{-- Kiểm tra xem $detail có tồn tại không trước khi render form --}}
    @if(isset($detail))
        <form action="{{route('edit-supplier/' . $detail->id)}}" method="post">
            {{-- Tên nhà cung cấp --}}
            <div class="mb-3">
                <label for="name" class="form-label">Tên Nhà Cung Cấp</label>
                <input type="text" class="form-control" name="name" value="{{ $detail->name }}" required>
            </div>

            {{-- Tên người liên hệ --}}
            <div class="mb-3">
                <label for="type" class="form-label">Người Liên Hệ</label>
                <input type="text" class="form-control" name="type" value="{{ $detail->type }}" required>
            </div>

            {{-- Số điện thoại --}}
            <div class="mb-3">
                <label for="phone" class="form-label">Số Điện Thoại</label>
                <input type="number" class="form-control" name="phone" value="{{ $detail->phone }}" required>
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="sua">Cập Nhật</button>
                <a href="{{route('list-supplier')}}" class="btn btn-secondary mb-3">Quay lại Danh sách</a>
            </div>
        </form>
    @else
        <p>Không tìm thấy thông tin Nhà Cung Cấp này.</p>
    @endif
@endsection