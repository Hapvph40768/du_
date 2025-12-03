<h2>Đăng nhập</h2>
<form method="POST" action="login">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Đăng nhập</button>
</form>
@if(isset($error))
    <p style="color:red">{{ $error }}</p>
@endif
<a href="register">Chưa có tài khoản? Đăng ký</a>