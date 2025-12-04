@extends('layout.dashboard')
@section('title', 'Danh sách Yêu cầu đặc biệt')

@section('active-special-request', 'active')
@section('content')
    <h3>Danh sách Yêu cầu đặc biệt</h3>

    {{-- Thông báo --}}
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

    <a href="{{ route('add-request') }}" class="btn btn-success mb-3">Thêm Yêu cầu mới</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Nội dung yêu cầu</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->customer_name }}</td>
                    <td>{{ $r->request }}</td>
                    <td>{{ $r->created_at }}</td>
                    <td>
                        <a href="{{ route('detail-request/' . $r->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-request/' . $r->id) }}', '{{ $r->request }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(deleteUrl, requestText) {
            if (confirm(`Bạn có chắc chắn muốn xóa yêu cầu: ${requestText}?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection