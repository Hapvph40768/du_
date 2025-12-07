@extends('layout.dashboard')
@section('title', 'Danh sách Yêu cầu thay đổi dịch vụ')
@section('active-request', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="fas fa-exchange-alt"></i> Danh sách Yêu cầu thay đổi dịch vụ
        </h1>
        <a href="{{ route('add-request') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle"></i> Thêm yêu cầu mới
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if (isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if (isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Booking</th>
                            <th>Nội dung yêu cầu</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td class="fw-bold text-primary">#{{ $r->booking_id }}</td>
                                <td>
                                    {{ mb_strlen($r->request) > 50 ? mb_substr($r->request, 0, 50) . '...' : $r->request }}
                                </td>
                                <td>
                                    @if ($r->status === 'pending')
                                        <span class="badge bg-warning text-dark">Đang chờ</span>
                                    @elseif($r->status === 'approved')
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @else
                                        <span class="badge bg-danger">Từ chối</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ date('d/m/Y H:i', strtotime($r->created_at)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('detail-request/' . $r->id) }}"
                                       class="btn btn-sm btn-warning me-1">
                                       <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete('{{ route('delete-request/' . $r->id) }}', '{{ $r->id }}')">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">Chưa có yêu cầu thay đổi dịch vụ nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(deleteUrl, requestId) {
    if (confirm(`Bạn có chắc chắn muốn xóa yêu cầu #${requestId}?`)) {
        window.location.href = deleteUrl;
    }
}
</script>
@endsection
