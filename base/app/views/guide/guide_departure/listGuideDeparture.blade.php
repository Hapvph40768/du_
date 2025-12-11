@extends('layout.guide.GuideLayout')
@section('title', 'Danh sách Lịch khởi hành')

@section('active-guide-departure', 'active')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách Lịch khởi hành</h1>
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
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <div class="card-dark p-0">
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Ngày kết thúc</th>
                    <th>Số ghế</th>
                    <th>Ghi chú</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departures as $d)
                    <tr>
                        <td class="ps-4">{{ $d->id }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-white">#{{ $d->tour_id }} - {{ $d->tour_name ?? '---' }}</span>
                            </div>
                        </td>
                        <td class="text-success">
                            @php
                                $startDate = $d->start_date ?? $d->booking_start_date;
                            @endphp
                            {{ $startDate ? date('d/m/Y', strtotime($startDate)) : '---' }}
                        </td>
                        <td class="text-danger">
                            @php
                                $endDate = $d->end_date ?? $d->booking_end_date;
                            @endphp
                            {{ $endDate ? date('d/m/Y', strtotime($endDate)) : '---' }}
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3">
                                {{ $d->booked_guests ?? 0 }} khách
                            </span>
                        </td>
                        <td class="text-white-50">{{ $d->note ?? '---' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('detail-guide-itinerary-departure/' . $d->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-map me-1"></i> Xem lịch trình
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Chưa có lịch khởi hành nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection