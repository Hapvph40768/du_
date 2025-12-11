@extends('layout.dashboard')
@section('title', 'Quản lý Tour Guide')
@section('active-tour-guide', 'active')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h1 class="text-white mb-1">Quản lý Tour Guide</h1>
        <p class="text-muted mb-0">Xem và xử lý danh sách hướng dẫn viên cho các chuyến đi.</p>
    </div>

    {{-- Stats --}}
    @php
        $totalGuides = count($guides);
    @endphp

    <div class="d-flex gap-3">
        <div class="stats-mini-card">
            <div class="label">Tổng số Guide</div>
            <div class="value text-white text-center">{{ $totalGuides }}</div>
        </div>
    </div>
</div>

{{-- Alerts --}}
@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ $_SESSION['success'] }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i> Đã xảy ra lỗi
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card-dark p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <span class="text-muted text-uppercase fw-bold">Danh sách Tour Guide</span>
        <a href="{{ route('add-tour-guide') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
            <i class="bi bi-plus-lg"></i> Thêm Tour Guide
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark-custom w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hướng dẫn viên</th>
                    <th>Vai trò</th>
                    <th>Chuyến đi</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th style="text-align:center;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guides as $index => $g)
                <tr>
                    <td class="text-white-50">{{ $index + 1 }}</td>
                    <td class="text-white">{{ $g->guide_name }}</td>
                    <td>
                        @if($g->role === 'main')
                            <span class="badge bg-primary">Trưởng đoàn</span>
                        @elseif($g->role === 'assistant')
                            <span class="badge bg-info text-dark">Phó đoàn</span>
                        @else
                            <span class="badge bg-secondary">Hỗ trợ</span>
                        @endif
                    </td>
                    <td class="text-white">{{ $g->tour_name }}</td>
                    <td class="text-white-50">
                        @php $start = $g->start_date ?? $g->booking_start_date; @endphp
                        {{ $start ? date('d/m/Y', strtotime($start)) : '---' }}
                    </td>
                    <td class="text-white-50">
                        @php $end = $g->end_date ?? $g->booking_end_date; @endphp
                        {{ $end ? date('d/m/Y', strtotime($end)) : '---' }}
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-link text-white-50" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="{{ route('detail-tour-guide/'.$g->id) }}"><i class="bi bi-pencil me-2"></i>Sửa</a></li>
                                <li>
                                    <button class="dropdown-item text-danger" onclick="confirmDelete('{{ route('delete-tour-guide/'.$g->id) }}')">
                                        <i class="bi bi-trash me-2"></i>Xóa
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Chưa có tour guide nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(url) {
        if (confirm("Bạn có chắc muốn xóa tour guide này không?")) {
            window.location.href = url;
        }
    }
</script>
@endsection