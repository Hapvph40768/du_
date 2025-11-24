@extends('layout.main')
@section('content-toursupplier')

<h3>Danh Sách Nhà Cung Cấp Theo Tour</h3>

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

@if(isset($_SESSION['success']) && isset($_GET['msg']))
    <div style="color:green;border:1px solid green;padding:10px;margin-bottom:15px;">
        {{$_SESSION['success']}}
    </div>
    @php unset($_SESSION['success']) @endphp
@endif

<a href="{{route('add-tour-supplier')}}" class="btn btn-success mb-3">Gán Nhà Cung Cấp Cho Tour</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tour ID</th>
            <th>Nhà Cung Cấp</th>
            <th>Loại NCC</th>
            <th>SĐT</th>
            <th>Vai trò</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->tour_id}}</td>
            <td>{{$item->supplier_name}}</td>
            <td>{{$item->supplier_type}}</td>
            <td>{{$item->supplier_phone}}</td>
            <td>{{$item->role}}</td>
            <td>
                <a href="{{route('detail-tour-supplier/' . $item->id)}}" class="btn btn-primary btn-sm">Sửa</a>
                <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{route('delete-tour-supplier/' . $item->id)}}','{{$item->supplier_name}}')">Xóa</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
function confirmDelete(url, name) {
    if (confirm(`Xóa NCC: ${name}?`)) window.location.href = url;
}
</script>

@endsection
