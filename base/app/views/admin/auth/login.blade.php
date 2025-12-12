@extends('layout.auth')
@section('title', 'Đăng nhập hệ thống')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <i class="fas fa-cube mb-3"></i>
        <h4 class="text-white mb-1">Chào mừng trở lại!</h4>
        <p class="text-muted small">Đăng nhập để quản lý hệ thống</p>
    </div>

    @if(isset($error))
    <div class="alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ $error }}
    </div>
    @endif

    @if(isset($success))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
         <i class="fas fa-check-circle"></i> {{ $success }}
    </div>
    @endif

    <form method="POST" action="login">
        <div class="mb-3">
            <label class="form-label">Tên đăng nhập</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Nhập username" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input bg-dark border-secondary" type="checkbox" id="remember">
                <label class="form-check-label text-muted small" for="remember">Ghi nhớ đăng nhập</label>
            </div>
            <a href="forgot-password" class="text-muted small text-decoration-none">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
            <span>Đăng nhập</span> <i class="fas fa-arrow-right small"></i>
        </button>
    </form>

    <div class="auth-footer">
        Bạn chưa có tài khoản? <a href="register">Đăng ký ngay</a>
    </div>
</div>

<style>
    /* Inline styles specific to form elements override if needed */
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