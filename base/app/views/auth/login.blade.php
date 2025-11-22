@extends('layout.main')

@section('content-tour')

    <h2>Đăng nhập</h2>

    {{-- HIỂN THỊ LỖI --}}
    @if(isset($_SESSION['errors']))
        <ul style="color: red;">
            @foreach($_SESSION['errors'] as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <?php unset($_SESSION['errors']); ?>
    @endif

    {{-- HIỂN THỊ THÔNG BÁO --}}
    @if(isset($_SESSION['success']))
        <p style="color:green;">{{ $_SESSION['success'] }}</p>
        <?php unset($_SESSION['success']); ?>
    @endif

    <form action="{{ BASE_URL }}loginPost" method="post">

        <label>Tên đăng nhập</label>
        <input type="text" name="username" placeholder="Nhập tên đăng nhập">

        <label>Mật khẩu</label>
        <input type="password" name="password" placeholder="Nhập mật khẩu">

        <button type="submit">Đăng nhập</button>
    </form>

    <p>Bạn chưa có tài khoản? <a href="{{ BASE_URL }}register">Đăng ký</a></p>

@endsection
