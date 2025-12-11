@extends('layout.dashboard')
@section('title', 'Sửa khách hàng')

@section('active-customer', 'active')
@section('content')
    <div class="page-header mb-4">
        <h1 class="text-white mb-1">Cập nhật thông tin khách hàng</h1>
        <p class="text-white-50 mb-0">Chỉnh sửa thông tin chi tiết của khách hàng.</p>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card-dark p-4">
                <form action="{{ route('edit-customer/' . $detail->id) }}" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" name="fullname" class="form-control" value="{{ $detail->fullname }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ $detail->phone }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white-50">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $detail->email }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Quốc tịch</label>
                            <input type="text" name="nationality" class="form-control" value="{{ $detail->nationality }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Ngày sinh</label>
                            <input type="date" name="dob" class="form-control" value="{{ $detail->dob }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Giới tính</label>
                            <select name="gender" class="form-select">
                                <option value="male" {{ $detail->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ $detail->gender == 'female' ? 'selected' : '' }}>Nữ</option>
                                <option value="other" {{ $detail->gender == 'other' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Địa chỉ</label>
                            <input type="text" name="address" class="form-control" value="{{ $detail->address }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white-50">Ghi chú</label>
                        <textarea name="note" class="form-control" rows="3">{{ $detail->note }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('list-customer') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        <button type="submit" name="btn-submit" class="btn btn-primary px-4">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection