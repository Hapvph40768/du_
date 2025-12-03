@extends('admin.dashboard')
@section('title', 'Tour logs')

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

    <a href="{{route('add-tourlog')}}"><button type="button" class="btn btn-success">Thêm log</button></a>

    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Đợt khởi hành</th>
                <th>Ngày thứ</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $l)
                <tr>
                    <td>{{ $l->id }}</td>
                    <td>{{ $l->date_start }} -> {{ $l->date_end }}</td>
                    <td>{{ $l->day_number }}</td>
                    <td>{{ $l->note }}</td>
                    <td>
                        <button class="btn btn-warning"><a href="{{route('detail-tourlog/' . $l->id)}}">Sửa</a></button>
                        <button class="btn btn-danger" onclick="confirmDelete('{{route('delete-tourlog/' . $l->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection