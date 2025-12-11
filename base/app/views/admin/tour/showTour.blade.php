@extends('layout.dashboard')
@section('title', 'Chi tiết Tour')
@section('active-tours', 'active')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-white fw-bold mb-0">
                <i class="fas fa-info-circle me-2 text-primary"></i>Chi tiết Tour
            </h2>
            <p class="text-muted mb-0">Thông tin chi tiết về tour du lịch</p>
        </div>
        <a href="{{ route('list-tours') }}" class="btn btn-outline-secondary rounded-pill px-4" style="border-color: rgba(255,255,255,0.2); color: #fff;">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="row g-4">
        {{-- Left Column: Thumbnail, Price, Actions --}}
        <div class="col-lg-4">
            <div class="card-dark h-100 overflow-hidden shadow-lg">
                <div class="card-body p-4 text-center">
                    {{-- Thumbnail --}}
                    <div class="mb-4 position-relative d-inline-block w-100">
                        @php
                            // Use BASE_URL for absolute path reliability
                            $baseUrl = defined('BASE_URL') ? BASE_URL : '/du_an1/base/';
                            $thumbnail = $detail->thumbnail ? $baseUrl . ltrim($detail->thumbnail, '/') : $baseUrl . 'public/img/placeholder.png';
                        @endphp

                        @if($detail->thumbnail)
                            <img src="{{ $thumbnail }}" 
                                 class="img-fluid rounded-3 shadow-sm border border-secondary" 
                                 alt="{{ $detail->name }}" 
                                 style="max-height: 280px; object-fit: cover; width: 100%; border-color: rgba(255,255,255,0.1) !important;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-dark rounded-3" style="height: 200px; border: 1px dashed rgba(255,255,255,0.2);">
                                <span class="text-muted">No Thumbnail</span>
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="card-title fw-bold text-white mb-2">{{ $detail->name }}</h4>
                    <h3 class="text-danger fw-bold mb-3">{{ number_format($detail->price, 0, ',', '.') }} đ</h3>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge rounded-pill {{ $detail->status == 'active' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 text-white border border-light border-opacity-25">
                            <i class="fas fa-circle me-1 small"></i>
                            {{ $detail->status == 'active' ? 'Đang hoạt động' : 'Đã đóng' }}
                        </span>
                        <span class="badge rounded-pill bg-info text-dark px-3 py-2 border border-info border-opacity-25">{{ $detail->category }}</span>
                    </div>

                    <hr class="text-secondary opacity-25">
                    
                    <div class="d-grid gap-2">
                         <a href="{{ route('detail-tour/' . $detail->id) }}" class="btn btn-warning rounded-pill py-2 text-dark fw-bold">
                            <i class="fas fa-edit me-2"></i>Sửa thông tin
                        </a>
                        <button type="button" class="btn btn-outline-danger rounded-pill py-2" onclick="confirmDelete('{{ route('delete-tour/' . $detail->id) }}')">
                            <i class="fas fa-trash-alt me-2"></i>Xóa Tour
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Details & Gallery --}}
        <div class="col-lg-8">
            <div class="card-dark h-100 shadow-lg">
                <div class="card-header border-bottom border-secondary border-opacity-25 py-3 px-4 bg-transparent">
                    <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-list-alt me-2"></i>Thông tin chi tiết</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- Info Grid --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Slug (URL)</label>
                                <span class="text-white">{{ $detail->slug }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Thời gian</label>
                                <span class="text-white fw-bold">{{ $detail->days }} ngày</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Điểm khởi hành</label>
                                <span class="text-white">{{ $detail->start_location }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Điểm đến</label>
                                <span class="text-white">{{ $detail->destination }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Ngày tạo</label>
                                <span class="text-white">{{ date('d/m/Y H:i', strtotime($detail->created_at)) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Cập nhật lần cuối</label>
                                <span class="text-white">{{ date('d/m/Y H:i', strtotime($detail->updated_at)) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="small text-muted fw-bold text-uppercase d-block mb-2">Mô tả</label>
                        <div class="p-3 rounded-3 border border-secondary border-opacity-25 text-white" style="background: rgba(255,255,255,0.03);">
                            {!! nl2br(e($detail->description)) !!}
                        </div>
                    </div>

                    <hr class="text-secondary opacity-25">

                    {{-- Gallery --}}
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary mb-0"><i class="fas fa-images me-2"></i>Thư viện ảnh</h5>
                            <a href="{{ route('list-tour-images') }}" class="btn btn-sm btn-link text-info text-decoration-none">Quản lý ảnh <i class="fas fa-arrow-right small"></i></a>
                        </div>
                        
                        @if(isset($images) && count($images) > 0)
                            <div class="row g-3">
                                @foreach($images as $img)
                                    @php
                                        // Use BASE_URL for absolute path reliability
                                        $imgUrl = $baseUrl . ltrim($img->image_url, '/');
                                    @endphp
                                    <div class="col-md-3 col-sm-4 col-6">
                                        <div class="position-relative group-hover-scale rounded-3 overflow-hidden shadow-sm border border-secondary border-opacity-25">
                                            <a href="{{ $imgUrl }}" target="_blank">
                                                <img src="{{ $imgUrl }}" 
                                                     class="w-100 d-block transition-transform" 
                                                     alt="{{ $img->alt_text }}"
                                                     style="height: 120px; object-fit: cover;">
                                            </a>
                                            @if($img->is_thumbnail)
                                                <div class="position-absolute top-0 start-0 w-100 p-1 bg-gradient-dark-transparent">
                                                     <span class="badge bg-success shadow-sm">Ảnh chính</span>
                                                </div>
                                            @endif
                                            @if($img->alt_text)
                                                <div class="position-absolute bottom-0 start-0 w-100 bg-black bg-opacity-75 text-white p-1 small text-truncate text-center">
                                                    {{ $img->alt_text }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 rounded-3 text-muted" style="background: rgba(255,255,255,0.03); border: 1px dashed rgba(255,255,255,0.1);">
                                <i class="fas fa-images fa-3x mb-2 opacity-50"></i>
                                <p class="mb-0">Chưa có ảnh nào cho tour này.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-transform {
        transition: transform 0.3s ease;
    }
    .group-hover-scale:hover .transition-transform {
        transform: scale(1.05);
    }
    .bg-gradient-dark-transparent {
        background: linear-gradient(180deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%);
    }
</style>
@endsection
