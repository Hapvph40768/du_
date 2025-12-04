@extends('layout.dashboard')
@section('title', 'Danh Sách Nhà Cung Cấp')

@section('active-suppliers', 'active')
@section('content')
    <h3>Danh Sách Nhà Cung Cấp</h3>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
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
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px;">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <a href="{{ route('add-supplier') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Thêm Nhà Cung Cấp
    </a>

    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên Nhà Cung Cấp</th>
                <th scope="col">Slug</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $index => $sp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-bold">{{ $sp->name }}</td>
                    <td><span class="text-muted">{{ $sp->slug }}</span></td>
                    <td>{{ strlen($sp->description) > 50 ? substr($sp->description, 0, 50) . '...' : $sp->description }}</td>
                    <td>{{ $sp->phone }}</td>
                    <td>{{ $sp->email }}</td>
                    <td>{{ $sp->address }}</td>
                    <td>
                        <span class="badge {{ $sp->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $sp->status === 'active' ? 'Hoạt động' : 'Ngừng hoạt động' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('detail-supplier/' . $sp->id) }}" class="btn btn-primary btn-sm me-1">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-supplier/' . $sp->id) }}', '{{ $sp->name }}')">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-muted">Chưa có nhà cung cấp nào được thêm</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        // Hàm xử lý xác nhận xóa
        function confirmDelete(deleteUrl, supplierName) {
            if (window.confirm(`Bạn có chắc chắn muốn xóa Nhà Cung Cấp: ${supplierName} không?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection