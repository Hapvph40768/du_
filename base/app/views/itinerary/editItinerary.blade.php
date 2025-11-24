@extends('admin.dashboard')
@section('title', 'Sửa Lịch trình theo ngày')

@section('active-itinerary', 'active')
@section('content')
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
    <a href="{{route('list-itinerary')}}">
        <button type="button" class="btn btn-warning">Quay lai</button>
    </a>
    <form action="{{route('edit-itinerary/'. $detail->id)}}" method="post">

        {{-- ten tour --}}
        <div class="mb-3">
            <label>Chọn Tour:</label><br>
            <select name="tour_id">
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ $tour->id == $detail->tour_id ? 'selected' : '' }}>
                        {{ $tour->name }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- thoi gian tour --}}
        <div class="mb-3">
            <label for="day_number" class="form-label">Ngay thu trong lich trinh</label>
            <input type="number" class="form-control" name="day_number" value="{{ $detail->day_number }}">
        </div>
        {{-- tieu de --}}
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề của ngày</label>
            <input type="text" class="form-control" name="title" value="{{ $detail->title }}">
        </div>

        {{-- noi dung chi tiet --}}
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung chi tiết của ngày</label>
            <input type="text" class="form-control" name="content" value="{{ $detail->content }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>

    </form>
@endsection