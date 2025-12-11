<div class="itinerary-partial">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Lịch trình: {{ $departure->tour_name ?? ($departure->name ?? 'Chưa đặt tên') }} 
            <small class="text-muted fs-6">({{ $departure->start_date }})</small>
        </h5>
        <div class="d-flex gap-2">
            <a href="{{ route('edit-departure/'.$departure->id) }}" class="btn btn-sm btn-warning fw-bold">
                <i class="fas fa-edit me-1"></i>Sửa Lịch
            </a>
            <button type="button" class="btn btn-sm btn-danger fw-bold" onclick="if(confirm('Bạn có chắc muốn xóa lịch khởi hành này?')) window.location.href='{{ route('delete-departure/'.$departure->id) }}'">
                <i class="fas fa-trash me-1"></i>Xóa
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày thứ</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itineraries as $index => $it)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><span class="badge bg-info text-dark">Ngày {{ $it->day_number }}</span></td>
                    <td>{{ $it->title }}</td>
                    <td>{{ $it->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Chưa có lịch trình cho lịch khởi hành này</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>