@extends('admin.dashboard')
@section('title', 'Thêm tour')

@section('active-tours', 'active')
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
    <a href="{{route('list-tours')}}">
        <button type="button" class="btn btn-warning">Quay lai</button>
    </a>
    <form action="{{route('post-tour')}}" method="post">

        {{-- ten tour --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên tour</label>
            <input type="text" class="form-control" name="name">
        </div>
        {{-- mo ta --}}
        <div class="mb-3">
            <label for="description" class="form-label">mô tả tour</label>
            <input type="text" class="form-control" name="description">
        </div>

        {{-- gia tour --}}
        <div class="mb-3">
            <label for="price" class="form-label">gia tour</label>
            <input type="number" class="form-control" name="price">
        </div>

        {{-- thoi gian tour --}}
        <div class="mb-3">
            <label for="days" class="form-label">thoi gian tour</label>
            <input type="number" class="form-control" name="days">
        </div>
        
        {{-- trang thai tour --}}
        <div>
            <select name="status" class="form-select" aria-label="Default select example">
                <option value="">--Trang thai--</option>
                <option value="1">Còn mở</option>
                <option value="0">Đã đóng</option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>
    </form>
@endsection