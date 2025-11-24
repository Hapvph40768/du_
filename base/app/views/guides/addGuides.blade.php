@extends('layout.main')
@section('content-guides')
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <ul>
            @foreach($_SESSION['errors'] as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <span>{{$_SESSION['success']}}</span>
    @endif
    <form action="{{route('post-guides')}}" method="post">
<label>Tài khoản liên kết</label>
    <select name="user_id" required>
        <option value="">-- chọn user --</option>
        <?php foreach($users as $u): ?>
            <option value="<?=$u['id']?>"><?=htmlspecialchars($u['fullname'].' ('.$u['username'].')')?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Ngày sinh</label>
    <input type="date" name="dob"><br>

    <label>Ảnh đại diện</label>
    <input type="file" name="avatar" accept="image/*"><br>

    <label>Ngôn ngữ</label>
    <input type="text" name="languages" placeholder="Tiếng Việt, Tiếng Anh"><br>

    <label>Số năm kinh nghiệm</label>
    <input type="number" name="experience_years" min="0"><br>
    </form>
@endsection