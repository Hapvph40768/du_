@extends('layout.main')
@section('content-departure')
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
    <a href="{{route('add-departure')}}">
        <button>Thêm tour</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tour</th>
                <th scope="col">Bắt đầu tour</th>
                <th scope="col">Kết thúc tour</th>
                <th scope="col">Tổng chỗ</th>
                <th scope="col">Chỗ trống</th>
                <th scope="col">Hành động</th>

            </tr>
        </thead>
        <tbody>
            @foreach($departures as $dp)
                <tr>
                    <td scope="col">{{ $dp->id }}</td>
                    <td>{{ $dp->tour_name }}</td>
                    <td>{{ $dp->date_start }}</td>
                    <td>{{ $dp->date_end }}</td>
                    <td>{{ $dp->seats_total }}</td>
                    <td>{{ $dp->seats_remaining }}</td>
                    <td>
                        <button><a href="{{route('detail-departure/' . $dp->id)}}">Sửa</a></button>
                        <button onclick="confirmDelete('{{route('delete-departure/' . $dp->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection