@extends('admin.dashboard')
@section('title', 'Sửa Lịch khởi hành của tour')

@section('active-departure', 'active')
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
    <a href="{{route('list-departure')}}">
        <button type="button" class="btn btn-warning">Quay lai</button>
    </a>
    <form action="{{route('edit-departure/' . $detail->id)}}" method="post">

        {{-- ten tour --}}
        <div class="mb-3">
            <label>Chọn Tour:</label><br>
            <select name="tour_id">
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ $tour->id == $detail->tour_id ? 'selected' : '' }}>
                        {{ $tour->title ?? $tour->name ?? 'Untitled' }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- thoi gian tour --}}
        <div class="mb-3">
            <label for="depart_date" class="form-label">Ngày khởi hành</label>
            <input type="date" class="form-control" name="depart_date" value="{{ $detail->depart_date ?? $detail->date_start ?? '' }}">
        </div>
        {{-- thoi gian tour --}}
        <div class="mb-3">
            <!-- end date removed from schema; legacy compatibility fields ignored -->
        </div>

        {{-- Tong cho --}}
        <div class="mb-3">
            <label for="seats_total" class="form-label">Tong cho</label>
            <input type="number" class="form-control" name="seats_total" value="{{ $detail->seats_total }}">
        </div>
        {{-- Cho con lai --}}
        <div class="mb-3">
            <label for="seats_booked" class="form-label">Số chỗ đã đặt</label>
            <input type="number" class="form-control" name="seats_booked" value="{{ $detail->seats_booked ?? 0 }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>

    </form>
@endsection