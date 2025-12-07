@extends('layout.dashboard')
@section('title', 'Danh sách Hướng dẫn viên')
@section('active-guide', 'active')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h1 class="text-white mb-1">Hướng dẫn viên</h1>
        <p class="text-muted mb-0">Quản lý đội ngũ hướng dẫn viên, phân lịch và theo dõi trạng thái.</p>
    </div>

    @php
        $totalGuides = count($guides);
        $activeGuides = 0;
        foreach($guides as $g) {
            if($g->status === 'active') $activeGuides++;
        }
    @endphp

    <div class="d-flex gap-3">
        <div class="stats-mini-card">
            <div class="label">Tổng số HDV</div>
            <div class="value text-white text-center">{{ $totalGuides }}</div>
        </div>
        <div class="stats-mini-card">
            <div class="label">Đang hoạt động</div>
            <div class="value text-success text-center">{{ $activeGuides }}</div>
        </div>
    </div>
</div>

@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert" style="background: rgba(34, 197, 94, 0.2); border: 1px solid var(--success); color: #fff;">
        <i class="bi bi-check-circle me-2"></i> {{ $_SESSION['success'] }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert" style="background: rgba(239, 68, 68, 0.2); border: 1px solid var(--danger); color: #fff;">
        <i class="bi bi-exclamation-circle me-2"></i>
        @foreach($_SESSION['errors'] as $error)
            <span>{{ $error }}</span><br>
        @endforeach
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card-dark p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">Bộ lọc</span>
            <button class="filter-btn active">Tất cả</button>
            <button class="filter-btn">Đang rảnh</button>
            <button class="filter-btn">Đang dẫn tour</button>
        </div>
        
        <div class="d-flex gap-3">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                <input type="text" class="search-dark ps-5" placeholder="Tìm tên hoặc SĐT...">
            </div>
            <a href="{{ route('add-guide') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                <i class="bi bi-plus-lg"></i> Thêm HDV
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom w-100">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 25%;">Họ tên / Account</th>
                    <th style="width: 20%;">Liên hệ</th>
                    <th style="width: 15%;">Kinh nghiệm</th>
                    <th style="width: 10%;">Giới tính</th>
                    <th style="width: 15%;">Trạng thái</th>
                    <th style="width: 10%; text-align: center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guides as $index => $g)
                <tr>
                    <td class="text-white-50">{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if($g->avatar)
                                <img src="{{ str_replace('/public', 'public', $g->avatar) }}" class="tour-avatar rounded-circle" alt="user" onerror="this.src='/public/img/user-placeholder.png'">
                            @else
                                <div class="tour-avatar rounded-circle d-flex align-items-center justify-content-center text-muted bg-secondary bg-opacity-10">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold text-white">{{ $g->fullname }}</div>
                                <div class="text-white-50 small">@ {{ $g->account_name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-white small mb-1"><i class="bi bi-telephone me-1"></i>{{ $g->phone }}</div>
                        <div class="text-white-50 small"><i class="bi bi-envelope me-1"></i>{{ $g->email }}</div>
                    </td>
                    <td>
                        <div class="text-white">{{ $g->experience_years }} năm</div>
                        <div class="text-white-50 small" style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $g->languages ?? 'Tiếng Việt' }}</div>
                    </td>
                     <td>
                        <span class="badge {{ $g->gender === 'Nam' ? 'bg-info' : 'bg-warning' }} text-dark border-0">
                            {{ $g->gender }}
                        </span>
                    </td>
                    <td>
                        @if($g->status === 'active')
                            <span class="dot-status dot-success"></span> <span class="text-success small">Đang hoạt động</span>
                        @else
                            <span class="dot-status dot-danger"></span> <span class="text-white-50 small">Ngừng hoạt động</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-white-50" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('detail-guide/'.$g->id) }}"><i class="bi bi-pencil me-2"></i>Sửa thông tin</a></li>
                                <li>
                                    <button class="dropdown-item text-danger" onclick="confirmDelete('{{ route('delete-guide/'.$g->id) }}', '{{ $g->fullname }}')">
                                        <i class="bi bi-trash me-2"></i>Xóa HDV
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Chưa có hướng dẫn viên nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(url, name) {
        if (confirm(`Bạn có chắc chắn muốn xóa HDV: ${name}?`)) {
            window.location.href = url;
        }
    }
</script>
@endsection