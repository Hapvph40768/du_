@extends('admin.dashboard')
@section('title', 'Ảnh tour')

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

    <a href="{{route('add-tourimg')}}"><button type="button" class="btn btn-success">Thêm ảnh</button></a>

    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tour</th>
                <th>Ảnh</th>
                <th>Ảnh đại diện</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $img)
                <tr>
                    <td>{{ $img->id }}</td>
                    <td>{{ $img->tour_name }}</td>
                    <td><img src="{{ BASE_URL . $img->image_path }}" width="120" alt="" /></td>
                    <td>{{ $img->is_thumbnail ? 'Có' : 'Không' }}</td>
                    <td>
                        <button class="btn btn-warning"><a href="{{route('detail-tourimg/' . $img->id)}}">Sửa</a></button>
                        <button class="btn btn-danger" onclick="confirmDelete('{{route('delete-tourimg/' . $img->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection