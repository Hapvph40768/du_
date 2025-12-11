@extends('layout.dashboard')
@section('title', 'Nhật ký tour')
@section('content')

    <div class="page-header mb-4 d-flex justify-content-between align-items-end">
        <div>
            <h1 class="text-white mb-1"><i class="fas fa-history me-2"></i>Quản lý nhật ký tour</h1>
            <p class="text-muted mb-0">Theo dõi lịch sử hoạt động và thay đổi của các tour.</p>
        </div>
        <div class="d-flex gap-3">
             <a href="{{ route('add-tour-log') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg"></i> Thêm nhật ký
            </a>
        </div>
    </div>

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show shadow-sm bg-dark text-white border-success">
            <i class="fas fa-check-circle me-2"></i> {{ $_SESSION['success'] }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card-dark shadow-lg">
        <div class="card-header bg-transparent border-bottom border-light border-opacity-10 py-3">
            <h5 class="text-white mb-0">Danh sách nhật ký</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-dark-custom w-100 align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Tour / Chuyến đi</th>
                        <th style="width: 15%;">Hướng dẫn viên điều hành tour</th>
                        <th style="width: 15%;">Hành động</th>
                        <th style="width: 25%;">Chi tiết</th>
                        <th style="width: 15%;">Thời gian</th>
                        <th style="width: 5%; text-align: right;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-muted">{{ $log->id }}</td>
                            <td>
                                <div class="fw-bold text-white">{{ $log->tour_name }}</div>
                                @if($log->departure_date)
                                    <small class="text-info"><i class="fas fa-calendar-alt me-1"></i>{{ date('d/m/Y', strtotime($log->departure_date)) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($log->user_name)
                                    <span class="badge bg-secondary text-light"><i class="fas fa-user me-1"></i>{{ $log->user_name }}</span>
                                @else
                                    <span class="text-muted fst-italic">Hệ thống</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-25 px-2 py-1">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ strlen($log->message) > 50 ? mb_substr($log->message, 0, 50) . '...' : $log->message }}
                            </td>
                            <td class="text-muted">
                                {{ date('d/m/Y H:i', strtotime($log->created_at)) }}
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('detail-tour-log/' . $log->id) }}" class="btn btn-sm btn-outline-info border-0">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('delete-tour-log/' . $log->id) }}" class="btn btn-sm btn-outline-danger border-0"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">Chưa có nhật ký nào được ghi lại.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection