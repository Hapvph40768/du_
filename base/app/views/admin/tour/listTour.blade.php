@extends('layout.dashboard')

@section('title', 'Danh sách Tour')

@section('active-tours', 'active')

@section('content')
<h1>Danh sách Tour</h1>

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

    <a href="{{ route('add-tour') }}">
        <button type="button" class="btn btn-success">Thêm tour</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên tour</th>
                <th scope="col">Slug</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Giá tour</th>
                <th scope="col">Số ngày</th>
                <th scope="col">Điểm khởi hành</th>
                <th scope="col">Điểm đến</th>
                <th scope="col">Thumbnail</th>
                <th scope="col">Loại tour</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tours as $st)
                <tr>
                    <td>{{ $st->id }}</td>
                    <td>{{ $st->name }}</td>
                    <td>{{ $st->slug }}</td>
                    <td>{{ $st->description }}</td>
                    <td>{{ number_format($st->price, 0, ',', '.') }} đ</td>
                    <td>{{ $st->days }}</td>
                    <td>{{ $st->start_location }}</td>
                    <td>{{ $st->destination }}</td>
                    <td>
                        @if($st->thumbnail)
                            <img src="{{ $st->thumbnail }}" alt="thumbnail" width="80">
                        @else
                            Không có
                        @endif
                    </td>
                    <td>{{ $st->category }}</td>
                    <td>
                        {{ $st->status === 'active' ? 'Còn mở' : 'Đã đóng' }}
                    </td>
                    <td>
                        <a href="{{ route('detail-tour/' . $st->id) }}" class="btn btn-warning">Sửa</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('delete-tour/' . $st->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection