@extends('layout.dashboard')
@section('title', 'Danh sách Booking')

@section('active-booking', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-book"></i> Danh sách Booking</h2>
        <a href="{{ route('add-booking') }}" class="btn btn-info">
            <i class="fas fa-plus-circle"></i> Thêm booking
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
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Tour & Lịch khởi hành</th>
                    <th>Người đặt</th>
                    <th>Số điện thoại</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>
                            <strong>{{ $b->tour_name }}</strong><br>
                            <small class="text-muted">{{ date('d/m/Y', strtotime($b->start_date)) }} → {{ date('d/m/Y', strtotime($b->end_date)) }}</small>
                        </td>
                        <td>{{ $b->customer_name ?? 'N/A' }}</td>
                        <td>{{ $b->customer_phone ?? 'N/A' }}</td>
                        <td>{{ $b->num_people }}</td>
                        <td class="text-success">{{ number_format($b->total_price, 0, ',', '.') }} đ</td>
                        <td>
                            @switch($b->payment_status)
                                @case('unpaid')
                                    <span class="badge bg-danger">Chưa thanh toán</span>
                                    @break
                                @case('partial')
                                    <span class="badge bg-warning text-dark">Thanh toán một phần</span>
                                    @break
                                @case('paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @switch($b->status)
                                @case('pending')
                                    <span class="badge bg-secondary">Đang chờ</span>
                                    @break
                                @case('confirmed')
                                    <span class="badge bg-success">Đã xác nhận</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <a href="{{ route('detail-booking/' . $b->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i>sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-booking/' . $b->id) }}')">
                                <i class="fas fa-trash-alt"></i>xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Chưa có booking nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection