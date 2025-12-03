@extends('layout.dashboard')
@section('title', 'Lịch trình theo ngày')

@section('active-itinerary', 'active')
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

    <a href="{{ route('add-itinerary') }}">
        <button type="button" class="btn btn-success">Thêm lịch trình</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tour</th>
                <th scope="col">Ngày thứ</th>
                <th scope="col">Tiêu đề của ngày</th>
                <th scope="col">Nội dung chi tiết</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itinerary as $it)
                <tr>
                    <td>{{ $it->id }}</td>
                    <td>{{ $it->tour_name }}</td>
                    <td>{{ $it->day_number }}</td>
                    <td>{{ $it->title }}</td>
                    <td>{{ $it->description }}</td>
                    <td>
                        <a href="{{ route('detail-itinerary/' . $it->id) }}" class="btn btn-warning">Sửa</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('delete-itinerary/' . $it->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection