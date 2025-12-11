@extends('layout.dashboard')

@section('title', 'Danh Sách Nhà Cung Cấp')
@section('active-suppliers', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold">
            <i class="fas fa-truck text-primary"></i> Danh Sách Nhà Cung Cấp
        </h2>
        <a href="{{ route('add-supplier') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Thêm Nhà Cung Cấp
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

    <div class="card-dark p-3">
        <div class="table-responsive">
            <table class="table-dark-custom align-middle text-center">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th class="text-start">Tên Nhà Cung Cấp</th>
                        <th class="text-center">Loại</th>
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-start">Email</th>
                        <th class="text-start">Địa chỉ</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $index => $sp)
                        <tr>
                            <td class="text-muted">{{ $index + 1 }}</td>
                            <td class="fw-bold text-white text-start">{{ $sp->name }}</td>
                            <td class="text-center">
                                <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-3">
                                    {{ $sp->type }}
                                </span>
                            </td>
                            <td class="text-muted text-center">{{ $sp->phone }}</td>
                            <td class="text-muted text-start">{{ $sp->email }}</td>
                            <td class="text-start text-muted">{{ $sp->address }}</td>
                            <td>
                                <a href="{{ route('detail-supplier/' . $sp->id) }}" 
                                   class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" title="Xóa"
                                        onclick="confirmDelete('{{ route('delete-supplier/' . $sp->id) }}', '{{ $sp->name }}')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">Chưa có nhà cung cấp nào được thêm</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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