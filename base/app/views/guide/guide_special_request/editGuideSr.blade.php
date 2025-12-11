@extends('layout.guide.GuideLayout')
@section('title', 'Sửa yêu cầu đặc biệt')

@section('active-guide-sr', 'active')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="bi bi-pencil-square"></i> Sửa yêu cầu #{{ $detail->id }}
        </h1>
        <a href="{{ route('list-guide-sr') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif
    
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('edit-guide-sr/' . $detail->id) }}" method="POST">
                
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Khách hàng <span class="text-danger">*</span></label>
                    <select name="customer_id" id="customer_id" class="form-select" required>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ $detail->customer_id == $c->id ? 'selected' : '' }}>
                                {{ $c->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="request" class="form-label">Nội dung yêu cầu <span class="text-danger">*</span></label>
                    <textarea name="request" id="request" class="form-control" rows="5" required>{{ $detail->request }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" name="btn-submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i> Cập nhật
                    </button>
                    <a href="{{ route('list-guide-sr') }}" class="btn btn-secondary px-3">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection