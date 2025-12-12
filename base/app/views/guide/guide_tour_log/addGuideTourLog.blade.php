@extends('layout.guide.GuideLayout')
@section('title', 'Thêm nhật ký tour')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-primary fw-bold mb-0">
                    <i class="fas fa-book me-2"></i>Thêm nhật ký tour
                </h2>
                <p class="text-muted mb-0">Ghi lại hoạt động cho chuyến đi</p>
            </div>
            <a href="{{ route('list-guide-tour-log') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left me-2"></i> Quay lại
            </a>
        </div>

        @if(isset($_SESSION['errors']) && isset($_GET['msg']))
            <div class="alert alert-danger shadow-sm mb-4">
                <ul class="mb-0">
                    @foreach($_SESSION['errors'] as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('post-guide-tour-log') }}" method="post">
                            {{-- CHỌN CHUYẾN ĐI --}}
                            <div class="mb-4">
                                <label class="fw-bold text-dark mb-2">Chọn chuyến đi <span class="text-danger">*</span></label>
                                <select class="form-select" name="departure_id" required>
                                    <option value="">-- Chọn chuyến đi --</option>
                                    @foreach($departures as $dep)
                                        @php
                                            $sDate = $dep->start_date ?? ($dep->booking_start_date ?? null);
                                            $eDate = $dep->end_date ?? ($dep->booking_end_date ?? null);
                                            $dateStr = ($sDate && $eDate) ? "(".date('d/m/Y', strtotime($sDate)) . " - " . date('d/m/Y', strtotime($eDate)).")" : "";
                                        @endphp
                                        <option value="{{ $dep->id }}">
                                            {{ $dep->tour_name }} {{ $dateStr }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- HÀNH ĐỘNG --}}
                            <div class="mb-4">
                                <label class="fw-bold text-dark mb-2">Hành động <span class="text-danger">*</span></label>
                                <input type="text" name="action" class="form-control" placeholder="Ví dụ: Cập nhật lịch trình, Thay đổi hướng dẫn viên..." required>
                            </div>

                            {{-- NGƯỜI THỰC HIỆN (Optional) --}}
                            <div class="mb-4">
                                <label class="fw-bold text-dark mb-2">Người thực hiện</label>
                                <select class="form-select" name="user_id">
                                    <option value="">-- Mặc định (Tôi thực hiện) --</option>
                                    @foreach($guides as $g)
                                        <option value="{{ $g->id }}">{{ $g->fullname }} ({{ $g->username }})</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- MÔ TẢ --}}
                            <div class="mb-4">
                                <label class="fw-bold text-dark mb-2">Mô tả chi tiết <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Nhập nội dung chi tiết..." required></textarea>
                            </div>

                            <hr class="text-muted opacity-25 my-4">

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> Lưu nhật ký
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection