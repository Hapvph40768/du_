@extends('layout.guide.GuideLayout')
@section('title', 'Sửa yêu cầu dịch vụ')

@section('active-guide-scr', 'active')
@section('content')
    <div class="mb-4">
        <a href="{{ route('list-guide-scr') }}" class="text-decoration-none text-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
        <h1 class="mt-2">Sửa yêu cầu #{{ $detail->id }}</h1>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-dark p-4">
        <form action="{{ route('edit-guide-scr/' . $detail->id) }}" method="POST">
            
            <div class="mb-4">
                <label for="booking_id" class="form-label text-white-50">Booking <span class="text-danger">*</span></label>
                <select name="booking_id" id="booking_id" class="form-select form-select-dark" required>
                    @foreach($bookings as $b)
                        <option value="{{ $b->id }}" {{ $detail->booking_id == $b->id ? 'selected' : '' }}>
                            Booking #{{ $b->id }} - {{ $b->customer_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="service_id" class="form-label text-white-50">Dịch vụ (Tùy chọn)</label>
                <select name="service_id" id="service_id" class="form-select form-select-dark">
                    <option value="">-- Chọn dịch vụ --</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" {{ $s->id == $detail->service_id ? 'selected' : '' }}>
                            {{ $s->name }} ({{ number_format($s->default_price, 0, ',', '.') }} đ)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="request" class="form-label text-white-50">Nội dung yêu cầu <span class="text-danger">*</span></label>
                <textarea name="request" id="request" class="form-control form-control-dark" rows="5" required>{{ $detail->request }}</textarea>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label text-white-50">Trạng thái</label>
                @if($detail->status === 'approved')
                     <div class="alert alert-success mb-0 border-0 bg-success bg-opacity-25 text-white"><i class="bi bi-check-circle me-2"></i> Đã được duyệt</div>
                     <input type="hidden" name="status" value="{{ $detail->status }}">
                @elseif($detail->status === 'rejected')
                     <div class="alert alert-danger mb-0 border-0 bg-danger bg-opacity-25 text-white"><i class="bi bi-x-circle me-2"></i> Đã bị từ chối</div>
                     <input type="hidden" name="status" value="{{ $detail->status }}">
                @else
                    <select name="status" id="status" class="form-select form-select-dark">
                        <option value="pending" {{ $detail->status == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                        <option value="approved" {{ $detail->status == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="rejected" {{ $detail->status == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                    </select>
                @endif
            </div>

            <div class="d-flex justify-content-end gap-2">
                @if($detail->status === 'pending')
                <button type="submit" name="btn-submit" class="btn btn-primary px-4 rounded-pill">
                    <i class="bi bi-save me-2"></i> Cập nhật
                </button>
                @endif
            </div>
        </form>
    </div>
@endsection
