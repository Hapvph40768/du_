@extends('layout.dashboard')
@section('title', 'Thêm Yêu cầu thay đổi dịch vụ')

@section('active-request', 'active')
@section('content')
    <h3>Thêm Yêu cầu mới</h3>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul>
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    <form action="{{ route('post-request') }}" method="post">
        <div class="mb-3">
            <label for="booking_id" class="form-label">Booking ID</label>
            <input type="number" class="form-control" name="booking_id" required>
        </div>

        <div class="mb-3">
            <label for="request" class="form-label">Nội dung yêu cầu</label>
            <textarea class="form-control" name="request" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="pending">Đang chờ</option>
                <option value="approved">Đã duyệt</option>
                <option value="rejected">Từ chối</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Thêm</button>
        <a href="{{ route('list-request') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection