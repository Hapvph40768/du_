@extends('layout.dashboard')
@section('title', 'Danh sách Yêu cầu thay đổi dịch vụ')
@section('active-request', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold">
            <i class="fas fa-exchange-alt text-primary"></i> Danh sách Yêu cầu thay đổi dịch vụ
        </h2>
        <a href="{{ route('add-request') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Thêm yêu cầu mới
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if (isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
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
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card-dark p-3">
        <div class="table-responsive">
            <table class="table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Booking</th>
                        <th>Nội dung yêu cầu</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center" style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $r)
                        <tr>
                            <td class="text-center text-white-50">{{ $r->id }}</td>
                            <td class="fw-bold text-primary">#{{ $r->booking_id }}</td>
                            <td>
                                <span class="text-white" title="{{ $r->request }}">
                                    {{ mb_strlen($r->request) > 50 ? mb_substr($r->request, 0, 50) . '...' : $r->request }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($r->status === 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3">Đang chờ</span>
                                @elseif($r->status === 'approved')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">Đã duyệt</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3">Từ chối</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="text-white-50 font-monospace">
                                    {{ date('d/m/Y H:i', strtotime($r->created_at)) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('detail-request/' . $r->id) }}"
                                   class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                   <i class="fas fa-edit"></i>Sửa
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa"
                                    onclick="confirmDelete('{{ route('delete-request/' . $r->id) }}', '{{ $r->id }}')">
                                    <i class="fas fa-trash-alt"></i>Xóa
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Chưa có yêu cầu thay đổi dịch vụ nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
