@extends('layout.dashboard')
@section('title', 'Danh sách Booking')

@section('active-booking', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{ $_SESSION['success'] }}</span>
    @endif

    <a href="{{ route('add-booking') }}">
        <button type="button" class="btn btn-info">Thêm booking</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tour & Lịch khởi hành</th>
                <th scope="col">Người đặt</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Thanh toán</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>
                        {{ $b->tour_name }} <br>
                        {{ $b->start_date }} → {{ $b->end_date }}
                    </td>
                    <td>{{ $b->customer_name ?? 'N/A' }}</td>
                    <td>{{ $b->customer_phone ?? 'N/A' }}</td>
                    <td>{{ $b->num_people }}</td>
                    <td>{{ number_format($b->total_price, 0, ',', '.') }} đ</td>
                    <td>
                        @switch($b->payment_status)
                            @case('unpaid')
                                <span class="text-danger">Chưa thanh toán</span>
                                @break
                            @case('partial')
                                <span class="text-warning">Thanh toán một phần</span>
                                @break
                            @case('paid')
                                <span class="text-success">Đã thanh toán</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        @switch($b->status)
                            @case('pending')
                                <span class="text-secondary">Đang chờ</span>
                                @break
                            @case('confirmed')
                                <span class="text-success">Đã xác nhận</span>
                                @break
                            @case('cancelled')
                                <span class="text-danger">Đã hủy</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('detail-booking/' . $b->id) }}" class="btn btn-warning">Sửa</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('delete-booking/' . $b->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection