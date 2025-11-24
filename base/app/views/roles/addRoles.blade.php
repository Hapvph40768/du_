@extends('admin.dashboard')
@section('title', 'Thêm vai trò người dùng')

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
    <a href="{{route('list-roles')}}">
        <button type="button" class="btn btn-warning">Quay lai</button>
    </a>
    <form action="{{route('post-roles')}}" method="post">

        {{-- ten tour --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên chuc nang</label>
            <input type="text" class="form-control" name="name">
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>
    </form>
@endsection