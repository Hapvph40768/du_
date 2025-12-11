@extends('layout.dashboard')
@section('title', 'Sửa Dịch vụ')

@section('active-service', 'active')
@section('content')
    <h3>Sửa Dịch vụ: {{ $detail->name }}</h3>

    {{-- Hiển thị thông báo lỗi --}}
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

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card shadow-sm p-4">
        <form action="{{ route('edit-service/' . $detail->id) }}" method="post">
            {{-- Tên dịch vụ --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Tên dịch vụ</label>
                <input type="text" class="form-control" name="name" value="{{ $detail->name }}" required>
            </div>

            {{-- Gói dịch vụ --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Gói dịch vụ</label>
                <input type="text" class="form-control" name="package_name" value="{{ $detail->package_name }}">
            </div>

            {{-- Nhà cung cấp --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Nhà cung cấp</label>
                <select name="supplier_id" id="supplierSelect" class="form-select">
                    <option value="" data-type="">-- Không chọn --</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}" data-type="{{ $sup->type }}" {{ $sup->id == $detail->supplier_id ? 'selected' : '' }}>
                            {{ $sup->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Loại dịch vụ --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Loại dịch vụ</label>
                <input type="text" class="form-control bg-light" name="type" value="{{ $detail->type }}" id="serviceTypeInput" readonly>
            </div>

            {{-- Mô tả --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả</label>
                <textarea class="form-control" name="description" rows="4">{{ $detail->description }}</textarea>
            </div>

            <div class="row">
                {{-- Giá --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="{{ $detail->price }}">
                </div>

                {{-- Giá mặc định --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Giá mặc định</label>
                    <input type="number" step="0.01" class="form-control" name="default_price" value="{{ $detail->default_price }}">
                </div>

                {{-- Tiền tệ --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Tiền tệ</label>
                    <input type="text" class="form-control" name="currency" value="{{ $detail->currency }}" maxlength="3">
                </div>
            </div>

            {{-- Tùy chọn --}}
            <div class="form-check form-switch mb-2">
                <input type="checkbox" class="form-check-input" name="is_optional" value="1" {{ $detail->is_optional ? 'checked' : '' }} id="is_optional">
                <label class="form-check-label" for="is_optional">Dịch vụ tùy chọn</label>
            </div>

            {{-- Trạng thái hoạt động --}}
            <div class="form-check form-switch mb-3">
                <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ $detail->is_active ? 'checked' : '' }} id="is_active">
                <label class="form-check-label" for="is_active">Đang hoạt động</label>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary" name="btn-submit"><i class="fas fa-save me-1"></i> Cập nhật</button>
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