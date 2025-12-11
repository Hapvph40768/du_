@extends('layout.dashboard')
@section('title', 'Báo cáo Doanh thu & Lợi nhuận')
@section('active-report', 'active')
@section('content')

<div class="page-header mb-4">
    <h1 class="text-white mb-2">Báo cáo Tài chính</h1>
    <p class="text-muted">Thống kê doanh thu, chi phí và lợi nhuận theo từng Tour/Khởi hành.</p>
</div>

{{-- Filter --}}
<div class="card-dark p-3 mb-4">
    <form action="" method="GET" class="d-flex align-items-end gap-3">
        <div>
            <label class="text-white-50 small fw-bold mb-1">Tháng</label>
            <select name="month" class="form-select form-select-sm" style="width: 100px;">
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>Tháng {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="text-white-50 small fw-bold mb-1">Năm</label>
            <select name="year" class="form-select form-select-sm" style="width: 100px;">
                @for($y=date('Y'); $y>=2020; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm px-4">Xem báo cáo</button>
    </form>
</div>

{{-- Summary Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card-dark p-3 border-start border-4 border-success h-100">
            <small class="text-muted text-uppercase fw-bold">Tổng Doanh Thu</small>
            <h3 class="text-success mt-2 mb-0">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-dark p-3 border-start border-4 border-danger h-100">
            <small class="text-muted text-uppercase fw-bold">Tổng Chi Phí</small>
            <h3 class="text-danger mt-2 mb-0">{{ number_format($totalCost, 0, ',', '.') }} đ</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-dark p-3 border-start border-4 border-info h-100">
            <small class="text-muted text-uppercase fw-bold">Lợi Nhuận Thực Tế</small>
            <h3 class="{{ $totalProfit >= 0 ? 'text-info' : 'text-warning' }} mt-2 mb-0">
                {{ number_format($totalProfit, 0, ',', '.') }} đ
            </h3>
        </div>
    </div>
</div>

{{-- Detail Table --}}
<div class="card-dark p-0">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Khởi hành</th>
                    <th>Tour</th>
                    <th class="text-end">Doanh thu</th>
                    <th class="text-end">Chi phí</th>
                    <th class="text-end">Lợi nhuận</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportData as $row)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($row['start_date'])) }}</td>
                    <td class="fw-bold text-white">{{ $row['tour_name'] }}</td>
                    <td class="text-end text-success">{{ number_format($row['revenue'], 0, ',', '.') }} đ</td>
                    <td class="text-end text-danger">{{ number_format($row['cost'], 0, ',', '.') }} đ</td>
                    <td class="text-end fw-bold {{ $row['profit'] >= 0 ? 'text-info' : 'text-warning' }}">
                        {{ number_format($row['profit'], 0, ',', '.') }} đ
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-secondary" onclick="openCostModal({{ $row['departure_id'] }}, '{{ $row['tour_name'] }}')">
                            <i class="bi bi-plus-lg"></i> Thêm chi phí
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Không có dữ liệu khởi hành trong tháng này.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Add Cost --}}
<div class="modal fade" id="costModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <form action="{{ route('add-cost') }}" method="POST">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Thêm Chi Phí</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="departure_id" id="modal_departure_id">
                    <div class="mb-3">
                        <label class="form-label">Tour: <span id="modal_tour_name" class="fw-bold text-info"></span></label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên khoản chi</label>
                        <input type="text" name="title" class="form-control bg-secondary text-white border-0" required placeholder="Ví dụ: Thuê xe, Vé tham quan...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số tiền</label>
                        <input type="number" name="amount" class="form-control bg-secondary text-white border-0" required min="0">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Lưu Chi Phí</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCostModal(depId, tourName) {
        document.getElementById('modal_departure_id').value = depId;
        document.getElementById('modal_tour_name').textContent = tourName;
        new bootstrap.Modal(document.getElementById('costModal')).show();
    }
</script>

@endsection
