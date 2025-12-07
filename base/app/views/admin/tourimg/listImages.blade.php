@extends('layout.dashboard')
@section('title', 'Quản lý ảnh tour')
@section('content')

    <div class="page-header mb-4 d-flex justify-content-between align-items-end">
        <div>
            <h1 class="text-white mb-1">Quản lý ảnh tour</h1>
            <p class="text-muted mb-0">Thêm, chỉnh sửa và quản lý ảnh cho các tour du lịch.</p>
        </div>
        <div class="d-flex gap-3">
            <div class="stats-mini-card">
                <div class="label">Tổng ảnh</div>
                <div class="value text-success text-center">{{ count($images) }}</div>
            </div>
        </div>
    </div>

    <div class="card-dark p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex gap-3">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                    <input type="text" class="search-dark ps-5" placeholder="Tìm theo tour...">
                </div>
                <a href="{{ route('add-tour-image') }}"
                    class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                    <i class="bi bi-plus-lg"></i> Thêm ảnh
                </a>
            </div>
        </div>

        <div class="card-header bg-transparent border-0 px-0 pb-0">
            <h5 class="text-white mb-0">Danh sách ảnh tour</h5>
        </div>
        <p class="text-muted small mb-3">Quản lý tất cả ảnh liên quan đến các tour.</p>

        <div class="table-responsive">
            <table class="table table-dark-custom w-100">
                <thead>
                    <tr>
                        <th style="width: 15%;">Ảnh</th>
                        <th style="width: 35%;">Tour</th>
                        <th style="width: 15%;">Loại</th>
                        <th style="width: 20%;">Ngày tạo</th>
                        <th style="width: 15%; text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($images as $img)
                        <tr>
                            <td>
                                @if($img->image_path)
                                    <img src="{{ str_replace('/public', 'public', $img->image_path) }}" class="rounded" alt="ảnh"
                                        style="width: 80px; height: 60px; object-fit: cover;"
                                        onerror="this.onerror=null;this.src='public/img/placeholder.png';">
                                @else
                                    <div class="d-flex align-items-center justify-content-center text-muted rounded"
                                        style="width: 80px; height: 60px; background: #e9ecef;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="text-white">{{ $img->tour_name ?? 'N/A' }}</td>
                            <td>
                                @if($img->is_thumbnail == 1)
                                    <span class="badge bg-success">Chính</span>
                                @else
                                    <span class="badge bg-secondary">Phụ</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ date('d/m/Y H:i', strtotime($img->created_at)) }}</td>
                            <td class="text-end">
                                <a href="{{ route('detail-tour-image/' . $img->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('delete-tour-image/' . $img->id) }}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Xóa ảnh này?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Chưa có ảnh nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection