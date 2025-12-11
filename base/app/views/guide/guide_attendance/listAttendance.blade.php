@extends('layout.guide.GuideLayout')
@section('title', 'Danh sách Attendance')

@section('active-guide-attendance', 'active')
@section('content')
    <h1>Danh sách điểm danh</h1>

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
                    <th>Khách hàng</th>
                    <th>Thành viên</th>
                    <th>Trạng thái</th>
                    <th>Check-in</th>
                    <th>Ghi chú</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $a)
                    <tr>
                        <td class="ps-4">
                            <span class="text-secondary">#{{ $a->booking_customer_id }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-white">{{ $a->tour_name }}</span>
                                <small class="text-muted" style="font-size: 0.8rem;">
                                    @php
                                        $startDate = $a->start_date ?? $a->booking_start_date;
                                        $endDate = $a->end_date ?? $a->booking_end_date;
                                    @endphp
                                    {{ $startDate ? date('d/m', strtotime($startDate)) : '--' }} - 
                                    {{ $endDate ? date('d/m', strtotime($endDate)) : '--' }}
                                </small>
                            </div>
                        </td>
                        <td class="text-info">{{ $a->customer_name }}</td>
                        <td>{{ $a->booking_customer_name ?? '---' }}</td>
                        <td>
                            @if($a->status === 'present')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">Có mặt</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3">Vắng</span>
                            @endif
                        </td>
                        <td class="text-white-50">{{ $a->checkin_time ? date('H:i d/m', strtotime($a->checkin_time)) : '---' }}</td>
                        <td class="text-white-50">{{ $a->note }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('detail-guide-attendance/' . $a->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil me-1"></i> Sửa
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection