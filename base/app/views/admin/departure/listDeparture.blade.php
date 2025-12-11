@extends('layout.dashboard')
@section('title', 'Lịch khởi hành của tour')

@section('active-departure', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-calendar-alt text-primary"></i> Lịch khởi hành</h2>
        <a href="{{ route('add-departure') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Thêm lịch mới
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success mb-4">{{ $_SESSION['success'] }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-secondary small text-uppercase">
                        <th style="width: 50px;">STT</th>
                        <th>Tên Tour</th>
                        <th>Giờ khởi hành</th>
                        <th>Ngày đi / về</th>
                        <th>Điểm đón khách</th>
                        <th>Địa điểm</th>

                        <th class="text-center">Tổng ghế</th>
                        <th class="text-center">Đã đặt</th>
                        <th class="text-center">Còn lại</th>
                        <th class="text-center">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departures as $index => $dp)
                        <tr class="view-departure-row" data-bs-toggle="modal" data-bs-target="#itineraryModal" data-departure-id="{{ $dp->id }}" style="cursor: pointer;">
                            <td class="text-muted">{{ $index+1 }}</td>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $dp->tour_name }}</span>
                            </td>
                            <td class="text-primary fw-bold">
                                {{ !empty($dp->start_time) ? date('H:i', strtotime($dp->start_time)) : '--' }}
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium">
                                        @php
                                            $startDate = $dp->start_date ?? ($dp->booking_start_date ?? null);
                                            $endDate = $dp->end_date ?? ($dp->booking_end_date ?? null);
                                            
                                            $displayStart = $startDate ? date('d/m/Y', strtotime($startDate)) : '--';
                                        @endphp
                                        {{ $displayStart }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $endDate ? date('d/m/Y', strtotime($endDate)) : '--' }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <small class="text-primary fst-italic text-wrap" style="max-width: 150px; display: block;">
                                    {{ !empty($dp->pickup_locations_list) ? $dp->pickup_locations_list : '-' }}
                                </small>
                            </td>
                            <td>
                                <small class="text-muted d-block">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i>{{ $dp->start_location ?? 'unk' }}
                                </small>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-arrow-right me-1"></i>{{ $dp->destination ?? 'unk' }}
                                </small>
                            </td>

                            <td class="text-center">{{ $dp->total_seats }}</td>
                            <td class="text-center">{{ $dp->booked_guests ?? 0 }}</td>
                            <td class="text-center">
                                @php
                                    $booked = $dp->booked_guests ?? 0;
                                    $remaining = $dp->total_seats - $booked;
                                @endphp
                                <span class="{{ $remaining > 0 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                    {{ $remaining }}
                                </span>
                            </td>
                            <td class="text-center">
                                @switch($dp->status)
                                    @case('open') <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill">Đang mở</span> @break
                                    @case('closed') <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill">Đã đóng</span> @break
                                    @case('full') <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill">Đầy chỗ</span> @break
                                    @case('completed') <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill">Hoàn thành</span> @break
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="text-center text-muted py-5">Chưa có lịch khởi hành nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Itinerary Modal -->
    <div class="modal fade" id="itineraryModal" tabindex="-1" aria-labelledby="itineraryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content card-dark border-0">
                <div class="modal-body text-white p-4" id="itineraryModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalBody = document.getElementById('itineraryModalBody');

                document.body.addEventListener('click', function(e) {
                    const row = e.target.closest('.view-departure-row');
                    if (row) {
                        const id = row.getAttribute('data-departure-id');
                        if(!id) return;
                        
                        // Reset & Loader
                        modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

                        fetch('{{ route('ajax-detail-departure') }}/' + id + '?t=' + new Date().getTime())
                            .then(response => response.text())
                            .then(html => {
                                modalBody.innerHTML = html;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                modalBody.innerHTML = '<div class="alert alert-danger text-center">Không thể tải thông tin. Vui lòng thử lại.</div>';
                            });
                    }
                });
            });
        </script>
</div>
@endsection