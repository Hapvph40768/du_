@extends('admin.dashboard')

@section('title', 'Thêm người dùng')

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
    <a href="{{route('list-user')}}">
        <button type="button" class="btn btn-warning">Quay lai</button>
    </a>
    <form action="{{route('post-user')}}" method="post">

        {{-- chon chuc nang --}}
        <div class="mb-3">
            <label>Chọn chuc nang:</label><br>
            <select name="role_id" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- ten dang nhap --}}
        <div class="mb-3">
            <label for="username" class="form-label">Ten dang nhap</label>
            <input type="text" class="form-control" name="username">
        </div>
        {{-- mat khau --}}
        <div class="mb-3">
            <label for="password" class="form-label">Mat khau</label>
            <input type="text" class="form-control" name="password">
        </div>

        {{-- ho ten --}}
        <div class="mb-3">
            <label for="fullname" class="form-label">Ho ten</label>
            <input type="text" class="form-control" name="fullname">
        </div>
        {{-- sdt --}}
        <div class="mb-3">
            <label for="phone" class="form-label">sdt</label>
            <input type="number" class="form-control" name="phone">
        </div>
                {{-- sdt --}}
        <div class="mb-3">
            <select name="status" class="form-select" aria-label="Default select example">
                <option value="0">Hoat dong</option>
                <option value="1">Dung hoat dong</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>

    </form>
@endsection