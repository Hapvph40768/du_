@extends('layout.dashboard')
@section('title', 'Thêm nhật ký tour')
@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary"><i class="fas fa-book"></i> Thêm nhật ký tour</h2>
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

        <form action="{{ route('post-tour-log') }}" method="post" class="bg-light p-4 rounded">
            <div class="mb-3">
                <label class="form-label fw-bold">Chọn chuyến đi</label>
                <select class="form-select" name="departure_id" required>
                    <option value="">-- Chọn chuyến đi --</option>
                    @foreach($departures as $dep)
                        <option value="{{ $dep->id }}">
                            {{ $dep->tour_name }} ({{ date('d/m/Y', strtotime($dep->start_date)) }} -
                            {{ date('d/m/Y', strtotime($dep->end_date)) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Thêm
                </button>
            </div>
        </form>
    </div>

@endsection