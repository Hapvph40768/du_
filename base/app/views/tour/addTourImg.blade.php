@extends('admin.dashboard')
@section('title','Thêm ảnh tour')

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

    <form action="{{route('post-tour-img')}}" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tour_id">Chọn Tour</label>
            <select name="tour_id" id="tour_id" class="form-control" required>
                @foreach($tours as $t)
                    <option value="{{ $t->id }}">{{ $t->title ?? $t->name ?? 'Untitled' }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image">Ảnh (file)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_thumbnail" name="is_thumbnail">
            <label class="form-check-label" for="is_thumbnail">Đặt làm thumbnail</label>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Tải lên</button>
        </div>
    </form>
@endsection
