@extends('layout.dashboard')
@section('title', 'Danh sách Dịch vụ kèm Booking')

@section('active-booking-service', 'active')
@section('content')
    <h3>Danh sách Dịch vụ kèm theo Booking</h3>

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

    <a href="{{ route('add-booking-service') }}" class="btn btn-success mb-3">Thêm dịch vụ vào Booking</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã Booking</th>
                <th>Dịch vụ</th>
                <th>Số lượng</th>
                <th>Giá tại thời điểm đặt</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookingServices as $bs)
                <tr>
                    <td>{{ $bs->id }}</td>
                    <td>{{ $bs->booking_code }}</td>
                    <td>{{ $bs->service_name }}</td>
                    <td>{{ $bs->quantity }}</td>
                    <td>{{ number_format($bs->price, 0) }}</td>
                    <td>{{ $bs->created_at }}</td>
                    <td>
                        <a href="{{ route('detail-booking-service/' . $bs->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-booking-service/' . $bs->id) }}', '{{ $bs->service_name }}')">Xóa</button>
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