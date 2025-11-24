@extends('layout.main')
@section('content-toursupplier')

<h3>Sửa Thông Tin Gán Nhà Cung Cấp</h3>

@if(isset($_SESSION['errors']) && isset($_GET['msg']))
    <div style="color:red;border:1px solid red;padding:10px;margin-bottom:15px;">
        <ul>
            @foreach($_SESSION['errors'] as $e)
                <li>{{$e}}</li>
            @endforeach
        </ul>
    </div>
    @php unset($_SESSION['errors']) @endphp
@endif

<form action="{{route('edit-tour-supplier/' . $detail->id)}}" method="post">

    <div class="mb-3">
        <label class="form-label">Tour</label>
        <input type="text" class="form-control" value="Tour ID: {{$detail->tour_id}}" disabled>
    </div>

    <div class="mb-3">
        <label class="form-label">Nhà Cung Cấp</label>
        <input type="text" class="form-control" value="{{$detail->supplier_name}} ({{$detail->supplier_type}})" disabled>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Vai trò</label>
        <input type="text" id="role" name="role" class="form-control" value="{{$detail->role}}" placeholder="VD: Hotel, Xe bus, Nhà hàng...">
    </div>

    <button class="btn btn-primary">Cập nhật</button>
    <a href="{{route('list-tour-supplier')}}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection
