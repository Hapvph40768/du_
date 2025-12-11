@extends('layout.dashboard')
@section('title', 'Danh sách Dịch vụ')
@section('active-service', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold"><i class="fas fa-cogs"></i> Danh sách Dịch vụ</h2>
        <a href="{{ route('add-service') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Thêm Dịch vụ
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

    <div class="card shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th class="text-start">Tên dịch vụ</th>
                        <th>Gói</th>
                        <th>Nhà cung cấp</th>
                        <th class="text-end">Giá mặc định</th>
                        <th>Tùy chọn</th>
                        <th>Trạng thái</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $s)
                        <tr>
                            <td class="text-muted">{{ $s->id }}</td>
                            <td class="fw-bold text-dark text-start">{{ $s->name }}</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">{{ $s->package_name }}</span></td>
                            <td class="text-muted">{{ $s->supplier_name ?? '-' }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($s->default_price, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge {{ $s->is_optional ? 'bg-info bg-opacity-10 text-info border border-info' : 'bg-secondary bg-opacity-10 text-secondary border border-secondary' }} rounded-pill px-3">
                                    {{ $s->is_optional ? 'Có' : 'Không' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $s->is_active ? 'bg-success bg-opacity-10 text-success border border-success' : 'bg-danger bg-opacity-10 text-danger border border-danger' }} rounded-pill px-3">
                                    {{ $s->is_active ? 'Hoạt động' : 'Ngừng' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('detail-service/' . $s->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                    <i class="fas fa-edit"></i>Sửa
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="confirmDelete('{{ route('delete-service/' . $s->id) }}', '{{ $s->name }}')">
                                    <i class="fas fa-trash-alt"></i>Xóa
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">Chưa có dịch vụ nào được thêm</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, serviceName) {
        if (confirm(`Bạn có chắc chắn muốn xóa dịch vụ: ${serviceName}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection