@extends('admin.dashboard')
@section('title', 'Danh sách yêu cầu thay đổi dịch vụ')

@section('active-service-change-request', 'active')
@section('content')
    <h3>Danh sách yêu cầu thay đổi dịch vụ</h3>

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

    <a href="{{route('add-service-change-request')}}" class="btn btn-success mb-3"><button class="btn btn-success">Thêm yêu cầu</button></a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Booking</th>
                <th>Yêu cầu</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->customer_name ?? $r->booking_id }}</td>
                    <td>{{ $r->request }}</td>
                    <td>{{ $r->status }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"><a href="{{route('detail-service-change-request/' . $r->id)}}" style="color:white; text-decoration:none;">Sửa</a></button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{route('delete-service-change-request/' . $r->id)}}','{{ $r->id }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(url, id){
            if(window.confirm(`Bạn có chắc muốn xóa yêu cầu #${id} ?`)){
                window.location.href = url;
            }
        }
    </script>
@endsection
