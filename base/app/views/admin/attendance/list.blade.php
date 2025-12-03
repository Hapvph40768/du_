@extends('layout.dashboard')
@section('title', 'Danh sách Attendance')

@section('active-attendance', 'active')
@section('content')
    <h1>Danh sách điểm danh</h1>

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

    <a href="{{ route('add-attendance') }}">
        <button type="button" class="btn btn-success">Thêm Attendance</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tour</th>
                <th>Khách hàng</th>
                <th>Booking Customer</th>
                <th>Trạng thái</th>
                <th>Check-in</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $a)
                <tr>
                    <td>{{ $a->id }}</td>
                    <td>Tour #{{ $a->tour_id }} ({{ $a->start_date }} - {{ $a->end_date }})</td>
                    <td>{{ $a->customer_name }}</td>
                    <td>{{ $a->booking_customer_name ?? 'N/A' }}</td>
                    <td>
                        @if($a->status === 'present')
                            <span class="text-success">Có mặt</span>
                        @else
                            <span class="text-danger">Vắng</span>
                        @endif
                    </td>
                    <td>{{ $a->checkin_time ?? '---' }}</td>
                    <td>{{ $a->note }}</td>
                    <td>
                        <a href="{{ route('detail-attendance/' . $a->id) }}" class="btn btn-warning">Sửa</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('delete-attendance/' . $a->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection