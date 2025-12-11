@extends('layout.dashboard')
@section('title', 'Lịch trình theo ngày')

@section('active-itinerary', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold"><i class="fas fa-route text-primary"></i> Lịch trình: {{ $departure->name ?? 'Chi tiết' }}</h2>
        <a href="{{ route('add-itinerary') }}" class="btn btn-primary px-4 py-2 rounded-pill fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Thêm lịch trình
        </a>
    </div>

    <div class="card-dark p-3">
        <div class="table-responsive">
            <table class="table-dark-custom align-middle text-center">
                <thead>
                    <tr>
                        <th style="width: 60px;">STT</th>
                        <th>Tour</th>
                        <th style="width: 120px;">Thời gian</th>
                        <th class="text-start">Tiêu đề</th>
                        <th class="text-start">Nội dung chi tiết</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($itineraries as $index => $it)
                    <tr>
                        <td class="text-muted">{{ $index + 1 }}</td>
                        <td class="fw-bold text-white">{{ $it->tour_name }}</td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-3">
                                Ngày {{ $it->day_number }}
                            </span>
                        </td>
                        <td class="text-start fw-bold text-white">{{ $it->title }}</td>
                        <td class="text-start text-muted">
                            {{ strlen($it->description) > 80 ? substr($it->description, 0, 80) . '...' : $it->description }}
                        </td>
                        <td>
                            <a href="{{ route('detail-itinerary/' . $it->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                <i class="fas fa-edit"></i>Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa"
                                onclick="confirmDelete('{{ route('delete-itinerary/' . $it->id) }}')">
                                <i class="fas fa-trash-alt"></i>Xóa
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">Chưa có lịch trình nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
