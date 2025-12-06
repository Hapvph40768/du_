@extends('layout.dashboard')
@section('title', 'Danh sách thanh toán')
@section('active-payment', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary"><i class="fas fa-credit-card"></i> Danh sách thanh toán</h1>
        <a href="{{ route('add-payment') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm thanh toán
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
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

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Booking</th>
                    <th>Số tiền</th>
                    <th>Phương thức</th>
                    <th>Mã giao dịch</th>
                    <th>Trạng thái</th>
                    <th>Thời gian thanh toán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td><span class="fw-bold">Booking #{{ $p->booking_id }}</span></td>
                        <td class="text-success">
                            {{ number_format($p->amount, 0, ',', '.') }} {{ $p->currency ?? 'VND' }}
                        </td>
                        <td>{{ ucfirst($p->method) }}</td>
                        <td><span class="text-muted">{{ $p->transaction_code }}</span></td>
                        <td>
                            @if($p->status === 'completed')
                                <span class="badge bg-success">Hoàn tất</span>
                            @elseif($p->status === 'pending')
                                <span class="badge bg-warning text-dark">Đang chờ</span>
                            @else
                                <span class="badge bg-danger">Thất bại</span>
                            @endif
                        </td>
                        <td><span class="text-muted">{{ $p->paid_at }}</span></td>
                        <td>
                            <a href="{{ route('detail-payment/' . $p->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-payment/' . $p->id) }}')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-muted">Chưa có thanh toán nào được thêm</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(deleteUrl) {
        if (confirm("Bạn có chắc chắn muốn xóa thanh toán này?")) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection