<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @include('layout.script')

    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1100;
            padding: 12px 20px;
            background: #2c3e50;
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            position: fixed;
            left: 0;
            top: 56px;
            bottom: 0;
            background: #34495e;
            padding-top: 20px;
            overflow-y: auto;
            transition: all 0.3s;
            box-shadow: 2px 0 8px rgba(0,0,0,0.1);
            border-right: 1px solid #2c3e50;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ecf0f1;
            text-decoration: none;
            font-size: 16px;
            border-radius: 8px;
            margin: 4px 12px;
            transition: all 0.2s;
        }

        .sidebar a:hover {
            background: #1abc9c;
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: #16a085;
            color: #fff;
            font-weight: 600;
        }

        /* Content */
        .content {
            margin-left: 270px;
            margin-top: 80px;
            padding: 20px;
        }

        /* Cards inside content */
        .content .card {
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }

        .content .card:hover {
            transform: translateY(-3px);
        }

        /* Scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
@include('layout.admin.blocks.header')
<!-- Sidebar -->
@include('layout.admin.blocks.aside')
<!-- Content -->
<div class="content">
    @yield('content-main')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
