@extends('layout.guide')
@section('title', 'Thêm nhật ký tour')

@section('active-guide-tourlog', 'active')
@section('content')
<h2>Thêm nhật ký tour</h2>

<form action="{{ route('post-guide-tourlog') }}" method="POST">

    <label>Departure:</label>
    <select name="departure_id" class="form-control">
        @foreach($departures as $d)
            <option value="{{ $d->id }}">ID {{ $d->id }} ({{ $d->date_start }} - {{ $d->date_end }})</option>
        @endforeach
    </select>

    <label>Ngày thứ:</label>
    <input type="number" name="day_number" class="form-control">

    <label>Ghi chú:</label>
    <textarea name="note" class="form-control"></textarea>

    <button type="submit" class="btn btn-success mt-3">Lưu</button>
</form>
@endsection
