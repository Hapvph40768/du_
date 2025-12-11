@extends('layout.guide.GuideLayout')
@section('title', 'Chi tiết Lịch trình')

@section('active-guide-departure', 'active')
@section('content')
    <div class="mb-4">
        <a href="{{ route('list-guide-departure') }}" class="text-decoration-none text-secondary">
            <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách khởi hành
        </a>
        <h1 class="mt-2">Lịch trình chi tiết - Khởi hành #{{ $departure->id ?? '' }}</h1>
    </div>

    <div class="card-dark p-0">
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th class="ps-4">Ngày</th>
                    <th>Hoạt động</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itineraries as $i)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">Ngày {{ $i->day_number }}</td>
                        <td>{{ $i->description }}</td>
                        <td class="text-white-50">{{ $i->note ?? '---' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">Chưa có lịch trình chi tiết cho chuyến đi này</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
