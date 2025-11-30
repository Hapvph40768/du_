@extends('admin.dashboard')
@section('title','Chỉnh sửa ảnh tour')

@section('active-tour-img','active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{route('list-tour-img')}}"><button type="button" class="btn btn-warning">Quay lại</button></a>

    <form action="{{route('edit-tour-img/' . $detail->id)}}" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tour_id">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-control">
                @foreach($tours as $t)
                    <option value="{{ $t->id }}" {{ $t->id == ($detail->tour_id ?? '') ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Ảnh hiện tại</label><br>
            <img src="{{BASE_URL}}{{$detail->image_path}}" style="max-width:200px;"/>
        </div>

        <div class="mb-3">
            <label for="image">Thay ảnh (tùy chọn)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_thumbnail" name="is_thumbnail" {{ $detail->is_thumbnail ? 'checked' : '' }}>
            <label class="form-check-label" for="is_thumbnail">Đặt làm thumbnail</label>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Lưu</button>
        </div>
    </form>
@endsection
