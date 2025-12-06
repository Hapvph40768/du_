@extends('admin.dashboard')

@section('title', 'Danh sách khách hàng')
@section('active-customers', 'active')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Danh sách khách hàng</h4>
        <a href="{{ BASE_URL }}customers/create" class="btn btn-primary">+ Thêm khách hàng</a>
    </div>

    <div class="card-body">

        @if(isset($_SESSION['success']))
            <div class="alert alert-success">
                {{ $_SESSION['success'] }}
                @php unset($_SESSION['success']); @endphp
            </div>
        @endif

        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Ngày tạo</th>
                    <th width="160">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->full_name }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->address }}</td>
                    <td>{{ $c->notes }}</td>
                    <td>{{ $c->created_at }}</td>
                    <td>
                        <a href="{{ BASE_URL }}customers/edit/{{ $c->id }}" class="btn btn-warning btn-sm">Sửa</a>
                        <a onclick="return confirm('Xóa khách hàng này?')" 
                           href="{{ BASE_URL }}customers/delete/{{ $c->id }}" 
                           class="btn btn-danger btn-sm">
                           Xóa
                        </a>
                    </td>
                </tr>
                @endforeach

                @if(count($customers) == 0)
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Chưa có khách hàng nào!
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>
</div>

@endsection
