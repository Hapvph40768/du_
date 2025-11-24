@extends('admin.dashboard')
@section('title', 'Danh sách vai trò người dùng')

@section('active-roles', 'active')
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
    <a href="{{route('add-roles')}}">
       <button type="button" class="btn btn-success">Thêm</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên chuc nang</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $r)
                <tr>
                    <td scope="col">{{ $r->id }}</td>
                    <td>{{ $r->name }}</td>
                    <td>
                        <button type="button" class="btn btn-warning"><a href="{{route('detail-roles/' . $r->id)}}">Sửa</a></button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{route('delete-roles/' . $r->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection