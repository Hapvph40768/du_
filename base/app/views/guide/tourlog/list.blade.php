@extends('layout.guide')
@section('title', 'Nhật ký tour')

@section('active-guide-tourlog', 'active')
@section('content')
<h1>Danh sách nhật ký tour</h1>

<a href="{{ route('add-guide-tourlog') }}" class="btn btn-primary mb-3">+ Thêm nhật ký</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Departure</th>
            <th>Ngày thứ</th>
            <th>Ghi chú</th>
            <th>Bắt đầu</th>
            <th>Kết thúc</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->id }}</td>
            <td>#{{ $log->departure_id }}</td>
            <td>Ngày {{ $log->day_number }}</td>
            <td>{{ $log->note }}</td>
            <td>{{ $log->date_start }}</td>
            <td>{{ $log->date_end }}</td>

            <td>
                <a href="{{ route('detail-guide-tourlog/' . $log->id) }}" class="btn btn-warning">Sửa</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
