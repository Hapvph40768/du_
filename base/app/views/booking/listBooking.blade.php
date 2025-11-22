@extends('layout.main')
@section('content-booking')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{$_SESSION['success']}}</span>
    @endif
    <a href="{{route('add-booking')}}">
        <button>Thêm tour</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Lich Khoi hanh</th>
                <th scope="col">Nguoi dat</th>
                <th scope="col">So dien thoai</th>
                <th scope="col">So luong</th>
                <th scope="col">Tong tien</th>
                <th scope="col">Trang thai</th>
                <th scope="col">Hành động</th>

            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
                <tr>
                    <td scope="col">{{ $b->id }}</td>
                    <td>{{ $b->departure_id }} {{ $b->date_start }} : {{ $b->date_end }}</td>
                    <td>{{ $b->customer_name }}</td>
                    <td>{{ $b->customer_phone }}</td>
                    <td>{{ $b->people }}</td>
                    <td>{{ $b->total_price }}</td>
                    <td>{{ $b->status }}</td>
                    <td>
                        <button><a href="{{route('detail-booking/' . $b->id)}}">Sửa</a></button>
                        <button onclick="confirmDelete('{{route('delete-booking/' . $b->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection