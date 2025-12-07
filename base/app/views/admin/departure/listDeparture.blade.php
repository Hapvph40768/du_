@extends('layout.dashboard')
@section('title', 'Lịch khởi hành của tour')

@section('active-departure', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-calendar-alt"></i> Lịch khởi hành</h2>
        <a href="{{ route('add-departure') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm lịch khởi hành
        </a>
    </div>

    {{-- Thông báo --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">{{ $_SESSION['success'] }}</div>
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Tên Tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Ngày kết thúc</th>
                    <th>Giá</th>
                    <th>Tổng số ghế</th>
                    <th>Đã đặt</th>
                    <th>Còn lại</th>
                    <th>Chi phí Guide</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departures as $index => $dp)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td class="fw-bold">{{ $dp->tour_name }}</td>
                        <td>{{ date('d/m/Y', strtotime($dp->start_date)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($dp->end_date)) }}</td>
                        <td class="text-success fw-bold">{{ number_format($dp->price,0,',','.') }} đ</td>
                        <td>{{ $dp->total_seats }}</td>
                        <td>{{ $dp->total_seats - $dp->remaining_seats }}</td>
                        <td class="{{ $dp->remaining_seats>0?'text-success fw-bold':'text-danger fw-bold' }}">
                            {{ $dp->remaining_seats }}
                        </td>
                        <td>{{ $dp->guide_price ? number_format($dp->guide_price,0,',','.') . ' đ' : 'Không có' }}</td>
                        <td>
                            @switch($dp->status)
                                @case('open') <span class="badge bg-success">Đang mở</span> @break
                                @case('closed') <span class="badge bg-secondary">Đã đóng</span> @break
                                @case('full') <span class="badge bg-danger">Đầy chỗ</span> @break
                                @case('completed') <span class="badge bg-primary">Hoàn thành</span> @break
                            @endswitch
                        </td>
                        <td>
                            <a href="{{ route('list-itinerary/'.$dp->id) }}" class="btn btn-sm btn-info me-1">
                                <i class="fas fa-list-alt"></i> Xem lịch trình
                            </a>
                            <a href="{{ route('detail-departure/'.$dp->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="confirmDelete('{{ route('delete-departure/'.$dp->id) }}')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="11" class="text-muted">Chưa có lịch khởi hành nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
        <!-- Itinerary Modal -->
        <div class="modal fade" id="itineraryModal" tabindex="-1" aria-labelledby="itineraryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="itineraryModalLabel">Chi tiết lịch trình</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="itineraryModalBody">
                        <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
                (function(){
                        function qs(selector, parent) { return (parent||document).querySelector(selector); }
                        function qsa(selector, parent) { return Array.from((parent||document).querySelectorAll(selector)); }

                        const modalEl = qs('#itineraryModal');
                        const modalBody = qs('#itineraryModalBody');
                        const bsModal = modalEl ? new bootstrap.Modal(modalEl) : null;

                        qsa('.btn-view-itinerary').forEach(btn => {
                                btn.addEventListener('click', function(){
                                        const id = this.getAttribute('data-departure-id');
                                        if(!id) return;
                                        // show modal with loader
                                        modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
                                        bsModal.show();

                                        fetch('{{ route('list-itinerary') }}/' + id + '?ajax=1')
                                                .then(r => r.text())
                                                .then(html => {
                                                        modalBody.innerHTML = html;
                                                })
                                                .catch(err => {
                                                        modalBody.innerHTML = '<div class="alert alert-danger">Không tải được dữ liệu. Vui lòng thử lại.</div>';
                                                        console.error(err);
                                                });
                                });
                        });
                })();
        </script>
</div>
@endsection