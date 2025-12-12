@extends('layout.dashboard')
@section('title','Sửa Lịch khởi hành')

@section('active-departure','active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-calendar-check"></i> Sửa Lịch khởi hành</h2>
        <a href="{{ route('list-departure') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">{{ $_SESSION['success'] }}</div>
    @endif

    <form action="{{ route('edit-departure/'.$detail->id) }}" method="post" class="bg-light p-4 rounded shadow-sm">
        {{-- chọn tour --}}
        <div class="mb-3">
            <label for="tour_id" class="form-label fw-bold">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-select" required>
                @foreach($tours as $tour)
                    <option value="{{ $tour->id }}" {{ $tour->id == $detail->tour_id ? 'selected' : '' }}>
                        {{ $tour->name }}
                    </option>
                @endforeach
            </select>
            @if(isset($_SESSION['errors']['tour_id']))
                <small class="text-danger">{{ $_SESSION['errors']['tour_id'] }}</small>
            @endif
        </div>

        {{-- tổng số ghế --}}
        <div class="mb-3">
            <label for="total_seats" class="form-label fw-bold">Tổng số ghế</label>
            <input type="number" class="form-control" name="total_seats" value="{{ $detail->total_seats }}" placeholder="Ví dụ: 20">
            @if(isset($_SESSION['errors']['total_seats']))
                <small class="text-danger">{{ $_SESSION['errors']['total_seats'] }}</small>
            @endif
        </div>

        {{-- số ghế còn lại (readonly) --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label fw-bold text-white mb-1">Ngày khởi hành</label>
                        @php
                            $sDate = $detail->start_date ?? $detail->booking_start_date;
                            $valStart = $sDate ? date('Y-m-d', strtotime($sDate)) : '';
                        @endphp
                        <input type="date" class="form-control bg-dark text-white border-secondary" id="start_date" name="start_date" 
                               value="{{ $valStart }}">
                    </div>
                    <div class="col-md-4">
                        <label for="start_time" class="form-label fw-bold text-white mb-1">Giờ khởi hành</label>
                        <input type="time" class="form-control bg-dark text-white border-secondary" id="start_time" name="start_time" 
                               value="{{ $detail->start_time ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label fw-bold text-white mb-1">Ngày kết thúc</label>
                        @php
                            $eDate = $detail->end_date ?? $detail->booking_end_date;
                            $valEnd = $eDate ? date('Y-m-d', strtotime($eDate)) : '';
                        @endphp
                        <input type="date" class="form-control bg-dark text-white border-secondary" id="end_date" name="end_date" 
                               value="{{ $valEnd }}">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="fw-bold text-white mb-1">Điểm đón khách (từ Booking)</label>
                    <div class="form-control bg-dark text-warning border-secondary fst-italic">
                        <i class="fas fa-map-marked-alt me-2"></i>{{ !empty($detail->pickup_locations_list) ? $detail->pickup_locations_list : 'Chưa có thông tin điểm đón' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold text-white mb-1">Tổng số ghế</label>
                    <input type="number" name="total_seats" class="form-control bg-dark text-white border-secondary" value="{{ $detail->total_seats }}" >
                    <div class="form-text text-white-50">Số ghế đã đặt: {{ $detail->seats_booked }}. Tổng ghế không được nhỏ hơn số này.</div>
                </div>



        {{-- trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label fw-bold">Trạng thái</label>
            <select name="status" class="form-select" required>
                <option value="open" {{ $detail->status === 'open' ? 'selected' : '' }}>Đang mở</option>
                <option value="closed" {{ $detail->status === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                <option value="full" {{ $detail->status === 'full' ? 'selected' : '' }}>Đầy chỗ</option>
                <option value="completed" {{ $detail->status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
            </select>
            @if(isset($_SESSION['errors']['status']))
                <small class="text-danger">{{ $_SESSION['errors']['status'] }}</small>
            @endif
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary" name="btn-submit">
                <i class="fas fa-check-circle"></i> Xác nhận
            </button>
        </div>
    </form>
</div>
@endsection