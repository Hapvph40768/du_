@extends('admin.dashboard')
@section('title','Chỉnh sửa Tour Log')

@section('active-tour-log','active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{route('list-tour-log')}}"><button type="button" class="btn btn-warning">Quay lại</button></a>

    <form action="{{route('edit-tour-log/' . $detail->id)}}" method="post">
        <div class="mb-3">
            <label for="departure_id">Chọn Departure</label>
            <select name="departure_id" id="departure_id" class="form-control">
                @foreach($departures as $d)
                    <option value="{{ $d->id }}" {{ $d->id == ($detail->departure_id ?? '') ? 'selected' : '' }}>{{ $d->tour_title ?? ($d->tour_name ?? 'Tour') }} - {{ $d->depart_date }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="day_number" class="form-label">Ngày thứ</label>
            <input type="number" class="form-control" name="day_number" id="day_number" value="{{ $detail->day_number ?? '' }}">
        </div>

        <div class="mb-3">
            <label for="note">Ghi chú</label>
            <textarea name="note" id="note" class="form-control">{{ $detail->note ?? '' }}</textarea>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Lưu</button>
        </div>
    </form>
@endsection
