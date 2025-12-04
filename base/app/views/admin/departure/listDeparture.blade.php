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

    {{-- Thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>STT</th>
                    <th>Tour</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Giá</th>
                    <th>Ghế trống</th>
                    <th>Chi phí Guide</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departures as $dp)
                    <tr>
                        <td>{{ $dp->id }}</td>
                        <td class="fw-bold">{{ $dp->tour_name }}</td>
                        <td>{{ date('d/m/Y', strtotime($dp->start_date)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($dp->end_date)) }}</td>
                        <td class="text-success">
                            @if($dp->price)
                                {{ number_format($dp->price, 0, ',', '.') }} đ
                            @else
                                {{ number_format($dp->tour_price ?? 0, 0, ',', '.') }} đ
                            @endif
                        </td>
                        <td>{{ $dp->available_seats }}</td>
                        <td>
                            @if($dp->guide_price)
                                {{ number_format($dp->guide_price, 0, ',', '.') }} đ
                            @else
                                <span class="text-muted">Không có</span>
                            @endif
                        </td>
                        <td>
                            @switch($dp->status)
                                @case('open')
                                    <span class="badge bg-success">Đang mở</span>
                                    @break
                                @case('closed')
                                    <span class="badge bg-secondary">Đã đóng</span>
                                    @break
                                @case('full')
                                    <span class="badge bg-danger">Đầy chỗ</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <a href="{{ route('detail-departure/' . $dp->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit">Sửa</i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-departure/' . $dp->id) }}')">
                                <i class="fas fa-trash-alt">Xóa</i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Chưa có lịch khởi hành nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection