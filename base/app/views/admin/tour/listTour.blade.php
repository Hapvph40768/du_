@extends('layout.dashboard')
@section('title', 'Quản lý tour du lịch')
@section('active-tours', 'active')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h1 class="text-white mb-1">Quản lý tour du lịch</h1>
        <p class="text-muted mb-0">Theo dõi hiệu suất, quản lý lịch khởi hành và cập nhật thông tin tour chỉ trong một nơi.</p>
    </div>
    <div class="d-flex gap-3">
        <div class="stats-mini-card">
            <div class="label">Tour đang mở</div>
            <div class="value text-success text-center">{{ count($tours) }}</div>
        </div>
        <div class="stats-mini-card">
            <div class="label">Chỗ trống tuần này</div>
            <div class="value text-primary text-center">64</div>
        </div>
    </div>
</div>

<div class="card-dark p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted text-uppercase fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">Bộ lọc nhanh</span>
            <button class="filter-btn active">Tất cả</button>
            <button class="filter-btn">Sắp khởi hành</button>
            <button class="filter-btn">Còn chỗ</button>
            <button class="filter-btn">Đã khóa</button>
        </div>
        
        <div class="d-flex gap-3">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 12px; top: 10px;"></i>
                <input type="text" class="search-dark ps-5" placeholder="Tìm theo tên hoặc mã tour...">
            </div>
            <a href="{{ route('add-tour') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                <i class="bi bi-plus-lg"></i> Thêm tour mới
            </a>
        </div>
    </div>

    <div class="card-header bg-transparent border-0 px-0 pb-0 d-flex justify-content-between align-items-center">
        <h5 class="text-white mb-0">Danh sách tour</h5>
        <div class="badge bg-success bg-opacity-10 text-success d-flex align-items-center px-3 py-1 rounded-pill">
            <span class="dot-status dot-success"></span> Online
        </div>
    </div>
    <p class="text-muted small mb-3">Xem nhanh trạng thái và tình hình chỗ trống của từng tour.</p>

    <div class="table-responsive">
        <table class="table table-dark-custom w-100">
            <thead>
                <tr>
                    <th style="width: 40%;">Tour</th>
                    <th style="width: 15%;">Điểm đến</th>
                    <th style="width: 15%;">Ngày khởi hành</th>
                    <th style="width: 15%;">Chỗ trống</th>
                    <th style="width: 15%; text-align: right;">Giá</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tours as $t)
                <tr onclick="window.location='{{ route('show-tour/' . $t->id) }}'" style="cursor: pointer;">
                    <td>
                        <div class="tour-info-cell">
                            @if($t->thumbnail)
                                <img src="{{ str_replace('/public', 'public', $t->thumbnail) }}" class="tour-avatar" alt="thumb" onerror="this.onerror=null;this.src='public/img/placeholder.png';">
                            @else
                                <div class="tour-avatar d-flex align-items-center justify-content-center text-muted">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                            <div>
                                <div class="d-flex align-items-center">
                                    <span class="tour-name text-white">{{ $t->name }}</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    @if($t->status == 'active')
                                        <span class="dot-status dot-success"></span> <span class="text-muted" style="font-size: 0.8rem;">Đang mở</span>
                                        <span class="badge-tag badge-hot ms-2">Mới</span>
                                    @else
                                        <span class="dot-status dot-danger"></span> <span class="text-muted" style="font-size: 0.8rem;">Đã khóa</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $t->destination ?? 'Chưa cập nhật' }}</td>
                    <td>
                        {{-- Mocking next departure date for demo --}}
                        {{ date('d/m/Y', strtotime('+'.rand(1,30).' days')) }}
                    </td>
                    <td>
                        {{-- Mocking Seat Progress --}}
                        @php 
                            $total = rand(20, 30);
                            $booked = rand(0, $total);
                            $percent = ($booked / $total) * 100;
                            $color = $percent > 80 ? 'bg-danger' : ($percent > 50 ? 'bg-warning' : 'bg-success');
                        @endphp
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.75rem;">
                            <span>{{ $booked }}/{{ $total }} chỗ</span>
                        </div>
                        <div class="progress progress-dark">
                            <div class="progress-bar {{ $color }}" style="width:{{ $percent }}%"></div>
                        </div>
                    </td>
                    <td class="text-end fw-bold" style="color: #fff !important;">
                        {{ number_format($t->price, 0, ',', '.') }} đ
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Chưa có tour nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="footer-stat-card">
            <div>
                <div class="stat-label">Tỉ lệ lấp chỗ</div>
                <div class="stat-value text-white">82%</div>
            </div>
            <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                <small>FULL</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="footer-stat-card">
            <div>
                <div class="stat-label">Doanh thu tháng này</div>
                <div class="stat-value text-white">1.2 tỷ</div>
            </div>
             <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">
                +18% so với tháng trước
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="footer-stat-card">
            <div>
                <div class="stat-label">Tour rủi ro cao</div>
                <div class="stat-value text-white">2</div>
            </div>
             <div class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Cần đẩy bán
            </div>
        </div>
    </div>
</div>
@endsection