@extends('admin.dashboard')

@section('title', 'Sửa khách hàng')
@section('active-customers', 'active')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Sửa khách hàng</h4>
    </div>

    <div class="card-body">

        @if(isset($_SESSION['errors']))
            <div class="alert alert-danger">
                @foreach($_SESSION['errors'] as $e)
                    <div>{{ $e }}</div>
                @endforeach
                @php unset($_SESSION['errors']); @endphp
            </div>
        @endif

        <form action="{{ BASE_URL }}customers/update/{{ $customer->id }}" method="POST">

            <div class="mb-3">
                <label>Họ và tên *</label>
                <input type="text" name="full_name" value="{{ $customer->full_name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" value="{{ $customer->email }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Điện thoại:</label>
                <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Địa chỉ:</label>
                <input type="text" name="address" value="{{ $customer->address }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Ghi chú:</label>
                <textarea name="notes" class="form-control">{{ $customer->notes }}</textarea>
            </div>

            <button class="btn btn-success">Cập nhật</button>
            <a href="{{ BASE_URL }}customers" class="btn btn-secondary">Quay lại</a>

        </form>
    </div>
</div>

@endsection
