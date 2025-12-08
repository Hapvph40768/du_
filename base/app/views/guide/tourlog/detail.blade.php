@extends('layout.guide')
@section('title', 'Cập nhật nhật ký tour')

@section('active-guide-tourlog', 'active')
@section('content')
<h2>Cập nhật nhật ký tour #{{ $log->id }}</h2>

<form action="{{ route('update-guide-tourlog/' . $log->id) }}" method="POST">

    <label>Departure:</label>
    <select name="departure_id" class="form-control">
        @foreach($departures as $d)
            <option value="{{ $d->id }}" {{ $d->id == $log->departure_id ? 'selected' : '' }}>
                ID {{ $d->id }} ({{ $d->date_start }} - {{ $d->date_end }})
            </option>
        @endforeach
    </select>

    <label>Ngày thứ:</label>
    <input type="number" name="day_number" class="form-control" value="{{ $log->day_number }}">

    <label>Ghi chú:</label>
    <textarea name="note" class="form-control">{{ $log->note }}</textarea>

    <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
</form>
@endsection
