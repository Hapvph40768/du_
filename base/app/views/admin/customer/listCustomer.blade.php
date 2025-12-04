@extends('layout.dashboard')
@section('title', 'Danh sách khách hàng')

@section('active-customer', 'active')
@section('content')
    <h3 class="mb-4">Danh sách khách hàng</h3>

    {{-- Thông báo lỗi --}}
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

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <a href="{{ route('add-customer') }}" class="btn btn-success mb-3">
        <i class="bi bi-person-plus-fill me-1"></i> Thêm khách hàng
    </a>

    <table class="table table-hover table-bordered align-middle">
        <thead class="table-light">
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
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->fullname }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->nationality }}</td>
                    <td>{{ $c->dob }}</td>
                    <td>{{ $c->gender }}</td>
                    <td>{{ $c->address }}</td>
                    <td>{{ $c->note }}</td>
                    <td>{{ $c->created_at }}</td>
                    <td class="text-center">
                        <a href="{{ route('detail-customer/' . $c->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="confirmDelete('{{ route('delete-customer/' . $c->id) }}', '{{ $c->fullname }}')">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">Chưa có khách hàng nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        function confirmDelete(deleteUrl, name) {
            if (confirm(`Bạn có chắc chắn muốn xóa khách hàng: ${name}?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection