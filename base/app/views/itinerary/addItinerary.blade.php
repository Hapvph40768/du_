@extends('layout.main')
@section('content-itinerary')
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
    <form action="{{route('post-itinerary')}}" method="post">

        {{-- ten tour --}}
        <div class="mb-3">
            <label>Chọn Tour:</label><br>
            <select name="tour_id" required>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- thoi gian tour --}}
        <div class="mb-3">
            <label for="day_number" class="form-label">Ngày thứ mấy trong lịch trình</label>
            <input type="number" class="form-control" name="day_number">
        </div>
        {{-- tieu de --}}
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề của ngày</label>
            <input type="text" class="form-control" name="title">
        </div>

        {{-- noi dung chi tiet --}}
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung chi tiết của ngày</label>
            <input type="text" class="form-control" name="content">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>

    </form>
@endsection