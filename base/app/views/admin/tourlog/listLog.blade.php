@extends('layout.dashboard')
@section('title', 'Nhật ký tour')
@section('content')

    <div class="page-header mb-4 d-flex justify-content-between align-items-end">
        <div>
            <h1 class="text-white mb-1">Quản lý nhật ký tour</h1>
            <p class="text-muted mb-0">Ghi lại chi tiết từng ngày của tour.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="stats-mini-card">
                <div class="label">Tổng bản ghi</div>
                <div class="value text-success text-center">{{ count($logs) }}</div>
            </div>
        </div>
    </div>

    <div class="card-dark p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                <input type="text" class="search-dark ps-5" placeholder="Tìm...">
            </div>
            <a href="{{ route('add-tour-log') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                <i class="bi bi-plus-lg"></i> Thêm nhật ký
            </a>
        </div>

        <div class="card-header bg-transparent border-0 px-0 pb-0">
            <h5 class="text-white mb-0">Danh sách nhật ký</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-dark-custom w-100">
                <thead>
                    <tr>
                        <th style="width: 50%;">Chuyến đi</th>
                        <th style="width: 20%;">Ngày tạo</th>
                        <th style="width: 30%; text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-muted">
                                {{ $log->start_date ? date('d/m/Y', strtotime($log->start_date)) . ' - ' . date('d/m/Y', strtotime($log->end_date)) : 'N/A' }}
                            </td>
                            <td class="text-muted">{{ date('d/m/Y H:i', strtotime($log->created_at)) }}</td>
                            <td class="text-end">
                                <a href="{{ route('detail-tour-log/' . $log->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('delete-tour-log/' . $log->id) }}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Xóa?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Chưa có nhật ký</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection