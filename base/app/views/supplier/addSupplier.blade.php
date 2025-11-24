@extends('admin.dashboard')
@section('title')

@section('active-supplier', 'active')
@section('content')
    <h3>Thêm Nhà Cung Cấp Mới</h3>

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

    <form action="{{route('post-supplier')}}" method="post">
        {{-- Tên nhà cung cấp --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên Nhà Cung Cấp</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        {{-- Tên người liên hệ --}}
        <div class="mb-3">
            <label for="type" class="form-label">Người Liên Hệ</label>
            <input type="text" class="form-control" name="type" required>
        </div>

        {{-- Số điện thoại --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Số Điện Thoại</label>
            <input type="number" class="form-control" name="phone" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Thêm Nhà Cung Cấp</button>
            <a href="{{route('list-supplier')}}" class="btn btn-secondary mb-3">Quay lại Danh sách</a>
        </div>
    </form>
@endsection