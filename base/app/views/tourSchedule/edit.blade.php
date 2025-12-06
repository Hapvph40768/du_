@extends('admin.dashboard')

@section('title', 'Sửa lịch trình')
@section('content')

<h4>Sửa lịch trình Tour #{{ $tour_id }}</h4>

@if(isset($_SESSION['errors']))
    <div class="alert alert-danger">
        @foreach($_SESSION['errors'] as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    <?php unset($_SESSION['errors']); ?>
@endif

<form action="{{ BASE_URL }}tours/{{ $tour_id }}/schedules/{{ $schedule->id }}/update" method="post">
    <div class="mb-3">
        <label>Ngày thứ (Day Number)</label>
        <input type="number" name="day_number" class="form-control" value="{{ $schedule->day_number }}" required>
    </div>
    <div class="mb-3">
        <label>Ngày</label>
        <input type="date" name="date" class="form-control" value="{{ $schedule->date }}">
    </div>
    <div class="mb-3">
        <label>Tiêu đề</label>
        <input type="text" name="title" class="form-control" value="{{ $schedule->title }}" required>
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control">{{ $schedule->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Hoạt động (mỗi dòng một hoạt động)</label>
        <textarea name="activities" class="form-control">{{ $activities_text }}</textarea>
    </div>
    <div class="mb-3">
        <label>Bữa ăn</label>
        <input type="text" name="meals" class="form-control" value="{{ $schedule->meals }}">
    </div>
    <div class="mb-3">
        <label>Nơi ở</label>
        <input type="text" name="accommodation" class="form-control" value="{{ $schedule->accommodation }}">
    </div>
    <div class="mb-3">
        <label>Phương tiện</label>
        <input type="text" name="transport" class="form-control" value="{{ $schedule->transport }}">
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>

@endsection
