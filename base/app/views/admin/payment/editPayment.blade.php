@extends('layout.dashboard')
@section('title', 'Sửa thanh toán')

@section('active-payment', 'active')
@section('content')
    <h3>Sửa thanh toán #{{ $detail->id }}</h3>

    {{-- Thông báo lỗi --}}
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

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <a href="{{ route('list-payment') }}" class="btn btn-warning mb-3">Quay lại danh sách</a>

    <form action="{{ route('edit-payment/' . $detail->id) }}" method="post">
        {{-- chọn booking --}}
        <div class="mb-3">
            <label class="form-label">Booking</label>
            <select name="booking_id" class="form-select" required>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $detail->booking_id ? 'selected' : '' }}>
                        Booking #{{ $b->id }} - {{ $b->tour_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- số tiền --}}
        <div class="mb-3">
            <label class="form-label">Số tiền</label>
            <input type="number" step="0.01" class="form-control" name="amount" value="{{ $detail->amount }}" required>
        </div>

        {{-- phương thức --}}
        <div class="mb-3">
            <label class="form-label">Phương thức</label>
            <select name="method" class="form-select" required>
                <option value="cash" {{ $detail->method === 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                <option value="bank" {{ $detail->method === 'bank' ? 'selected' : '' }}>Ngân hàng</option>
                <option value="card" {{ $detail->method === 'card' ? 'selected' : '' }}>Thẻ</option>
                <option value="momo" {{ $detail->method === 'momo' ? 'selected' : '' }}>Momo</option>
                <option value="zalo" {{ $detail->method === 'zalo' ? 'selected' : '' }}>ZaloPay</option>
            </select>
        </div>

        {{-- mã giao dịch --}}
        <div class="mb-3">
            <label class="form-label">Mã giao dịch</label>
            <input type="text" class="form-control" name="transaction_code" value="{{ $detail->transaction_code }}">
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $detail->status === 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                <option value="success" {{ $detail->status === 'success' ? 'selected' : '' }}>Thành công</option>
                <option value="failed" {{ $detail->status === 'failed' ? 'selected' : '' }}>Thất bại</option>
            </select>
        </div>

        {{-- thời gian thanh toán --}}
        <div class="mb-3">
            <label class="form-label">Thời gian thanh toán</label>
            <input type="datetime-local" class="form-control" name="paid_at" 
                   value="{{ $detail->paid_at ? date('Y-m-d\TH:i', strtotime($detail->paid_at)) : '' }}">
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
    </form>
@endsection