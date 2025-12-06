@extends('layout.dashboard')
@section('title', 'Sửa Yêu cầu thay đổi dịch vụ')
@section('active-request', 'active')

@section('content')
<div class="container-fluid">
    <h3>Sửa Yêu cầu #{{ $detail->id }}</h3>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    <form action="{{ route('edit-request/' . $detail->id) }}" method="post">
        {{-- Booking --}}
        <div class="mb-3">
            <label for="booking_id" class="form-label">Booking</label>
            <select name="booking_id" id="booking_id" class="form-select" required>
                <option value="{{ $detail->booking_id }}">Booking #{{ $detail->booking_id }}</option>
                {{-- Thêm các booking khác nếu cần --}}
            </select>
        </div>

        {{-- Nội dung yêu cầu --}}
        <div class="mb-3">
            <label for="request" class="form-label">Nội dung yêu cầu</label>
            <textarea class="form-control" name="request" rows="4" required>{{ $detail->request }}</textarea>
        </div>

        {{-- Trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="pending" {{ $detail->status === 'pending' ? 'selected' : '' }}>Đang chờ</option>
                <option value="approved" {{ $detail->status === 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="rejected" {{ $detail->status === 'rejected' ? 'selected' : '' }}>Từ chối</option>
            </select>
        </div>

        {{-- Thông tin duyệt --}}
        <div class="mb-3">
            <label class="form-label">Người duyệt</label>
            <input type="text" class="form-control" value="{{ $detail->decision_by_name ?? '—' }}" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Thời điểm duyệt</label>
            <input type="text" class="form-control" value="{{ $detail->decided_at ? date('d/m/Y H:i', strtotime($detail->decided_at)) : '—' }}" disabled>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
        <a href="{{ route('list-request') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
