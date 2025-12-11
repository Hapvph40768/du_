<div class="departure-detail-wrapper">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold mb-1">Chi tiết Lịch khởi hành #{{ $departure->id }}</h4>
            <p class="text-white-50 small mb-0">Xem thông tin chi tiết và danh sách booking.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('edit-departure/'.$departure->id) }}" class="btn btn-warning fw-bold shadow-sm">
                <i class="fas fa-edit me-1"></i>Sửa
            </a>
            <button type="button" class="btn btn-danger fw-bold shadow-sm" onclick="if(confirm('Bạn có chắc muốn xóa lịch khởi hành này?')) window.location.href='{{ route('delete-departure/'.$departure->id) }}'">
                <i class="fas fa-trash me-1"></i>Xóa
            </button>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card border border-secondary border-opacity-25 bg-white bg-opacity-10 mb-4 rounded-3 shadow-sm">
        <div class="card-body p-4">
            <h6 class="text-info fw-bold mb-4 text-uppercase fs-7">
                <i class="fas fa-info-circle me-2"></i>Thông tin Tour
            </h6>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2 mb-2">
                        <span class="text-white-50">Tên Tour:</span>
                        <span class="fw-bold text-end">{{ $departure->tour_name ?? ($departure->name ?? '---') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2 mb-2">
                        <span class="text-white-50">Thời gian:</span>
                        <span class="fw-medium text-end">
                            @php
                                $sDate = $departure->start_date ?? ($departure->booking_start_date ?? null);
                                $eDate = $departure->end_date ?? ($departure->booking_end_date ?? null);

                                $start = $sDate ? date('d/m/Y', strtotime($sDate)) : '--';
                                $end = $eDate ? date('d/m/Y', strtotime($eDate)) : '--';
                            @endphp
                            <i class="far fa-calendar-alt me-1 text-muted"></i> {{ $start }} 
                            <i class="fas fa-arrow-right mx-1 text-muted small"></i> {{ $end }}
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2 mb-2">
                        <span class="text-white-50">Tổng ghế:</span>
                        <span class="fw-bold text-end">{{ $departure->total_seats }} ghế</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2 mb-2">
                        <span class="text-white-50">Còn trống:</span>
                        <span class="fw-bold text-end {{ ($departure->total_seats - ($departure->seats_booked ?? 0)) > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $departure->total_seats - ($departure->seats_booked ?? 0) }} ghế
                        </span>
                    </div>
                </div>
                <!-- Location Info -->
                <div class="col-12">
                     <div class="d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2 mb-2">
                        <span class="text-white-50">Điểm đón khách:</span>
                        <span class="fw-bold text-end text-warning fst-italic">
                            <i class="fas fa-map-marked-alt me-1"></i>{{ !empty($departure->pickup_locations_list) ? $departure->pickup_locations_list : '---' }}
                        </span>
                    </div>
                     <div class="d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2 mb-2">
                        <span class="text-white-50">Điểm đón:</span>
                        <span class="fw-bold text-end text-danger">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $departure->start_location ?? '---' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom border-secondary border-opacity-10 pb-2 mb-2">
                        <span class="text-white-50">Điểm đến:</span>
                        <span class="fw-bold text-end text-primary">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $departure->destination ?? '---' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Itinerary Card -->
    <div class="card border border-secondary border-opacity-25 bg-white bg-opacity-10 mb-4 rounded-3 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="text-warning fw-bold mb-0 text-uppercase fs-7">
                    <i class="fas fa-list-alt me-2"></i>Lịch trình chi tiết
                </h6>
                <a href="{{ route('add-itinerary') }}?departure_id={{ $departure->id }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i>Thêm lịch trình
                </a>
            </div>

            @if(!empty($itineraries) && count($itineraries) > 0)
                <div class="timeline">
                    @foreach($itineraries as $it)
                        <div class="mb-4 position-relative ps-4 border-start border-secondary border-opacity-25">
                            <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-warning border border-dark" style="width: 12px; height: 12px;"></div>
                            
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="text-white fw-bold mb-1">Ngày {{ $it->day_number }}: {{ $it->title }}</h6>
                                <div>
                                    <a href="{{ route('detail-itinerary/' . $it->id) }}" class="btn btn-sm btn-outline-info me-2" title="Sửa">
                                        <i class="fas fa-edit"></i>sửa 
                                    </a>
                                    <a href="{{ route('delete-itinerary/' . $it->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch trình này?')" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>xóa
                                    </a>
                                </div>
                            </div>
                            
                            <div class="text-white-50 small text-wrap mt-1">
                                {!! nl2br(htmlspecialchars($it->description)) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-white-50 py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486777.png" alt="Empty" style="width: 48px; opacity: 0.5;" class="mb-2">
                    <div class="small">Chưa có lịch trình nào cho tour này.</div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Status Bar (Simple version) -->
    <div class="card border border-secondary border-opacity-25 bg-dark rounded-3">
        <div class="card-body py-3 d-flex justify-content-between align-items-center">
             <div class="d-flex align-items-center">
                 <span class="text-white-50 me-2">Trạng thái:</span>
                 @switch($departure->status)
                    @case('open') <span class="badge bg-success">Đang mở</span> @break
                    @case('closed') <span class="badge bg-secondary">Đã đóng</span> @break
                    @case('full') <span class="badge bg-danger">Đầy chỗ</span> @break
                    @default <span class="badge bg-primary">{{ $departure->status }}</span>
                 @endswitch
             </div>
             <div>
                 <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
             </div>
        </div>
    </div>
</div>
