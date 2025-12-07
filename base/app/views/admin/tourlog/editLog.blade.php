@extends('layout.dashboard')
@section('title', 'Sửa nhật ký tour')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary"><i class="fas fa-edit"></i> Sửa nhật ký tour</h2>
            <a href="{{ route('list-tour-logs') }}" class="btn btn-warning">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        @if(isset($_SESSION['errors']) && isset($_GET['msg']))
            <div class="alert alert-danger">
                @foreach($_SESSION['errors'] as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('edit-tour-log/' . $detail->id) }}" method="post" class="bg-light p-4 rounded">
            <div class="mb-3">
                <label class="form-label fw-bold">Chọn chuyến đi</label>
                <select class="form-select" name="departure_id" required>
                    <option value="">-- Chọn chuyến đi --</option>
                    @foreach($departures as $dep)
                        <option value="{{ $dep->id }}" {{ $detail->departure_id == $dep->id ? 'selected' : '' }}>
                            {{ $dep->tour_name }} ({{ date('d/m/Y', strtotime($dep->start_date)) }} -
                            {{ date('d/m/Y', strtotime($dep->end_date)) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-end">
                <button type="submit" name="btn-submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>

@endsection