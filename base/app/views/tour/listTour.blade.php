@extends('layout.main')
@section('content-tour')
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
    <a href="{{route('add-tour')}}">
        <button>Thêm tour</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên tour</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Giá tour</th>
                <th scope="col">Ngày tour</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>

            </tr>
        </thead>
        <tbody>
            @foreach($tours as $st)
                <tr>
                    <td scope="col">{{ $st->id }}</td>
                    <td>{{ $st->name }}</td>
                    <td>{{ $st->description }}</td>
                    <td>{{ number_format($st->price, 0, ',', '.') }} đ</td>
                    <td>{{ $st->days }}</td>
                    <td>{{ $st->status == 1 ? 'còn mở' : 'đã đóng'  }}</td>
                    <td>
                        <button><a href="{{route('detail-tour/' . $st->id)}}">Sửa</a></button>
                        <button onclick="confirmDelete('{{route('delete-tour/' . $st->id)}}')">Xóa</button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection