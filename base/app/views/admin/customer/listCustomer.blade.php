@extends('layout.dashboard')
@section('title', 'Danh sách khách hàng')
@section('active-customer', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary"><i class="fas fa-users"></i> Danh sách khách hàng</h1>
        <a href="{{ route('add-customer') }}" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Thêm khách hàng
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
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Quốc tịch</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td class="fw-bold">{{ $c->fullname }}</td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->nationality }}</td>
                        <td>{{ $c->dob }}</td>
                        <td>
                            <span class="badge {{ $c->gender === 'Nam' ? 'bg-info' : 'bg-warning' }}">
                                {{ $c->gender }}
                            </span>
                        </td>
                        <td>{{ $c->address }}</td>
                        <td>{{ $c->note ?: '—' }}</td>
                        <td><span class="text-muted">{{ $c->created_at }}</span></td>
                        <td>
                            <a href="{{ route('detail-customer/' . $c->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-customer/' . $c->id) }}', '{{ $c->fullname }}')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-muted">Chưa có khách hàng nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, name) {
        if (confirm(`Bạn có chắc chắn muốn xóa khách hàng: ${name}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection