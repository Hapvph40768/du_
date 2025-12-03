@extends('layout.dashboard')
@section('title', 'Danh sách hướng dẫn viên')

@section('active-guides', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{ $_SESSION['success'] }}</span>
    @endif

    <a href="{{ route('add-guide') }}">
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
                <th scope="col">Trạng Thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guides as $st)
                <tr>
                    <td>{{ $st->id }}</td>
                    <td>{{ $st->fullname }}</td>
                    <td>{{ $st->dob }}</td>
                    <td>
                        @if($st->avatar)
                            <img src="{{ $st->avatar }}" alt="avatar" width="60">
                        @else
                            Không có
                        @endif
                    </td>
                    <td>
                        @if($st->certificate_url)
                            <a href="{{ $st->certificate_url }}" target="_blank">Xem chứng chỉ</a>
                        @else
                            Không có
                        @endif
                    </td>
                    <td>{{ $st->languages }}</td>
                    <td>{{ $st->experience_years }}</td>
                    <td>{{ $st->status }}</td>
                    <td>
                        <a href="{{ route('detail-guide/' . $st->id) }}">
                            <button>Sửa</button>
                        </a>
                        <button onclick="confirmDelete('{{ route('delete-guide/' . $st->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection