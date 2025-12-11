@extends('layout.dashboard')
@section('title', 'Sửa ảnh tour')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary"><i class="fas fa-edit"></i> Sửa ảnh tour</h2>
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

        <form action="{{ route('edit-tour-image/' . $detail->id) }}" method="post" enctype="multipart/form-data"
            class="bg-light p-4 rounded">
            <div class="mb-3">
                <label class="form-label fw-bold">Chọn tour</label>
                <select class="form-select" name="tour_id" required>
                    <option value="">-- Chọn tour --</option>
                    @foreach($tours as $tour)
                        <option value="{{ $tour->id }}" {{ $detail->tour_id == $tour->id ? 'selected' : '' }}>{{ $tour->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh hiện tại</label>
                <div class="mb-2">
                    @if($detail->image_url)
                        <img src="{{ str_replace('/public', 'public', $detail->image_url) }}" alt="{{ $detail->alt_text }}" class="img-thumbnail"
                            style="max-width: 200px; height: auto;"
                            onerror="this.onerror=null;this.src='public/img/placeholder.png';">
                    @else
                        <span class="text-muted">Chưa có ảnh</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Thay ảnh (tùy chọn)</label>
                <input type="file" class="form-control" name="image_path" accept="image/*">
                <input type="hidden" name="old_image" value="{{ $detail->image_url }}">
                <small class="text-muted">Nếu không chọn ảnh mới, sẽ giữ ảnh cũ</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Văn bản thay thế (Alt Text)</label>
                <input type="text" class="form-control" name="alt_text" value="{{ $detail->alt_text }}" placeholder="Mô tả ảnh cho SEO">
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_thumbnail" id="is_thumbnail" {{ $detail->is_thumbnail == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_thumbnail">
                        Đặt làm ảnh chính
                    </label>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" name="btn-submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>

@endsection