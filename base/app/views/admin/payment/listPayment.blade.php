@extends('layout.dashboard')
@section('title', 'Danh sách thanh toán')
@section('active-payment', 'active')

@section('content')
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-white mb-1">Quản lý thanh toán</h1>
            <p class="text-white-50 mb-0">Theo dõi và quản lý lịch sử thanh toán của khách hàng.</p>
        </div>
        <a href="{{ route('add-payment') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
            <i class="bi bi-wallet2"></i> Thêm thanh toán
        </a>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success mb-4">
            {{ $_SESSION['success'] }}
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card-dark p-3">
        <div class="table-responsive">
            <table class="table table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">ID</th>
                        <th>Thông tin Booking</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Mã giao dịch</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Thời gian</th>
                        <th class="text-center" style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td class="text-center text-white-50">{{ $p->id }}</td>
                        <td>
                            <div>
                                <span class="fw-bold text-white d-block">{{ $p->tour_name ?? 'N/A' }}</span>
                                <small class="text-white-50">
                                    {{ $p->start_date ? date('d/m/Y', strtotime($p->start_date)) : '...' }} - 
                                    {{ $p->end_date ? date('d/m/Y', strtotime($p->end_date)) : '...' }}
                                </small>
                            </div>
                        </td>
                        <td class="text-success fw-bold">
                            {{ number_format($p->amount, 0, ',', '.') }} {{ $p->currency ?? 'VND' }}
                        </td>
                        <td>
                            <span class="text-white">
                                @switch($p->method)
                                    @case('bank') <i class="bi bi-bank me-1"></i> Ngân hàng @break
                                    @case('card') <i class="bi bi-credit-card me-1"></i> Thẻ @break
                                    @case('momo') <span class="text-danger fw-bold">MoMo</span> @break
                                    @case('zalo') <span class="text-primary fw-bold">ZaloPay</span> @break
                                    @default <i class="bi bi-cash me-1"></i> Tiền mặt
                                @endswitch
                            </span>
                        </td>
                        <td class="font-monospace text-white-50">{{ $p->transaction_code ?: '—' }}</td>
                        <td class="text-center">
                            @if($p->status === 'success' || $p->status === 'completed')
                                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25">Hoàn tất</span>
                            @elseif($p->status === 'pending')
                                <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-25">Đang chờ</span>
                            @else
                                <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-25">Thất bại</span>
                            @endif
                        </td>
                        <td class="text-center text-white-50 small">
                            {{ $p->paid_at ? date('d/m/Y H:i', strtotime($p->paid_at)) : '—' }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('detail-payment/' . $p->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                <i class="fas fa-edit"></i>Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa"
                                onclick="confirmDelete('{{ route('delete-payment/' . $p->id) }}')">
                                <i class="fas fa-trash-alt"></i>Xóa
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-white-50 py-4">Chưa có giao dịch thanh toán nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function confirmDelete(deleteUrl) {
        if (confirm("Bạn có chắc chắn muốn xóa thanh toán này? Hành động này không thể hoàn tác.")) {
            window.location.href = deleteUrl;
        }
    }
</script>
@endsection