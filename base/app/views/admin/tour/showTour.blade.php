@extends('layout.dashboard')
@section('title', 'Chi tiết Tour')
@section('active-tours', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-info-circle"></i> Chi tiết Tour: {{ $detail->name }}</h2>
        <a href="{{ route('list-tours') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        {{-- Cột trái: Ảnh và thông tin cơ bản --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    @if($detail->thumbnail)
                        <img src="{{ $detail->thumbnail }}" class="img-fluid rounded mb-3" alt="{{ $detail->name }}" style="max-height: 300px; object-fit: cover;">
                    @else
                        <img src="/public/img/placeholder.png" class="img-fluid rounded mb-3" alt="no-thumbnail">
                    @endif
                    
                    <h4 class="card-title text-primary mb-3">{{ $detail->name }}</h4>
                    <h3 class="text-success fw-bold">{{ number_format($detail->price, 0, ',', '.') }} đ</h3>
                    <div class="mb-3">
                        <span class="badge {{ $detail->status == 'active' ? 'bg-success' : 'bg-secondary' }} fs-6">
                            {{ $detail->status == 'active' ? 'Đang hoạt động' : 'Đã đóng' }}
                        </span>
                        <span class="badge bg-info text-dark fs-6 ms-2">{{ $detail->category }}</span>
                    </div>

                    <hr>
                    
                    <div class="d-grid gap-2">
                         <a href="{{ route('detail-tour/' . $detail->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Sửa thông tin Tour
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('delete-tour/' . $detail->id) }}')">
                            <i class="fas fa-trash-alt"></i> Xóa Tour
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cột phải: Thông tin chi tiết --}}
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list-alt"></i> Thông tin chi tiết</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Slug (URL):</div>
                        <div class="col-sm-9 text-muted">{{ $detail->slug }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Thời gian:</div>
                        <div class="col-sm-9">{{ $detail->days }} ngày</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Điểm khởi hành:</div>
                        <div class="col-sm-9">{{ $detail->start_location }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Điểm đến:</div>
                        <div class="col-sm-9">{{ $detail->destination }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Ngày tạo:</div>
                        <div class="col-sm-9">{{ $detail->created_at }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Cập nhật lần cuối:</div>
                        <div class="col-sm-9">{{ $detail->updated_at }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <h5 class="fw-bold mb-3">Mô tả:</h5>
                        <div class="bg-light p-3 rounded border">
                            {!! nl2br(e($detail->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
