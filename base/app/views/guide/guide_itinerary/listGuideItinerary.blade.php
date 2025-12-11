@extends('layout.guide.GuideLayout')
@section('title', 'Danh sách Lịch trình')

@section('active-guide-itinerary', 'active')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách tất cả Lịch trình</h1>
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
                    <th>Departure</th>
                    <th>Ngày</th>
                    <th>Hoạt động</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itinerary as $i)
                    <tr>
                        <td class="ps-4">{{ $i->id }}</td>
                        <td><span class="fw-bold text-white">#{{ $i->departure_id }}</span></td>
                        <td>Ngày {{ $i->day_number }}</td>
                        <td>{{ mb_substr($i->description, 0, 100) }}...</td>
                        <td class="text-white-50">{{ $i->note ?? '---' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Chưa có lịch trình nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection