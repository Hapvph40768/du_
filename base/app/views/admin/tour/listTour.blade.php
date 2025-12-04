@extends('layout.dashboard')

@section('title', 'Danh sách Tour')
@section('active-tours', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary"><i class="fas fa-list"></i> Danh sách Tour</h1>
        <a href="{{ route('add-tour') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm tour
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Tên tour</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Giá tour</th>
                    <th>Số ngày</th>
                    <th>Khởi hành</th>
                    <th>Điểm đến</th>
                    <th>Ảnh</th>
                    <th>Loại</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tours as $st)
                    <tr>
                        <td>{{ $st->id }}</td>
                        <td class="fw-bold">{{ $st->name }}</td>
                        <td><span class="text-muted">{{ $st->slug }}</span></td>
                        <td>{{ strlen($st->description) > 50 ? substr($st->description, 0, 50) . '...' : $st->description }}</td>
                        <td class="text-success">{{ number_format($st->price, 0, ',', '.') }} đ</td>
                        <td>{{ $st->days }}</td>
                        <td>{{ $st->start_location }}</td>
                        <td>{{ $st->destination }}</td>
                        <td>
                            @if($st->thumbnail)
                                <img src="{{ $st->thumbnail }}" alt="thumbnail" class="img-thumbnail rounded" width="80">
                            @else
                                <span class="badge bg-light text-dark">Không có</span>
                            @endif
                        </td>
                        <td class="text-capitalize">{{ $st->category }}</td>
                        <td>
                            <span class="badge {{ $st->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $st->status === 'active' ? 'Còn mở' : 'Đã đóng' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('detail-tour/' . $st->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('delete-tour/' . $st->id) }}')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-muted">Chưa có tour nào được thêm</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection