@extends('layout.dashboard')
@section('title', 'Sửa Yêu cầu đặc biệt')

@section('active-special-request', 'active')
@section('content')
    <h3>Sửa Yêu cầu #{{ $detail->id }}</h3>

    <form action="{{ route('edit-special-request/' . $detail->id) }}" method="post">
        <div class="mb-3">
            <label>Khách hàng</label>
            <select name="customer_id" class="form-select" required>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ $c->id == $detail->customer_id ? 'selected' : '' }}>
                        {{ $c->fullname }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nội dung yêu cầu</label>
            <textarea class="form-control" name="request" rows="4" required>{{ $detail->request }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật</button>
        <a href="{{ route('list-special-request') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection