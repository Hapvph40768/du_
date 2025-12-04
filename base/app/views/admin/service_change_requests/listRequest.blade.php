@extends('layout.dashboard')
@section('title', 'Danh sách Yêu cầu thay đổi dịch vụ')

@section('active-request', 'active')
@section('content')
    <h3>Danh sách Yêu cầu thay đổi dịch vụ</h3>

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

    <a href="{{ route('add-request') }}" class="btn btn-success mb-3">Thêm yêu cầu mới</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking ID</th>
                <th>Nội dung yêu cầu</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->booking_id }}</td>
                    <td>{{ $r->request }}</td>
                    <td>
                        @if($r->status === 'pending')
                            <span class="text-warning">Đang chờ</span>
                        @elseif($r->status === 'approved')
                            <span class="text-success">Đã duyệt</span>
                        @else
                            <span class="text-danger">Từ chối</span>
                        @endif
                    </td>
                    <td>{{ $r->created_at }}</td>
                    <td>
                        <a href="{{ route('detail-request/' . $r->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-request/' . $r->id) }}', '{{ $r->id }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(deleteUrl, requestId) {
            if (confirm(`Bạn có chắc chắn muốn xóa yêu cầu #${requestId}?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection