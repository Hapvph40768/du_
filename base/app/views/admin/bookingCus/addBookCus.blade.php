@extends('layout.dashboard')
@section('title', 'Thêm khách vào booking')

@section('active-booking-customer', 'active')
@section('content')
    <h3>Thêm khách vào booking</h3>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
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

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('list-booking-customer') }}" class="btn btn-warning">Quay lại danh sách</a>
        <button type="button" class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#importCsvArea">
            <i class="fas fa-file-csv me-2"></i> Import từ file Excel (CSV)
        </button>
    </div>

    {{-- Import Area --}}
    <div class="collapse mb-4" id="importCsvArea">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <i class="fas fa-file-import me-2"></i> Import Khách Hàng từ CSV
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('import-booking-customer') }}" method="post" enctype="multipart/form-data">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Chọn Booking to Import</label>
                            <select name="booking_id" class="form-select" required>
                                <option value="">-- Chọn Booking --</option>
                                @foreach($bookings as $b)
                                    <option value="{{ $b->id }}" {{ isset($_GET['booking_id']) && $_GET['booking_id'] == $b->id ? 'selected' : '' }}>
                                        Booking #{{ $b->id }} - {{ $b->tour_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Chọn file CSV (.csv)</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100 fw-bold">
                                <i class="fas fa-upload me-2"></i> Upload
                            </button>
                        </div>
                    </div>
                    <div class="form-text mt-2">
                        <strong>Lưu ý:</strong> File CSV cần có các cột theo thứ tự: <code>Họ tên, SĐT, CCCD/CMND, Giới tính (nam/nu/khac), Ngày sinh (yyyy-mm-dd), Ghi chú</code>.
                        <br>Bỏ qua dòng tiêu đề đầu tiên nếu có.
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form action="{{ route('post-booking-customer') }}" method="post">
        {{-- chọn booking --}}
        <div class="mb-3">
            <label class="form-label">Booking</label>
            @php
                $selected_booking_id = $_GET['booking_id'] ?? null;
                $current_booking = null;
                if ($selected_booking_id) {
                    foreach($bookings as $b) {
                        if ($b->id == $selected_booking_id) {
                            $current_booking = $b;
                            break;
                        }
                    }
                }
            @endphp

            @if($current_booking)
                <input type="hidden" name="booking_id" value="{{ $current_booking->id }}">
                <input type="text" class="form-control" value="Booking #{{ $current_booking->id }} - Tour {{ $current_booking->tour_name }} ({{ date('d/m/Y', strtotime($current_booking->start_date)) }} - {{ date('d/m/Y', strtotime($current_booking->end_date)) }})" disabled>
            @else
                <select name="booking_id" class="form-select" required>
                    <option value="">-- Chọn Booking --</option>
                    @foreach($bookings as $b)
                        <option value="{{ $b->id }}">
                            Booking #{{ $b->id }} - Tour {{ $b->tour_name }}
                            ({{ date('d/m/Y', strtotime($b->start_date)) }} - {{ date('d/m/Y', strtotime($b->end_date)) }})
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        {{-- họ tên --}}
        <div class="mb-3">
            <label for="fullname" class="form-label">Họ tên</label>
            <input type="text" class="form-control" name="fullname" required>
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="phone">
        </div>

        {{-- ID Card --}}
        <div class="mb-3">
            <label for="id_card" class="form-label">CCCD/CMND</label>
            <input type="text" class="form-control" name="id_card">
        </div>

        {{-- giới tính --}}
        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select name="gender" class="form-select" required>
                <option value="">-- Chọn giới tính --</option>
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
                <option value="other">Khác</option>
            </select>
        </div>

        {{-- ngày sinh --}}
        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" name="dob" required>
        </div>

        {{-- ghi chú --}}
        <div class="mb-3">
            <label for="note" class="form-label">Ghi chú</label>
            <textarea class="form-control" name="note" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Xác nhận</button>
    </form>
@endsection
