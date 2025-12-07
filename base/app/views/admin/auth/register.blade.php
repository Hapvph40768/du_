@extends('layout.auth')
@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <i class="fas fa-cube mb-3"></i>
        <h4 class="text-white mb-1">Tạo tài khoản mới</h4>
        <p class="text-muted small">Tham gia hệ thống quản lý ngay hôm nay</p>
    </div>

    @if(isset($error))
    <div class="alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ $error }}
    </div>
    @endif

    <form method="POST" action="register">
        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-id-card"></i></span>
                <input type="text" name="full_name" class="form-control border-start-0 ps-0" placeholder="Nguyễn Văn A" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tên đăng nhập</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="username" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="email@example.com" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
            <span>Đăng ký</span> <i class="fas fa-user-plus small"></i>
        </button>
    </form>

    <div class="auth-footer">
        Đã có tài khoản? <a href="login">Đăng nhập ngay</a>
    </div>
</div>

<style>
    /* Inline styles for consistency */
    .input-group-text {
        background-color: var(--input-bg) !important;
        border-color: var(--input-border) !important;
    }
    .form-control {
        border-left: none;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: var(--input-border);
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        border-radius: 8px;
    }
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: var(--primary) !important;
    }
</style>
@endsection