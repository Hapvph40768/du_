@extends('admin.dashboard')
@section('title', 'Sửa Booking')

@section('active-booking', 'active')
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
    <a href="{{route('list-booking')}}">
        <button type="button" class="btn btn-warning">Quay lai</button>
    </a>
<form action="{{ route('edit-booking' . $detail->id) }}" method="post">

        {{-- Khoi hanh --}}
        <div class="mb-3">
            <label>Chọn khoi hanh</label><br>
            <select name="departure_id" required>
                @foreach($departures as $d)
                    <option value="{{ $d->id }}">Tour {{ $d->tour_id }}{{ $d->date_start }} - {{ $d->date_end }}</option>
                @endforeach
            </select>
        </div>
        {{-- Ten khach hang --}}
        <div class="mb-3">
            <label for="customer_name" class="form-label">Ho va ten</label>
            <input type="text" class="form-control" name="customer_name" value="{{ $detail->customer_name }}">
        </div>
        {{-- So dien thoai --}}
        <div class="mb-3">
            <label for="customer_phone" class="form-label">STD</label>
            <input type="text" class="form-control" name="customer_phone" value="{{ $detail->customer_phone }}">
        </div>

        {{-- noi dung chi tiet --}}
        <div class="mb-3">
            <label for="people" class="form-label">So luong</label>
            <input type="text" class="form-control" name="people" value="{{ $detail->customer_name }}">
        </div>

        {{-- Tong tien--}}
        <div class="mb-3">
            <label for="total_price" class="form-label">Tong tien</label>
            <input type="text" class="form-control" name="total_price" value="{{ $detail->total_price }}">
        </div>

        {{-- Trang thai --}}
        <div>
            <select name="status" class="form-select" required value="{{ $detail->status }}">
                <option value="pending" {{ (isset($_POST['status']) && $_POST['status'] == 'pending') ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="paid" {{ (isset($_POST['status']) && $_POST['status'] == 'paid') ? 'selected' : '' }}>
                    Paid
                </option>

                <option value="cancelled" {{ (isset($_POST['status']) && $_POST['status'] == 'cancelled') ? 'selected' : '' }}>
                    Cancelled
                </option>
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" name="btn-submit" value="them">Confirm</button>
        </div>

    </form>

@endsection