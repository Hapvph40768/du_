@extends('admin.dashboard')

@section('title', 'Thêm lịch trình')
@section('content')

<h4>Thêm lịch trình cho Tour #{{ $tour_id }}</h4>

@if(isset($_SESSION['errors']))
    <div class="alert alert-danger">
        @foreach($_SESSION['errors'] as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    <?php unset($_SESSION['errors']); ?>
@endif

<form action="{{ BASE_URL }}tours/{{ $tour_id }}/schedules/store" method="post">
    <div class="mb-3">
        <label>Ngày thứ (Day Number)</label>
        <input type="number" name="day_number" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Ngày</label>
        <input type="date" name="date" class="form-control">
    </div>
    <div class="mb-3">
        <label>Tiêu đề</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Hoạt động (mỗi dòng một hoạt động)</label>
        <textarea name="activities" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Bữa ăn</label>
        <input type="text" name="meals" class="form-control">
    </div>
    <div class="mb-3">
        <label>Nơi ở</label>
        <input type="text" name="accommodation" class="form-control">
    </div>
    <div class="mb-3">
        <label>Phương tiện</label>
        <input type="text" name="transport" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Thêm</button>
</form>

@endsection
