@extends('layout.dashboard')

@section('title', 'Danh Sách Nhà Cung Cấp')
@section('active-suppliers', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="fas fa-truck"></i> Danh Sách Nhà Cung Cấp
        </h1>
        <a href="{{ route('add-supplier') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle"></i> Thêm Nhà Cung Cấp
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
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
                            <th>Tên Nhà Cung Cấp</th>
                            <th>Loại</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $sp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold text-primary">{{ $sp->name }}</td>
                                <td><span class="badge bg-info">{{ $sp->type }}</span></td>
                                <td>{{ $sp->phone }}</td>
                                <td>{{ $sp->email }}</td>
                                <td>{{ $sp->address }}</td>
                                <td>
                                    <a href="{{ route('detail-supplier/' . $sp->id) }}" 
                                       class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete('{{ route('delete-supplier/' . $sp->id) }}', '{{ $sp->name }}')">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">Chưa có nhà cung cấp nào được thêm</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, supplierName) {
        if (confirm(`Bạn có chắc chắn muốn xóa Nhà Cung Cấp: ${supplierName}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection