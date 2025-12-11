<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Đăng nhập hệ thống')</title>
    
    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Light Theme Palette */
            --bg-dark: #f3f4f6;       /* Using same name for compatibility, but value is Light Gray */
            --bg-card: #ffffff;       /* White */
            --text-light: #111827;    /* Slate 900 (Dark Text) */
            --text-muted: #6b7280;    /* Slate 500 */
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --input-bg: #ffffff;
            --input-border: #d1d5db;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Lexend', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-image: radial-gradient(circle at top right, rgba(59, 130, 246, 0.05), transparent 40%),
                              radial-gradient(circle at bottom left, rgba(168, 85, 247, 0.05), transparent 40%);
        }

        .auth-card {
            background-color: var(--bg-card);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo i {
            font-size: 3rem;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-label {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-light);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: var(--input-bg);
            border-color: var(--primary);
            color: var(--text-light);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-primary {
            background: linear-gradient(45deg, #3b82f6, #6366f1);
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .auth-footer a:hover {
            color: #60a5fa;
            text-decoration: underline;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #ef4444;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* COMPATIBILITY OVERRIDES for Dark Mode Classes on Light Theme */
        .text-white { color: var(--text-light) !important; }
        .text-white-50 { color: var(--text-muted) !important; }
        .bg-dark { background-color: #ffffff !important; color: var(--text-light) !important; border: 1px solid #e5e7eb !important; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>