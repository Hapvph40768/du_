@extends('layout.dashboard')
@section('title', 'Lịch khởi hành của tour')

@section('active-departure', 'active')
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

    <a href="{{ route('add-departure') }}">
        <button type="button" class="btn btn-success">Thêm lịch khởi hành</button>
    </a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tour</th>
                <th scope="col">Ngày bắt đầu</th>
                <th scope="col">Ngày kết thúc</th>
                <th scope="col">Giá</th>
                <th scope="col">Ghế trống</th>
                <th scope="col">Chi phí Guide</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departures as $dp)
                <tr>
                    <td>{{ $dp->id }}</td>
                    <td>{{ $dp->tour_name }}</td>
                    <td>{{ $dp->start_date }}</td>
                    <td>{{ $dp->end_date }}</td>
                    <td>
                        @if($dp->price)
                            {{ number_format($dp->price, 0, ',', '.') }} đ
                        @else
                            {{ number_format($dp->tour_price ?? 0, 0, ',', '.') }} đ
                        @endif
                    </td>
                    <td>{{ $dp->available_seats }}</td>
                    <td>
                        @if($dp->guide_price)
                            {{ number_format($dp->guide_price, 0, ',', '.') }} đ
                        @else
                            Không có
                        @endif
                    </td>
                    <td>
                        @switch($dp->status)
                            @case('open')
                                <span class="text-success">Đang mở</span>
                                @break
                            @case('closed')
                                <span class="text-secondary">Đã đóng</span>
                                @break
                            @case('full')
                                <span class="text-danger">Đầy chỗ</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('detail-departure/' . $dp->id) }}" class="btn btn-warning">Sửa</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('delete-departure/' . $dp->id) }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection