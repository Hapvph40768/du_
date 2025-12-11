@extends('layout.dashboard')
@section('title', 'Sửa nhật ký tour')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-white fw-bold mb-0">
                    <i class="fas fa-edit me-2 text-primary"></i>Sửa nhật ký tour
                </h2>
                <p class="text-muted mb-0">Cập nhật thông tin nhật ký</p>
            </div>
            <a href="{{ route('list-tour-logs') }}" class="btn btn-outline-secondary rounded-pill px-4" style="border-color: rgba(255,255,255,0.2); color: #fff;">
                <i class="fas fa-arrow-left me-2"></i> Quay lại
            </a>
        </div>

        @if(isset($_SESSION['errors']) && isset($_GET['msg']))
            <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0 border-start border-4 border-danger bg-dark text-white">
                <div class="d-flex">
                    <i class="fas fa-exclamation-circle me-3 fs-4 text-danger mt-1"></i>
                    <div>
                        <strong class="d-block mb-1">Đã xảy ra lỗi:</strong>
                        <ul class="mb-0 ps-3">
                            @foreach($_SESSION['errors'] as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-dark shadow-lg">
                    <div class="card-body p-4">
                        <form action="{{ route('edit-tour-log/' . $detail->id) }}" method="post">
                            
                            {{-- CHỌN CHUYẾN ĐI --}}
                            <div class="mb-4">
                                <label class="fw-bold text-light mb-2">Chọn chuyến đi <span class="text-danger">*</span></label>
                                <select class="form-select bg-dark text-white border-secondary" name="departure_id" required style="border-color: rgba(255,255,255,0.1);">
                                    <option value="">-- Chọn chuyến đi --</option>
                                    @foreach($departures as $dep)
                                        <option value="{{ $dep->id }}" {{ $detail->departure_id == $dep->id ? 'selected' : '' }}>
                                            {{ $dep->tour_name }} ({{ date('d/m/Y', strtotime($dep->start_date)) }} -
                                            {{ date('d/m/Y', strtotime($dep->end_date)) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- HÀNH ĐỘNG --}}
                            <div class="mb-4">
                                <label class="fw-bold text-light mb-2">Hành động <span class="text-danger">*</span></label>
                                <input type="text" name="action" class="form-control bg-dark text-white border-secondary" 
                                    value="{{ $detail->action }}" placeholder="Ví dụ: Cập nhật lịch trình..." required style="border-color: rgba(255,255,255,0.1);">
                            </div>

                            {{-- NGƯỜI THỰC HIỆN (Optional) --}}
                            <div class="mb-4">
                                <label class="fw-bold text-light mb-2">Người thực hiện (Tùy chọn)</label>
                                <select class="form-select bg-dark text-white border-secondary" name="user_id" style="border-color: rgba(255,255,255,0.1);">
                                    <option value="">-- Mặc định (Tôi thực hiện) --</option>
                                    @foreach($guides as $g)
                                        <option value="{{ $g->id }}" {{ $detail->user_id == $g->id ? 'selected' : '' }}>
                                            {{ $g->fullname }} ({{ $g->username }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- MÔ TẢ --}}
                            <div class="mb-4">
                                <label class="fw-bold text-light mb-2">Mô tả chi tiết <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control bg-dark text-white border-secondary" rows="4" 
                                    placeholder="Nhập nội dung chi tiết..." required style="border-color: rgba(255,255,255,0.1);">{{ $detail->message }}</textarea>
                            </div>

                            <hr class="border-secondary opacity-25 my-4">

                            <div class="text-end">
                                <button type="submit" name="btn-submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm hover-shadow-lg transition-all">
                                    <i class="fas fa-save me-2"></i> Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-select.bg-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }
        .form-control:focus, .form-select:focus {
            background-color: #1e293b;
            color: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
        .hover-shadow-lg:hover { box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; transform: translateY(-2px); }
        .transition-all { transition: all 0.3s ease; }
    </style>

@endsection