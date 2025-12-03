@extends('layout.dashboard')

@section('title', 'Danh sách người dùng')

@section('active-user', 'active')

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
    <a href="{{route('add-user')}}">
        <button type="button" class="btn btn-success">Them </button>
    </a>
    <div class="container mt-5">
    <h2 class="text-center">Quản lý User</h2>
    <a href="/logout" class="btn btn-danger mb-3">Đăng xuất</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Avatar</th>
                <th>Active</th>
                <th>Last Login</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->username }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    @if($u->avatar)
                        <img src="{{ $u->avatar }}" alt="avatar" width="40">
                    @else
                        <span>--</span>
                    @endif
                </td>
                <td>{{ $u->is_active ? 'Active' : 'Locked' }}</td>
                <td>{{ $u->last_login }}</td>
                <td>{{ $u->created_at }}</td>
                <td>
                    <a href="/delete-user/{{ $u->id }}" class="btn btn-sm btn-danger"
                       onclick="return confirm('Bạn có chắc muốn xóa user này?')">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection