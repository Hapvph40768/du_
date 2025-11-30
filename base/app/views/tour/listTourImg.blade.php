@extends('admin.dashboard')
@section('title','Danh sách ảnh tour')

@section('active-tour-img','active')
@section('content')
    <h3>Danh sách ảnh tour</h3>
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

    <a href="{{route('add-tour-img')}}" class="btn btn-success mb-3"><button class="btn btn-success">Thêm Ảnh</button></a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tour</th>
                <th>Ảnh</th>
                <th>Thumbnail</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $i => $img)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $img->tour_title ?? $img->tour_name ?? '' }}</td>
                    <td>
                        @php $src = $img->image_path ?? $img->url ?? ''; @endphp
                        @if(!empty($src))
                            <img src="{{BASE_URL}}{{$src}}" style="max-width:120px;"/>
                        @else
                            <span>(no image)</span>
                        @endif
                    </td>
                    <td>{{ $img->is_thumbnail ? 'Yes' : 'No' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm"><a href="{{route('detail-tour-img/' . $img->id)}}" style="color:white; text-decoration:none;">Sửa</a></button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{route('delete-tour-img/' . $img->id)}}','{{ $img->id }}')">Xóa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete(url, id){
            if(window.confirm('Bạn có chắc muốn xóa ảnh #' + id + ' ?')){
                window.location.href = url;
            }
        }
    </script>
@endsection
