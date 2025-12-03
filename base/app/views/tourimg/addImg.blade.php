@extends('admin.dashboard')
@section('title', 'Thêm ảnh tour')

@section('active-departure', 'active')
@section('content')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{route('post-tourimg')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Chọn tour</label>
            <select name="tour_id" class="form-control">
                <option value="">-- Chọn tour --</option>
                @foreach($tours as $t)
                    <option value="{{$t->id}}">{{$t->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Ảnh</label>
            <input type="file" name="image" accept="image/*" class="form-control" />
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_thumbnail" id="is_thumbnail" />
            <label class="form-check-label" for="is_thumbnail">Đặt làm ảnh đại diện</label>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Thêm</button>
    </form>

@endsection