<div class="itinerary-partial">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Lịch trình cho: {{ $departure->name ?? 'Chưa đặt tên' }}</h5>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
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