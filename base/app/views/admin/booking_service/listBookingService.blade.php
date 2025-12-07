@extends('layout.dashboard')
@section('title', 'Danh sách Dịch vụ kèm Booking')
@section('active-booking-service', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="fas fa-concierge-bell"></i> Danh sách Dịch vụ kèm theo Booking
        </h1>
        <a href="{{ route('add-booking-service') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus-circle"></i> Thêm dịch vụ vào Booking
        </a>
    </div>

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
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

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Mã Booking</th>
                            <th>Dịch vụ</th>
                            <th>Số lượng</th>
                            <th>Giá tại thời điểm đặt</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookingServices as $bs)
                            <tr>
                                <td>{{ $bs->id }}</td>
                                <td class="fw-bold text-primary">Booking #{{ $bs->booking_id }}</td>
                                <td>{{ $bs->service_name }}</td>
                                <td><span class="badge bg-info">{{ $bs->quantity }}</span></td>
                                <td class="text-success">{{ number_format($bs->price, 0, ',', '.') }} đ</td>
                                <td><span class="text-muted">{{ $bs->created_at }}</span></td>
                                <td>
                                    <a href="{{ route('detail-booking-service/' . $bs->id) }}" 
                                       class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete('{{ route('delete-booking-service/' . $bs->id) }}', '{{ $bs->service_name }}')">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Chưa có dịch vụ nào được thêm vào booking</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl, serviceName) {
        if (confirm(`Bạn có chắc chắn muốn xóa dịch vụ: ${serviceName}?`)) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection