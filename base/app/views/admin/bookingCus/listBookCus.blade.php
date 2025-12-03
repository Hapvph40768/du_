@extends('layout.dashboard')
@section('title', 'Danh sách khách trong booking')

@section('active-booking-customer', 'active')
@section('content')
    <h1>Danh sách khách trong booking</h1>

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

    <a href="{{ route('add-customer') }}">
        <button type="button" class="btn btn-success">Thêm khách</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking</th>
                <th>Khách hàng</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Ghi chú</th>
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
                    <td>
                        <a href="{{ route('detail-customer/' . $c->id) }}" class="btn btn-warning">Sửa</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('delete-customer/' . $c->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection