@extends('layout.client.ClientLayout')

@section('title', 'Cập nhật thông tin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Hoàn tất hồ sơ</h2>
                        <p class="text-muted">Vui lòng cập nhật thông tin để tiếp tục đặt tour.</p>
                    </div>

                    @if(isset($errors) && is_array($errors))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile-setup') }}" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="fullname" placeholder="Nhập họ tên của bạn" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Ngày sinh</label>
                                <input type="date" class="form-control" name="dob">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Giới tính</label>
                                <select class="form-select" name="gender">
                                    <option value="">-- Chọn --</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Quốc tịch</label>
                            <input type="text" class="form-control" name="nationality" value="Việt Nam">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea class="form-control" name="address" rows="2" placeholder="Địa chỉ liên hệ"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                                Cập nhật và Tiếp tục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
