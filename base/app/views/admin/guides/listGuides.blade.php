@extends('layout.dashboard')
@section('title', 'Danh sách Hướng dẫn viên')
@section('active-guide', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary"><i class="fas fa-user-tie"></i> Danh sách Hướng dẫn viên</h1>
        <a href="{{ route('add-guide') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm Hướng dẫn viên
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
                    <th>Tài khoản</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Giới tính</th>
                    <th>Kinh nghiệm (năm)</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guides as $g)
                    <tr>
                        <td>{{ $g->id }}</td>
                        <td>{{ $g->account_name }}</td>
                        <td class="fw-bold">{{ $g->fullname }}</td>
                        <td>{{ $g->phone }}</td>
                        <td>{{ $g->email }}</td>
                        <td>
                            <span class="badge {{ $g->gender === 'Nam' ? 'bg-info' : 'bg-warning' }}">
                                {{ $g->gender }}
                            </span>
                        </td>
                        <td>{{ $g->experience_years }}</td>
                        <td>
                            <span class="badge {{ $g->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $g->status === 'active' ? 'Đang hoạt động' : 'Ngừng' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('detail-guide/' . $g->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-guide/' . $g->id) }}', '{{ $g->fullname }}')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted">Chưa có hướng dẫn viên nào được thêm</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, name) {
        if (confirm(`Bạn có chắc chắn muốn xóa hướng dẫn viên: ${name}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection