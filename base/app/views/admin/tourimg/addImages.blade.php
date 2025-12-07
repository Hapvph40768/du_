@extends('layout.dashboard')
@section('title', 'Thêm ảnh tour')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary"><i class="fas fa-image"></i> Thêm ảnh tour</h2>
            <a href="{{ route('list-tour-images') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        @if(isset($_SESSION['errors']) && isset($_GET['msg']))
            <div class="alert alert-danger">
                @foreach($_SESSION['errors'] as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('post-tour-image') }}" method="post" enctype="multipart/form-data"
            class="bg-light p-4 rounded">
            <div class="mb-3">
                <label class="form-label fw-bold">Chọn tour</label>
                <select class="form-select" name="tour_id" required>
                    <option value="">-- Chọn tour --</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Chọn ảnh</label>
                <input type="file" class="form-control" name="image_path" accept="image/*" required>
                <small class="text-muted">Định dạng: JPG, PNG, GIF</small>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_thumbnail" id="is_thumbnail" value="1">
                    <label class="form-check-label" for="is_thumbnail">
                        Đặt làm ảnh chính (thumbnail)
                    </label>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Thêm
                </button>
            </div>
        </form>
    </div>

@endsection