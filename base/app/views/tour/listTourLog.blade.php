@extends('admin.dashboard')
@section('title','Danh sách tour log')

@section('active-tour-log','active')
@section('content')
    <h3>Danh sách Tour Logs</h3>

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

    <a href="{{route('add-tour-log')}}" class="btn btn-success mb-3"><button class="btn btn-success">Thêm Log</button></a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Departure (start-end)</th>
                <th>Ngày</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $i => $l)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $l->depart_date ?? '' }}</td>
                    <td>{{ $l->day_number }}</td>
                    <td>{{ $l->note }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"><a href="{{route('detail-tour-log/' . $l->id)}}" style="color:white; text-decoration:none;">Sửa</a></button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{route('delete-tour-log/' . $l->id)}}','{{ $l->id }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(url, id){
            if(window.confirm('Bạn có chắc muốn xóa log #' + id + ' ?')){
                window.location.href = url;
            }
        }
    </script>
@endsection
