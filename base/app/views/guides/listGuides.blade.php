@extends('layout.main')
@section('content-guides')
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
    <a href="{{route('add-guide')}}">
        <button>Thêm HDV</button>
    </a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Họ Tên</th>
                <th scope="col">Ngày Sinh</th>
                <th scope="col">Ảnh Đại Diện</th>
                <th scope="col">Chứng Chỉ</th>
                <th scope="col">Ngôn Ngữ</th>
                <th scope="col">Số Năm Kinh Nghiệm</th>

            </tr>
        </thead>
        <tbody>
            @foreach($guides as $st)
                <tr>
                    <td scope="col">{{ $st->id }}</td>
                    <td>{{ $st->dob }}</td>
                    <td>{{ $st->avatar }}</td>
                    <td>{{ $st->certificates }} đ</td>
                    <td>{{ $st->languages }}</td>
                  
                    <!-- <td>
                        <button><a href="{{route('detail-tour/' . $st->id)}}">Sửa</a></button>
                        <button onclick="confirmDelete('{{route('delete-tour/' . $st->id)}}')">Xóa</button>
                    </td> -->
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection