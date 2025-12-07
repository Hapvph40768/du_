@extends('layout.dashboard')
@section('title', 'Lịch trình theo ngày')

@section('active-itinerary', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-route"></i> Lịch trình theo ngày</h2>
        <a href="{{ route('add-itinerary') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm lịch trình
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
                    <th>Ngày thứ</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung chi tiết</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($itinerary as $it)
                    <tr>
                        <td>{{ $it->id }}</td>
                        <td class="fw-bold">{{ $it->tour_name }}</td>
                        <td>
                            <span class="badge bg-info text-dark">Ngày {{ $it->day_number }}</span>
                        </td>
                        <td>{{ $it->title }}</td>
                        <td>{{ strlen($it->description) > 80 ? substr($it->description, 0, 80) . '...' : $it->description }}</td>
                        <td>
                            <a href="{{ route('detail-itinerary/' . $it->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit">Sửa</i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-itinerary/' . $it->id) }}')">
                                <i class="fas fa-trash-alt">Xóa</i>
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