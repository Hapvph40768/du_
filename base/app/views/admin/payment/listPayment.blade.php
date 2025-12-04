@extends('layout.dashboard')
@section('title', 'Danh sách thanh toán')

@section('active-payment', 'active')
@section('content')
    <h3>Danh sách thanh toán</h3>

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

    <a href="{{ route('add-payment') }}" class="btn btn-success mb-3">Thêm thanh toán</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking</th>
                <th>Số tiền</th>
                <th>Phương thức</th>
                <th>Mã giao dịch</th>
                <th>Trạng thái</th>
                <th>Thời gian thanh toán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>Booking #{{ $p->booking_id }}</td>
                    <td>{{ number_format($p->amount, 2) }} {{ $p->currency ?? 'VND' }}</td>
                    <td>{{ $p->method }}</td>
                    <td>{{ $p->transaction_code }}</td>
                    <td>{{ $p->status }}</td>
                    <td>{{ $p->paid_at }}</td>
                    <td>
                        <a href="{{ route('detail-payment/' . $p->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('delete-payment/' . $p->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(deleteUrl) {
            if (confirm("Bạn có chắc chắn muốn xóa thanh toán này?")) {
                window.location.href = deleteUrl;
            }
        }
    </script>
@endsection