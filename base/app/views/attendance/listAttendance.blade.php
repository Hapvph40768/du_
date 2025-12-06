@extends('admin.dashboard')
@section('title', 'Điểm danh khách')
@section('active-attendance', 'active')
@section('content')

<h2>Điểm danh khách cho lịch khởi hành {{ $departureId }}</h2>

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div class="alert alert-danger">
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div class="alert alert-success">
        {{ $_SESSION['success'] }}
    </div>
@endif

<form action="{{ BASE_URL }}attendance/save" method="POST">
    <input type="hidden" name="departure_id" value="{{ $departureId }}">

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ Tên</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach($attendances as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                        {{ $item->fullname }}
                        <input type="hidden" name="customer[{{ $item->id }}]" value="{{ $item->customer_id }}">
                    </td>
                    <td>
                        <select name="attendance[{{ $item->id }}]" class="form-select">
                            <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Chưa điểm danh</option>
                            <option value="present" {{ $item->status == 'present' ? 'selected' : '' }}>Có mặt</option>
                            <option value="absent" {{ $item->status == 'absent' ? 'selected' : '' }}>Vắng mặt</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-success">Lưu điểm danh</button>
</form>

<a href="{{ BASE_URL }}list-attendance/{{ $departureId }}" class="btn btn-primary mt-2">Quay lại danh sách</a>

@endsection
