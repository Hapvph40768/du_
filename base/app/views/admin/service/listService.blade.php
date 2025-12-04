@extends('layout.dashboard')
@section('title', 'Danh sách Dịch vụ')

@section('active-service', 'active')
@section('content')
    <h3>Danh sách Dịch vụ</h3>

    {{-- Hiển thị thông báo --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul>
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <a href="{{ route('add-service') }}" class="btn btn-success mb-3">Thêm Dịch vụ</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
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
            @foreach($services as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->package_name }}</td>
                    <td>{{ $s->tour_name ?? '---' }}</td>
                    <td>{{ $s->supplier_name ?? '---' }}</td>
                    <td>{{ number_format($s->price, 0) }}</td>
                    <td>{{ number_format($s->default_price, 0) }}</td>
                    <td>{{ $s->currency }}</td>
                    <td>{{ $s->is_optional ? 'Có' : 'Không' }}</td>
                    <td>{{ $s->is_active ? 'Đang hoạt động' : 'Ngừng' }}</td>
                    <td>
                        <a href="{{ route('detail-service/' . $s->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-service/' . $s->id) }}', '{{ $s->name }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(deleteUrl, serviceName) {
            if (confirm(`Bạn có chắc chắn muốn xóa dịch vụ: ${serviceName}?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection