@extends('layout.main')

@section('content-tour')

    <h2>Đăng ký</h2>

    {{-- HIỂN THỊ LỖI --}}
    @if(isset($_SESSION['error_register']))
        <ul style="color: red;">
            @foreach($_SESSION['error_register'] as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <?php unset($_SESSION['error_register']); ?>
    @endif

    {{-- HIỂN THỊ THÔNG BÁO --}}
    @if(isset($_SESSION['success']))
        <p style="color:green;">{{ $_SESSION['success'] }}</p>
        <?php unset($_SESSION['success']); ?>
    @endif

    <form action="{{ BASE_URL }}registerPost" method="post">

        <label>Họ và tên</label>
        <input type="text" name="fullname" placeholder="Nhập họ tên">

        <label>Số điện thoại</label>
        <input type="text" name="phone" placeholder="Nhập số điện thoại">

        <label>Tên đăng nhập</label>
        <input type="text" name="username" placeholder="Nhập tên đăng nhập">

        <label>Mật khẩu</label>
        <input type="password" name="password" placeholder="Nhập mật khẩu">

        <button type="submit">Đăng ký</button>
    </form>

    <p>Bạn đã có tài khoản? <a href="{{ BASE_URL }}login">Đăng nhập</a></p>

@endsection
