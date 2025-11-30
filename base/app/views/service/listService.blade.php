@extends('admin.dashboard')
@section('title', 'Danh sách dịch vụ')

@section('active-service', 'active')
@section('content')
    <h3>Danh Sách Dịch Vụ</h3>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
            <ul>
                @foreach($_SESSION['errors'] as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div style="color: green; border: 1px solid green; padding: 10px; margin-bottom: 15px;">
            <span>{{$_SESSION['success']}}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <a href="{{route('add-service')}}" class="btn btn-success mb-3"><button class="btn btn-success">Thêm Dịch Vụ</button></a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tour</th>
                <th>Tên gói</th>
                <th>Giá</th>
                <th>Currency</th>
                <th>Tuỳ chọn</th>
                <th>Active</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->tour_name ?? '' }}</td>
                    <td>{{ $s->package_name }}</td>
                    <td>{{ $s->price }}</td>
                    <td>{{ $s->currency ?? 'VND' }}</td>
                    <td>{{ $s->is_optional ? 'Yes' : 'No' }}</td>
                    <td>{{ $s->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"><a href="{{route('detail-service/' . $s->id)}}" style="color:white; text-decoration:none;">Sửa</a></button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{route('delete-service/' . $s->id)}}','{{ $s->name }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(url, name){
            if(window.confirm(`Bạn có chắc muốn xóa dịch vụ: ${name} ?`)){
                window.location.href = url;
            }
        }
    </script>
@endsection
