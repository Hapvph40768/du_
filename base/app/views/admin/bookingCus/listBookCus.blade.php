@extends('layout.dashboard')
@section('title', 'Danh sách khách trong booking')

@section('active-booking-customer', 'active')
@section('content')
    <h3>Danh sách khách trong booking</h3>

    {{-- Thông báo lỗi --}}
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

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <a href="{{ route('add-booking-customer') }}" class="btn btn-success mb-3">Thêm khách vào booking</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã Booking</th>
                <th>Khách hàng</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Ghi chú</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>Booking #{{ $c->booking_id }}</td>
                    <td>{{ $c->fullname }}</td>
                    <td>{{ $c->gender }}</td>
                    <td>{{ $c->dob }}</td>
                    <td>{{ $c->note }}</td>
                    <td>{{ $c->created_at }}</td>
                    <td>
                        <a href="{{ route('detail-booking-customer/' . $c->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-booking-customer/' . $c->id) }}', '{{ $c->fullname }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(deleteUrl, name) {
            if (confirm(`Bạn có chắc chắn muốn xóa khách: ${name}?`)) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection