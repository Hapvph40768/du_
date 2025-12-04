@extends('layout.dashboard')
@section('title', 'Thêm thanh toán')

@section('active-payment', 'active')
@section('content')
    <h3>Thêm thanh toán</h3>

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

    <a href="{{ route('list-payment') }}" class="btn btn-warning mb-3">Quay lại danh sách</a>

    <form action="{{ route('post-payment') }}" method="post">
        {{-- chọn booking --}}
        <div class="mb-3">
            <label class="form-label">Booking</label>
            <select name="booking_id" class="form-select" required>
                <option value="">-- Chọn Booking --</option>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}">Booking #{{ $b->id }} - {{ $b->tour_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- số tiền --}}
        <div class="mb-3">
            <label class="form-label">Số tiền</label>
            <input type="number" step="0.01" class="form-control" name="amount" required>
        </div>

        {{-- phương thức --}}
        <div class="mb-3">
            <label class="form-label">Phương thức</label>
            <select name="method" class="form-select" required>
                <option value="cash">Tiền mặt</option>
                <option value="bank">Ngân hàng</option>
                <option value="card">Thẻ</option>
                <option value="momo">Momo</option>
                <option value="zalo">ZaloPay</option>
            </select>
        </div>

        {{-- mã giao dịch --}}
        <div class="mb-3">
            <label class="form-label">Mã giao dịch</label>
            <input type="text" class="form-control" name="transaction_code">
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="pending">Đang xử lý</option>
                <option value="success">Thành công</option>
                <option value="failed">Thất bại</option>
            </select>
        </div>

        {{-- thời gian thanh toán --}}
        <div class="mb-3">
            <label class="form-label">Thời gian thanh toán</label>
            <input type="datetime-local" class="form-control" name="paid_at">
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Xác nhận</button>
    </form>
@endsection