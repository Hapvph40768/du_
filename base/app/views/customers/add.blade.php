@extends('admin.dashboard')

@section('title', 'Thêm khách hàng')
@section('active-customers', 'active')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Thêm khách hàng</h4>
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

        <form action="{{ BASE_URL }}customers/store" method="POST">

            <div class="mb-3">
                <label>Họ và tên *</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label>Điện thoại:</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="mb-3">
                <label>Địa chỉ:</label>
                <input type="text" name="address" class="form-control">
            </div>

            <div class="mb-3">
                <label>Ghi chú:</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Lưu</button>
            <a href="{{ BASE_URL }}customers" class="btn btn-secondary">Quay lại</a>

        </form>
    </div>
</div>

@endsection
