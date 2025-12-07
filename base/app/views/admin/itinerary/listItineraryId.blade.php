@extends('layout.dashboard')
@section('title', 'Lịch trình theo ngày')

@section('active-itinerary', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-route"></i> Lịch trình của ngày khởi hành: {{ $departure->name ?? 'Chưa đặt tên' }}</h2>
        <a href="{{ route('add-itinerary') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm lịch trình
        </a>
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Tour</th>
                    <th>Ngày thứ</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung chi tiết</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itineraries as $index => $it)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-bold">{{ $it->tour_name }}</td>
                    <td>
                        <span class="badge bg-info text-dark">Ngày {{ $it->day_number }}</span>
                    </td>
                    <td>{{ $it->title }}</td>
                    <td>{{ strlen($it->description) > 80 ? substr($it->description, 0, 80) . '...' : $it->description }}</td>
                    <td>
                        <a href="{{ route('detail-itinerary/' . $it->id) }}" class="btn btn-sm btn-warning me-1">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="confirmDelete('{{ route('delete-itinerary/' . $it->id) }}')">
                            <i class="fas fa-trash-alt"></i> Xóa
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Chưa có lịch trình nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
