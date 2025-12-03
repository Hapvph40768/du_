@extends('admin.dashboard')
@section('title', 'Sửa ảnh tour')

@section('active-departure', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{route('edit-tourimg/' . $detail->id)}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Chọn tour</label>
            <select name="tour_id" class="form-control">
                <option value="">-- Chọn tour --</option>
                @foreach($tours as $t)
                    <option value="{{$t->id}}" {{ $t->id == $detail->tour_id ? 'selected' : '' }}>{{$t->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ảnh hiện tại</label>
            @if(isset($detail->image_path) && $detail->image_path)
                <div><img src="{{ BASE_URL . $detail->image_path }}" width="200" /></div>
            @endif
        </div>

        <div class="form-group">
            <label>Thay ảnh (nếu muốn)</label>
            <input type="file" name="image" accept="image/*" class="form-control" />
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_thumbnail" id="is_thumbnail" {{ $detail->is_thumbnail ? 'checked' : '' }} />
            <label class="form-check-label" for="is_thumbnail">Đặt làm ảnh đại diện</label>
        </div>

        <button type="submit" name="btn-submit" class="btn btn-primary mt-2">Cập nhật</button>
    </form>

@endsection