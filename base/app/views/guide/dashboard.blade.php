@extends('layout.guide.GuideLayout')
@section('title', 'Guide Dashboard')

@section('active-dashboard', 'active')

@section('content')
    <div class="row g-4">
        {{-- Welcome Card --}}
        <div class="col-12">
            <div class="card-dark p-5 d-flex align-items-center justify-content-between position-relative overflow-hidden mb-4">
                <div class="position-relative z-1">
                    <h1 class="display-5 fw-bold text-white mb-3">Xin chào, {{ $_SESSION['user']['username'] ?? 'Guide' }}!</h1>
                    <p class="text-white-50 fs-5 mb-4" style="max-width: 600px;">
                        Chào mừng bạn trở lại hệ thống. Kiểm tra lịch trình sắp tới và các yêu cầu thay đổi dịch vụ ngay hôm nay.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('list-guide-attendance') }}" class="btn btn-primary rounded-pill px-4 py-2">
                            <i class="bi bi-clipboard-check me-2"></i> Điểm danh
                        </a>
                        <a href="{{ route('list-guide-scr') }}" class="btn btn-outline-light rounded-pill px-4 py-2">
                            <i class="bi bi-file-earmark-text me-2"></i> Yêu cầu dịch vụ
                        </a>
                        
                        {{-- Status Toggle --}}
                        <div class="ms-3 pt-1">
                            <form action="{{ route('post-guide-status') }}" method="POST" id="statusForm">
                                @csrf
                                <div class="dropdown">
                                    <button class="btn {{ ($guide->status ?? 'active') == 'active' ? 'btn-success' : 'btn-danger' }} rounded-pill px-4 py-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi {{ ($guide->status ?? 'active') == 'active' ? 'bi-check-circle' : 'bi-dash-circle' }} me-2"></i>
                                        {{ ($guide->status ?? 'active') == 'active' ? 'Đang rảnh (Available)' : 'Đang bận (Busy)' }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="submit" name="status" value="active" class="dropdown-item">
                                                <i class="bi bi-check-circle text-success me-2"></i> Đang rảnh (Available)
                                            </button>
                                        </li>
                                        <li>
                                            <button type="submit" name="status" value="inactive" class="dropdown-item">
                                                <i class="bi bi-dash-circle text-danger me-2"></i> Đang bận (Busy)
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-block">
                    <i class="bi bi-compass text-primary opacity-10" style="font-size: 15rem; position: absolute; right: -2rem; bottom: -4rem;"></i>
                </div>
            </div>
        </div>

        {{-- Statistics / Quick Access --}}
        <div class="col-md-4">
            <div class="card-dark p-4 h-100">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="bi bi-calendar-event fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 text-white">Lịch trình</h5>
                        <small class="text-white-50">Sắp diễn ra</small>
                    </div>
                </div>
                <h2 class="text-white mb-0">{{ $nextTour->tour_name ?? 'Chưa có Tour' }}</h2>
                <small class="{{ isset($nextTour) ? 'text-success' : 'text-white-50' }}">
                    <i class="bi bi-arrow-up"></i> 
                    {{ isset($nextTour->start_date) ? 'Khởi hành: ' . date('d/m/Y', strtotime($nextTour->start_date)) : 'Vui lòng chờ lịch phân công' }}
                </small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-dark p-4 h-100">
                 <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 text-white">Khách hàng</h5>
                        <small class="text-white-50">Đang phụ trách</small>
                    </div>
                </div>
                <h2 class="text-white mb-0">{{ $nextTour->booked_guests ?? 0 }}</h2>
                <small class="text-white-50">Khách trong Tour</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-dark p-4 h-100">
                 <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success">
                        <i class="bi bi-check2-circle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 text-white">Nhiệm vụ</h5>
                        <small class="text-white-50">Trạng thái hoàn thành</small>
                    </div>
                </div>
                <h2 class="text-white mb-0">95%</h2>
                <small class="text-muted">Tuyệt vời!</small>
            </div>
        </div>
    </div>
@endsection
