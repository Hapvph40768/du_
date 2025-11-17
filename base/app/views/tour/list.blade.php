@extends('layout.main')
@section('content')
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
    <a href="{{route('add-tour')}}">
        <button>Thêm tour</button>
    </a>
<table border="1">
    <thead>
        <th>ID</th>
        <th>Name</th>

    </thead>
    <tbody>
         @foreach($tours as $st)
            <tr>
                <td>{{ $st->tour_id }}</td>
                <td>{{ $st->tour_name }}</td>
            </tr>
        @endforeach
    </tbody>

</table>
@endsection
