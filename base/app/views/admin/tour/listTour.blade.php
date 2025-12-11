@extends('layout.dashboard')
@section('title', 'Quản lý tour du lịch')
@section('active-tours', 'active')

@section('content')
<div class="page-header mb-4 d-flex justify-content-between align-items-end">
    <div>
        <h1 class="mb-1 text-dark fw-bold">Quản lý tour du lịch</h1>
        <p class="text-secondary mb-0">Theo dõi hiệu suất, quản lý lịch khởi hành và cập nhật thông tin tour chỉ trong một nơi.</p>
    </div>
    <div class="d-flex gap-3">
        <div class="stats-mini-card bg-white border border-light shadow-sm p-3 rounded text-center" style="min-width: 140px;">
            <div class="label text-secondary small text-uppercase fw-bold">Tour đang mở</div>
            <div class="value text-success fs-4 fw-bold">{{ count($tours) }}</div>
        </div>
        <div class="stats-mini-card bg-white border border-light shadow-sm p-3 rounded text-center" style="min-width: 140px;">
            <div class="label text-secondary small text-uppercase fw-bold">Chỗ trống tuần này</div>
            <div class="value text-primary fs-4 fw-bold">64</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <span class="text-secondary text-uppercase fw-bold small" style="letter-spacing: 1px;">Bộ lọc nhanh</span>
                <a href="{{ route('list-tours') }}" class="btn btn-sm {{ !isset($_GET['status']) ? 'btn-dark' : 'btn-outline-secondary border-0' }} rounded-pill px-3">Tất cả</a>
                <a href="{{ route('list-tours') }}?status=active" class="btn btn-sm {{ (isset($_GET['status']) && $_GET['status'] == 'active') ? 'btn-success text-white' : 'btn-outline-success border-0 dim-success' }} rounded-pill px-3">Còn chỗ</a>
                <a href="{{ route('list-tours') }}?status=inactive" class="btn btn-sm {{ (isset($_GET['status']) && $_GET['status'] == 'inactive') ? 'btn-danger text-white' : 'btn-outline-danger border-0 dim-danger' }} rounded-pill px-3">Đã khóa</a>
            </div>
            
            <div class="d-flex gap-3">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute text-secondary" style="left: 12px; top: 10px;"></i>
                    <input type="text" class="form-control ps-5 rounded-pill bg-light border-0" placeholder="Tìm theo tên hoặc mã tour...">
                </div>
                <a href="{{ route('add-tour') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg"></i> Thêm tour mới
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-dark fw-bold mb-0">Danh sách tour</h5>
            <div class="badge bg-success bg-opacity-10 text-success d-flex align-items-center px-3 py-1 rounded-pill border border-success border-opacity-25">
                <span class="dot-status dot-success bg-success rounded-circle d-inline-block me-2" style="width: 6px; height: 6px;"></span> Online
            </div>
        </div>
        <p class="text-secondary small mb-3">Xem nhanh trạng thái và tình hình chỗ trống của từng tour.</p>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-uppercase text-secondary small">
                        <th style="width: 35%;">Tour</th>
                        <th style="width: 15%;">Điểm đến</th>
                        <th style="width: 15%;">Khởi hành</th>
                        <th style="width: 20%;">Tổng chỗ</th>
                        <th style="width: 15%; text-align: right;">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tours as $t)
                    <tr onclick="window.location='{{ route('show-tour/' . $t->id) }}'" style="cursor: pointer;">
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="position-relative">
                                    @if($t->thumbnail)
                                        <img src="{{ str_replace('/public', 'public', $t->thumbnail) }}" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;" alt="thumb" onerror="this.onerror=null;this.src='public/img/placeholder.png';">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                            <i class="bi bi-image fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="fw-bold text-dark">{{ $t->name }}</span>
                                        <a href="{{ route('tour-images/' . $t->id) }}" class="ms-2 text-secondary hover-text-primary" title="Quản lý ảnh">
                                            <i class="bi bi-images small"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @if($t->status == 'active')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 rounded-pill px-2 py-0 small me-2">Đang mở</span>
                                            <span class="badge bg-danger rounded-pill px-2 py-0 small">Mới</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 rounded-pill px-2 py-0 small">Đã khóa</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-dark">{{ $t->destination ?? 'Chưa cập nhật' }}</td>
                        <td class="text-secondary">
                            {{-- Mocking next departure date for demo --}}
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                {{ date('d/m/Y', strtotime('+'.rand(1,30).' days')) }}
                            </div>
                        </td>
                        <td>
                            @php 
                                $total = $t->total_seats ?? 0;
                                $booked = $t->booked_seats ?? 0;
                                $percent = $total > 0 ? ($booked / $total) * 100 : 0;
                                $color = $percent > 80 ? 'bg-danger' : ($percent > 50 ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="d-flex justify-content-between text-secondary mb-1 small">
                                <span>Đã đặt: <strong>{{ $booked }}</strong>/{{ $total }}</span>
                            </div>
                            <div class="progress bg-light" style="height: 6px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                <div class="progress-bar {{ $color }}" style="width:{{ $percent }}%"></div>
                            </div>
                        </td>
                        <td class="text-end fw-bold text-primary">
                            {{ number_format($t->price, 0, ',', '.') }} đ
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                            Chưa có tour nào trong hệ thống
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small text-uppercase fw-bold mb-1">Tỉ lệ lấp chỗ</div>
                    <div class="fs-3 fw-bold text-dark">82%</div>
                </div>
                <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2">FULL</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small text-uppercase fw-bold mb-1">Tổng doanh thu</div>
                    <div class="fs-3 fw-bold text-dark">{{ number_format($revenue, 0, ',', '.') }} đ</div>
                </div>
                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">
                    <i class="bi bi-arrow-up-short"></i> +18%
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small text-uppercase fw-bold mb-1">Tour rủi ro cao</div>
                    <div class="fs-3 fw-bold text-dark">2</div>
                </div>
                <div class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Cần đẩy bán
                </div>
            </div>
        </div>
    </div>
</div>
@endsection