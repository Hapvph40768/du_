@extends('layout.main')
@section('content-roles')
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
    <a href="{{route('add-roles')}}">
        <button>Thêm tour</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên chuc nang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $r)
                <tr>
                    <td scope="col">{{ $r->id }}</td>
                    <td>{{ $r->name }}</td>
                    <td>
                        <button><a href="{{route('detail-roles/' . $r->id)}}">Sửa</a></button>
                        <button onclick="confirmDelete('{{route('delete-roles/' . $r->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection