@extends('layout.dashboard')
@section('title', 'Danh sách Booking')
@section('active-booking', 'active')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">
            <i class="fas fa-ticket-alt"></i> Danh sách Booking
        </h2>
        <a href="{{ route('add-booking') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle"></i> Thêm Booking
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle"></i> {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle"></i> Đã xảy ra lỗi:
            <ul class="mt-2 mb-0">
                @foreach($_SESSION['errors'] as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered table-hover text-center align-middle mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Tour</th>
                    <th>Ngày đi</th>
                    <th>Số người</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th width="130px">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $index => $b)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $b->customer_name }}</td>
                        <td>{{ $b->tour_name }}</td>
                        <td>{{ date('d/m/Y', strtotime($b->start_date)) }}</td>

                        <td>
                            <span class="badge bg-info">{{ $b->num_people }}</span>
                        </td>

                        <td class="text-success fw-bold">
                            {{ number_format($b->total_price, 0, ',', '.') }} đ
                        </td>

                        {{-- PAYMENT --}}
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

                        {{-- STATUS --}}
                        <td>
                            @switch($b->status)
                                @case('pending')
                                    <span class="badge bg-secondary">Chờ xác nhận</span>
                                @break
                                @case('confirmed')
                                    <span class="badge bg-primary">Đã xác nhận</span>
                                @break
                                @case('cancelled')
                                    <span class="badge bg-dark">Đã hủy</span>
                                @break
                                @case('completed')
                                    <span class="badge bg-success">Hoàn thành</span>
                                @break
                            @endswitch
                        </td>

                        <td>{{ $b->note ?: '-' }}</td>

                        {{-- ACTION --}}
                        <td>
                            <a href="{{ route('detail-booking/'.$b->id) }}"
                                class="btn btn-sm btn-warning me-1 shadow-sm">
                                <i class="fas fa-edit"></i>Sửa 
                            </a>

                            <button class="btn btn-sm btn-danger shadow-sm"
                                onclick="confirmDelete('{{ route('delete-booking/'.$b->id) }}')">
                                <i class="fas fa-trash-alt"></i>Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-muted py-3">
                            <i class="fas fa-info-circle"></i> Chưa có booking nào
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

{{-- SCRIPT XÓA --}}
<script>
    function confirmDelete(url) {
        if (confirm("Bạn có chắc muốn xóa booking này?")) {
            window.location.href = url;
        }
    }
</script>

@endsection
