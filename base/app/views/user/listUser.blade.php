@extends('layout.main')
@section('content-user')
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
    <a href="{{route('add-user')}}">
        <button>Them user</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Vai tro</th>
                <th scope="col">Ten dang nhap</th>
                <th scope="col">Mat khau</th>
                <th scope="col">Ho ten</th>
                <th scope="col">SDT</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>

            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td scope="col">{{ $u->id }}</td>
                    <td>{{ $u->role_name }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->password }}</td>
                    <td>{{ $u->fullname }}</td>
                    <td>{{ $u->phone }}</td>
                    <td>{{ $u->status == 0 ? 'hoat dong' : 'dung hoat dong'  }}</td>
                    <td>
                        <button><a href="{{route('detail-user/' . $u->id)}}">Sửa</a></button>
                        <button onclick="confirmDelete('{{route('delete-user/' . $u->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection