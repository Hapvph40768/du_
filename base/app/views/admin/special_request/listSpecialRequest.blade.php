@extends('layout.dashboard')
@section('title', 'Danh sách Yêu cầu đặc biệt')
@section('active-special-request', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-star text-primary"></i> Danh sách Yêu cầu đặc biệt</h2>
        <a href="{{ route('add-special-request') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Thêm Yêu cầu mới
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
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
        <div class="alert alert-success mb-4">
            {{ $_SESSION['success'] }}
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card-dark p-3">
        <div class="table-responsive">
            <table class="table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Khách hàng</th>
                        <th>Nội dung yêu cầu</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center" style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $r)
                        <tr>
                            <td class="text-center text-white-50">{{ $r->id }}</td>
                            <td class="fw-bold text-white">{{ $r->customer_name }}</td>
                            <td>
                                <span class="text-white opacity-75">
                                    {{ strlen($r->request) > 50 ? substr($r->request, 0, 50) . '...' : $r->request }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-white-50 font-monospace">{{ $r->created_at }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('detail-special-request/' . $r->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                    <i class="fas fa-edit"></i>Sửa
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="confirmDelete('{{ route('delete-special-request/' . $r->id) }}', '{{ $r->request }}')">
                                    <i class="fas fa-trash-alt"></i>Xóa
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">Chưa có yêu cầu đặc biệt nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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