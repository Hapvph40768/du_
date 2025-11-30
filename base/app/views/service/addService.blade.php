@extends('admin.dashboard')
@section('title', 'Thêm dịch vụ')

@section('active-service', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{$_SESSION['success']}}</span>
    @endif

    <a href="{{route('list-service')}}"><button type="button" class="btn btn-warning">Quay lại</button></a>

    <form action="{{route('post-service')}}" method="post">
        <div class="mb-3">
            <label for="tour_id" class="form-label">Thuộc Tour</label>
            <select name="tour_id" id="tour_id" class="form-control">
                <option value="">-- chọn tour (tuỳ chọn) --</option>
                @foreach($tours as $t)
                    <option value="{{ $t->id }}">{{ $t->title ?? $t->name ?? 'Untitled' }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="package_name" class="form-label">Tên gói/dịch vụ</label>
            <input type="text" class="form-control" name="package_name" id="package_name">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01">
        </div>
        <div class="mb-3">
            <label for="currency" class="form-label">Currency</label>
            <input type="text" class="form-control" name="currency" id="currency" value="VND">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_optional" name="is_optional">
            <label class="form-check-label" for="is_optional">Tuỳ chọn</label>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>
    </form>
@endsection
