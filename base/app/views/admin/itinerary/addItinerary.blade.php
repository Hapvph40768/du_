@extends('layout.dashboard')
@section('title', 'Thêm Lịch trình theo ngày')

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

    <a href="{{ route('list-itinerary') }}">
        <button type="button" class="btn btn-warning">Quay lại</button>
    </a>

    <form action="{{ route('post-itinerary') }}" method="post">
        {{-- chọn tour --}}
        <div class="mb-3">
            <label>Chọn Tour:</label><br>
            <select name="tour_id" required>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- ngày thứ --}}
        <div class="mb-3">
            <label for="day_number" class="form-label">Ngày thứ mấy trong lịch trình</label>
            <input type="number" class="form-control" name="day_number" min="1" required>
        </div>

        {{-- tiêu đề --}}
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề của ngày</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        {{-- nội dung chi tiết --}}
        <div class="mb-3">
            <label for="description" class="form-label">Nội dung chi tiết của ngày</label>
            <textarea class="form-control" name="description" rows="5" required></textarea>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Xác nhận</button>
        </div>
    </form>
@endsection