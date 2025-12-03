@extends('layout.dashboard')
@section('title', 'Thêm booking')

@section('active-booking', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{ $_SESSION['success'] }}</span>
    @endif

    <a href="{{ route('list-booking') }}">
        <button type="button" class="btn btn-warning">Quay lại</button>
    </a>

    <form action="{{ route('post-booking') }}" method="post">
        {{-- chọn lịch khởi hành --}}
        <div class="mb-3">
            <label>Chọn lịch khởi hành</label><br>
            <select name="departure_id" required>
                @foreach($departures as $d)
                    <option value="{{ $d->id }}">
                        {{ $d->tour_name }} ({{ $d->start_date }} - {{ $d->end_date }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- chọn khách hàng --}}
        <div class="mb-3">
            <label for="customer_id" class="form-label">Khách hàng</label>
            <select name="customer_id">
                <option value="">-- Không liên kết --</option>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}">{{ $c->fullname }} - {{ $c->phone }}</option>
                @endforeach
            </select>
        </div>

        {{-- số lượng người --}}
        <div class="mb-3">
            <label for="num_people" class="form-label">Số lượng người</label>
            <input type="number" class="form-control" name="num_people" min="1" required>
        </div>

        {{-- tổng tiền --}}
        <div class="mb-3">
            <label for="total_price" class="form-label">Tổng tiền</label>
            <input type="number" class="form-control" name="total_price" step="0.01" required>
        </div>

        {{-- trạng thái thanh toán --}}
        <div class="mb-3">
            <label for="payment_status" class="form-label">Trạng thái thanh toán</label>
            <select name="payment_status" class="form-select" required>
                <option value="unpaid">Chưa thanh toán</option>
                <option value="partial">Thanh toán một phần</option>
                <option value="paid">Đã thanh toán</option>
            </select>
        </div>

        {{-- trạng thái booking --}}
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái booking</label>
            <select name="status" class="form-select" required>
                <option value="pending">Đang chờ</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="cancelled">Đã hủy</option>
            </select>
        </div>

        {{-- ghi chú --}}
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea class="form-control" name="note" rows="3"></textarea>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Xác nhận</button>
        </div>
    </form>
@endsection