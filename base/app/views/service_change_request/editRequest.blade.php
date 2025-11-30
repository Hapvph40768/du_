@extends('admin.dashboard')
@section('title', 'Chỉnh sửa yêu cầu thay đổi dịch vụ')

@section('active-service-change-request', 'active')
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

    <a href="{{route('list-service-change-requests')}}"><button type="button" class="btn btn-warning">Quay lại</button></a>

    <form action="{{route('edit-service-change-request/' . $detail->id)}}" method="post">
        <div class="mb-3">
            <label for="booking_id" class="form-label">Booking ID</label>
            <input type="text" class="form-control" name="booking_id" id="booking_id" value="{{ $detail->booking_id ?? '' }}">
        </div>
        <div class="mb-3">
            <label for="request" class="form-label">Yêu cầu</label>
            <textarea class="form-control" name="request" id="request">{{ $detail->request ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <input type="text" class="form-control" name="status" id="status" value="{{ $detail->status ?? 'pending' }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="sua">Confirm</button>
        </div>
    </form>
@endsection
