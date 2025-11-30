@extends('admin.dashboard')
@section('title', 'Lịch khởi hành của tour')

@section('active-departure', 'active')
@section('content')
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
        <button type="button" class="btn btn-success">Thêm </button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tour</th>
                <th scope="col">Ngày khởi hành</th>
                <th scope="col">Tổng chỗ</th>
                <th scope="col">Chỗ trống</th>
                <th scope="col">Hành động</th>

            </tr>
        </thead>
        <tbody>
            @foreach($departures as $dp)
                <tr>
                    <td scope="col">{{ $dp->id }}</td>
                    <td>{{ $dp->tour_title ?? $dp->tour_name ?? '' }}</td>
                    <td>{{ $dp->depart_date }}</td>
                    <td>{{ $dp->seats_total }}</td>
                    <td>{{ ($dp->seats_total ?? 0) - ($dp->seats_booked ?? 0) }}</td>
                    <td>
                        <button type="button" class="btn btn-warning"><a href="{{route('detail-departure/' . $dp->id)}}">Sửa</a></button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{route('delete-departure/' . $dp->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection