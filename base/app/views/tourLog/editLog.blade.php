@extends('admin.dashboard')
@section('title', 'Sửa log')

@section('active-departure', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{route('edit-tourlog/' . $detail->id)}}" method="post">
        <div class="form-group">
            <label>Đợt khởi hành</label>
            <select name="departure_id" class="form-control">
                <option value="">-- Chọn đợt khởi hành --</option>
                @foreach($departures as $d)
                    <option value="{{$d->id}}" {{ $d->id == $detail->departure_id ? 'selected' : '' }}>{{$d->tour_name}} - {{$d->date_start}} -> {{$d->date_end}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ngày thứ</label>
            <input type="number" name="day_number" class="form-control" value="{{ $detail->day_number }}" />
        </div>

        <div class="form-group">
            <label>Ghi chú</label>
            <textarea name="note" class="form-control">{{ $detail->note }}</textarea>
        </div>

        <button type="submit" name="btn-submit" class="btn btn-primary">Cập nhật</button>
    </form>

@endsection