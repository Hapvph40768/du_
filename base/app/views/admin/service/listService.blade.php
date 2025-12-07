@extends('layout.dashboard')
@section('title', 'Danh sách Dịch vụ')
@section('active-service', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary"><i class="fas fa-cogs"></i> Danh sách Dịch vụ</h1>
        <a href="{{ route('add-service') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm Dịch vụ
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
                    <th>Tên dịch vụ</th>
                    <th>Gói dịch vụ</th>
                    <th>Tour</th>
                    <th>Nhà cung cấp</th>
                    <th>Giá</th>
                    <th>Giá mặc định</th>
                    <th>Tiền tệ</th>
                    <th>Tùy chọn</th>
                    <th>Hoạt động</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $s)
                    <tr>
                        <td>{{ $s->id }}</td>
                        <td class="fw-bold">{{ $s->name }}</td>
                        <td>{{ $s->package_name }}</td>
                        <td>{{ $s->tour_name ?? '---' }}</td>
                        <td>{{ $s->supplier_name ?? '---' }}</td>
                        <td class="text-success">{{ number_format($s->price, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($s->default_price, 0, ',', '.') }} đ</td>
                        <td>{{ $s->currency }}</td>
                        <td>
                            <span class="badge {{ $s->is_optional ? 'bg-info' : 'bg-secondary' }}">
                                {{ $s->is_optional ? 'Có' : 'Không' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $s->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $s->is_active ? 'Đang hoạt động' : 'Ngừng' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('detail-service/' . $s->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-service/' . $s->id) }}', '{{ $s->name }}')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-muted">Chưa có dịch vụ nào được thêm</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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