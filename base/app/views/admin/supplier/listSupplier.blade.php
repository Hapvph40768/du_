@extends('layout.dashboard')
@section('title', 'Danh Sách Nhà Cung Cấp')

@section('active-supplier', 'active')
@section('content')
    <h3>Danh Sách Nhà Cung Cấp</h3>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <ul>
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

    <a href="{{ route('add-supplier') }}" class="btn btn-success mb-3">Thêm Nhà Cung Cấp</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên Nhà Cung Cấp</th>
                <th scope="col">Loại Nhà Cung Cấp</th>
                <th scope="col">Số Điện Thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $index => $supplier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->type }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>
                        <a href="{{ route('detail-supplier/' . $supplier->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-supplier/' . $supplier->id) }}', '{{ $supplier->name }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Hàm xử lý xác nhận xóa
        function confirmDelete(deleteUrl, supplierName) {
            if (window.confirm(`Bạn có chắc chắn muốn xóa Nhà cung cấp: ${supplierName} không?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection