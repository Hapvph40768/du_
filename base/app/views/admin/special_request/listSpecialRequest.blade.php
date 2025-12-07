@extends('layout.dashboard')
@section('title', 'Danh sách Yêu cầu đặc biệt')
@section('active-special-request', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary"><i class="fas fa-star"></i> Danh sách Yêu cầu đặc biệt</h1>
        <a href="{{ route('add-special-request') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm Yêu cầu mới
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Nội dung yêu cầu</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td class="fw-bold">{{ $r->customer_name }}</td>
                        <td>{{ strlen($r->request) > 50 ? substr($r->request, 0, 50) . '...' : $r->request }}</td>
                        <td><span class="text-muted">{{ $r->created_at }}</span></td>
                        <td>
                            <a href="{{ route('detail-special-request/' . $r->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-special-request/' . $r->id) }}', '{{ $r->request }}')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Chưa có yêu cầu đặc biệt nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, requestText) {
        if (confirm(`Bạn có chắc chắn muốn xóa yêu cầu: ${requestText}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection