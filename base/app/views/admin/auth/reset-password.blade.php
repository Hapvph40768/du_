@extends('layout.auth')
@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <i class="fas fa-lock-open mb-3"></i>
        <h4 class="text-white mb-1">Đặt lại mật khẩu</h4>
        <p class="text-muted small">Nhập mật khẩu mới của bạn</p>
    </div>

    @if(isset($error))
    <div class="alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ $error }}
    </div>
    @endif

    <form method="POST" action="reset-password">
        <input type="hidden" name="token" value="{{ $token ?? '' }}">
        <input type="hidden" name="email" value="{{ $email ?? '' }}">
        
        <div class="mb-3">
            <label class="form-label">Mật khẩu mới</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-muted"><i class="fas fa-check-double"></i></span>
                <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
            <span>Đổi mật khẩu</span> <i class="fas fa-save small"></i>
        </button>
    </form>

    <div class="auth-footer">
        <a href="login">Quay lại đăng nhập</a>
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
