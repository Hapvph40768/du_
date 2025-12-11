@extends('layout.guide.GuideLayout')
@section('title', 'Danh sách Hướng dẫn viên')

@section('active-guide-tour', 'active')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách Tour được phân công</h1>
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
                    <th>Tên Tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Ngày kết thúc</th>
                    <th>Vai trò</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tours as $t)
                    <tr>
                        <td class="ps-4">#{{ $t->id }}</td>
                        <td>
                            <span class="fw-bold text-warning">{{ $t->tour_name }}</span>
                        </td>
                        <td class="text-success">
                            @php $start = $t->start_date ?? $t->booking_start_date; @endphp
                            {{ $start ? date('d/m/Y', strtotime($start)) : '---' }}
                        </td>
                        <td class="text-danger">
                            @php $end = $t->end_date ?? $t->booking_end_date; @endphp
                            {{ $end ? date('d/m/Y', strtotime($end)) : '---' }}
                        </td>
                        <td>
                            @if($t->role == 'main')
                                <span class="badge bg-success">Hướng dẫn chính</span>
                            @else
                                <span class="badge bg-secondary">Phụ tá</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Bạn chưa được phân công tour nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection