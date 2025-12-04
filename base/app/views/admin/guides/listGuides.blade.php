@extends('layout.dashboard')
@section('title', 'Danh sách Hướng dẫn viên')

@section('active-guide', 'active')
@section('content')
    <h3>Danh sách Hướng dẫn viên</h3>

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

    <a href="{{ route('add-guide') }}" class="btn btn-success mb-3">Thêm Hướng dẫn viên</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
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
            @foreach($guides as $g)
                <tr>
                    <td>{{ $g->id }}</td>
                    <td>{{ $g->account_name }}</td>
                    <td>{{ $g->fullname }}</td>
                    <td>{{ $g->phone }}</td>
                    <td>{{ $g->email }}</td>
                    <td>{{ $g->gender }}</td>
                    <td>{{ $g->experience_years }}</td>
                    <td>{{ $g->status }}</td>
                    <td>
                        <a href="{{ route('detail-guide/' . $g->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-guide/' . $g->id) }}', '{{ $g->fullname }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(deleteUrl, name) {
            if (confirm(`Bạn có chắc chắn muốn xóa hướng dẫn viên: ${name}?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection