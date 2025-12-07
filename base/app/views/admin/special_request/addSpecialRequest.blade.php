@extends('layout.dashboard')
@section('title', 'Thêm Yêu cầu đặc biệt')

@section('active-special-request', 'active')
@section('content')
    <h3>Thêm Yêu cầu đặc biệt</h3>

    <form action="{{ route('post-special-request') }}" method="post">
        <div class="mb-3">
            <label>Khách hàng</label>
            <select name="customer_id" class="form-select" required>
                <option value="">-- Chọn Khách hàng --</option>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}">{{ $c->fullname }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nội dung yêu cầu</label>
            <textarea class="form-control" name="request" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Thêm</button>
        <a href="{{ route('list-special-request') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection