@extends('layout.main')
@section('content-toursupplier')

<h3>Gán Nhà Cung Cấp Cho Tour</h3>

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

<form action="{{route('post-tour-supplier')}}" method="post">

    <div class="mb-3">
        <label for="tour_id" class="form-label">Chọn Tour</label>
        <select name="tour_id" id="tour_id" class="form-control">
            <option value="">-- Chọn Tour --</option>
            @foreach($tours as $t)
                <option value="{{$t->id}}">{{$t->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="supplier_id" class="form-label">Chọn Nhà Cung Cấp</label>
        <select name="supplier_id" id="supplier_id" class="form-control">
            <option value="">-- Chọn Nhà Cung Cấp --</option>
            @foreach($suppliers as $s)
                <option value="{{$s->id}}">{{$s->name}} ({{$s->type}})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Vai trò của NCC</label>
        <input type="text" name="role" id="role" class="form-control" placeholder="VD: Hotel, Xe bus, Nhà hàng...">
    </div>

    <button class="btn btn-success">Gán Nhà Cung Cấp</button>
    <a href="{{route('list-tour-supplier')}}" class="btn btn-secondary">Quay lại</a>

</form>
@endsection
