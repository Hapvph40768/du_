@extends('layout.dashboard')
@section('title', 'Thêm Dịch vụ')

@section('active-service', 'active')
@section('content')
    <h3>Thêm Dịch vụ Mới</h3>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul>
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    <div class="card shadow-sm p-4">
        <form action="{{ route('post-service') }}" method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Tên dịch vụ</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Gói dịch vụ</label>
                <input type="text" class="form-control" name="package_name">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nhà cung cấp</label>
                <select name="supplier_id" id="supplierSelect" class="form-select">
                    <option value="" data-type="">-- Không chọn --</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}" data-type="{{ $sup->type }}">{{ $sup->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Loại dịch vụ</label>
                <input type="text" class="form-control bg-light" name="type" id="serviceTypeInput" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả</label>
                <textarea class="form-control" name="description"></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá mặc định</label>
                    <input type="number" step="0.01" class="form-control" name="default_price" value="0">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Tiền tệ</label>
                    <input type="text" class="form-control" name="currency" value="VND" maxlength="3">
                </div>
            </div>

            <div class="form-check form-switch mb-2">
                <input type="checkbox" class="form-check-input" name="is_optional" value="1" id="is_optional">
                <label class="form-check-label" for="is_optional">Dịch vụ tùy chọn</label>
            </div>

            <div class="form-check form-switch mb-3">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" checked id="is_active">
                <label class="form-check-label" for="is_active">Đang hoạt động</label>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" name="btn-submit"><i class="fas fa-save me-1"></i> Thêm</button>
            <a href="{{ route('list-service') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Quay lại</a>
        </form>
    </div>

    <script>
        const supplierSelect = document.getElementById('supplierSelect');
        const serviceTypeInput = document.getElementById('serviceTypeInput');

        if (supplierSelect) {
            supplierSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const type = selectedOption.getAttribute('data-type');
                if (type && serviceTypeInput) {
                    serviceTypeInput.value = type;
                }
            });
        }
    </script>
@endsection