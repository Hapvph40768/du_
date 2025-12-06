@extends('admin.dashboard')

@section('title', 'Chi tiết lịch trình')
@section('content')

<h4>Chi tiết ngày thứ {{ $schedule->day_number }} – Tour #{{ $tour_id }}</h4>

<table class="table table-bordered">
    <tr>
        <th>Ngày thứ</th>
        <td>{{ $schedule->day_number }}</td>
    </tr>
    <tr>
        <th>Ngày</th>
        <td>{{ $schedule->date }}</td>
    </tr>
    <tr>
        <th>Tiêu đề</th>
        <td>{{ $schedule->title }}</td>
    </tr>
    <tr>
        <th>Mô tả</th>
        <td>{{ $schedule->description }}</td>
    </tr>
    <tr>
        <th>Hoạt động</th>
        <td>
            @if(!empty($schedule->activities))
                @foreach(json_decode($schedule->activities) as $act)
                    <div>{{ $act }}</div>
                @endforeach
            @endif
        </td>
    </tr>
    <tr>
        <th>Bữa ăn</th>
        <td>{{ $schedule->meals }}</td>
    </tr>
    <tr>
        <th>Nơi ở</th>
        <td>{{ $schedule->accommodation }}</td>
    </tr>
    <tr>
        <th>Phương tiện</th>
        <td>{{ $schedule->transport }}</td>
    </tr>
</table>

<a href="{{ BASE_URL }}tours/{{ $tour_id }}/schedules" class="btn btn-secondary">Quay lại</a>

@endsection
