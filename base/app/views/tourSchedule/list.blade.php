@extends('admin.dashboard')

@section('title', 'Danh sách lịch trình')
@section('content')

<h4>Lịch trình Tour #{{ $tour_id }}</h4>
<a href="{{ BASE_URL }}tours/{{ $tour_id }}/schedules/create" class="btn btn-primary mb-3">+ Thêm ngày</a>

@if(isset($_SESSION['success']))
    <div class="alert alert-success">{{ $_SESSION['success'] }}</div>
    <?php unset($_SESSION['success']); ?>
@endif

@if(isset($_SESSION['errors']))
    <div class="alert alert-danger">
        @foreach($_SESSION['errors'] as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    <?php unset($_SESSION['errors']); ?>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Ngày thứ</th>
            <th>Ngày</th>
            <th>Tiêu đề</th>
            <th>Mô tả</th>
            <th>Hoạt động</th>
            <th>Bữa ăn</th>
            <th>Nơi ở</th>
            <th>Phương tiện</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($schedules as $schedule)
        <tr>
            <td>{{ $schedule->day_number }}</td>
            <td>{{ $schedule->date }}</td>
            <td>{{ $schedule->title }}</td>
            <td>{{ $schedule->description }}</td>
            <td>
                @if(!empty($schedule->activities))
                    @foreach(json_decode($schedule->activities) as $act)
                        <div>{{ $act }}</div>
                    @endforeach
                @endif
            </td>
            <td>{{ $schedule->meals }}</td>
            <td>{{ $schedule->accommodation }}</td>
            <td>{{ $schedule->transport }}</td>
            <td>
                <a href="{{ BASE_URL }}tours/{{ $tour_id }}/schedules/{{ $schedule->id }}/edit" class="btn btn-sm btn-warning">Sửa</a>
                <a href="{{ BASE_URL }}tours/{{ $tour_id }}/schedules/{{ $schedule->id }}/delete" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
