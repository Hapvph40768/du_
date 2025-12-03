@extends('layout.dashboard')
@section('title', 'Sửa Attendance')

@section('active-attendance', 'active')
@section('content')
    <h1>Sửa Attendance</h1>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('list-attendance') }}">
        <button type="button" class="btn btn-warning">Quay lại</button>
    </a>

    <form action="{{ route('update-attendance/' . $detail->id) }}" method="post">
        {{-- chọn departure --}}
        <div class="mb-3">
            <label>Lịch khởi hành</label>
            <select name="departure_id" required>
                @foreach($departures as $d)
                    <option value="{{ $d->id }}" {{ $d->id == $detail->departure_id ? 'selected' : '' }}>
                        {{ $d->tour_name }} ({{ $d->start_date }} - {{ $d->end_date }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- chọn customer --}}
        <div class="mb-3">
            <label>Khách hàng</label>
            <select name="customer_id" required>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ $c->id == $detail->customer_id ? 'selected' : '' }}>
                        {{ $c->fullname }} - {{ $c->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- chọn booking_customer --}}
        <div class="mb-3">
            <label>Booking Customer (nếu có)</label>
            <select name="booking_customer_id">
                <option value="">-- Không chọn --</option>
                @foreach($bookingCustomers as $bc)
                    <option value="{{ $bc->id }}" {{ $bc->id == $detail->booking_customer_id ? 'selected' : '' }}>
                        {{ $bc->fullname }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- trạng thái --}}
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="present" {{ $detail->status === 'present' ? 'selected' : '' }}>Có mặt</option>
                <option value="absent" {{ $detail->status === 'absent' ? 'selected' : '' }}>Vắng</option>
            </select>
        </div>

        {{-- checkin_time --}}
        <div class="mb-3">
            <label for="checkin_time" class="form-label">Thời gian check-in</label>
            <input type="datetime-local" class="form-control" name="checkin_time" value="{{ $detail->checkin_time }}">
        </div>

        {{-- ghi chú --}}
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea class="form-control" name="note">{{ $detail->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
    </form>
@endsection