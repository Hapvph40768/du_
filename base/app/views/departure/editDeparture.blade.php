@extends('layout.main')
@section('content-departure')
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
    <form action="{{route('edit-departure/' . $detail->id)}}" method="post">

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
            <label for="date_start" class="form-label">Ngay bat dau</label>
            <input type="date" class="form-control" name="date_start" value="{{ $detail->date_start }}">
        </div>
        {{-- thoi gian tour --}}
        <div class="mb-3">
            <label for="date_end" class="form-label">Ngay ket thuc</label>
            <input type="date" class="form-control" name="date_end" value="{{ $detail->date_end }}">
        </div>

        {{-- Tong cho --}}
        <div class="mb-3">
            <label for="seats_total" class="form-label">Tong cho</label>
            <input type="number" class="form-control" name="seats_total" value="{{ $detail->seats_total }}">
        </div>
        {{-- Cho con lai --}}
        <div class="mb-3">
            <label for="seats_remaining" class="form-label">Cho con lai</label>
            <input type="number" class="form-control" name="seats_remaining" value="{{ $detail->seats_remaining }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>

    </form>
@endsection