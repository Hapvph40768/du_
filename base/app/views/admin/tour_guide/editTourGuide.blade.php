@extends('layout.dashboard')
@section('title', 'Sửa Tour Guide')
@section('active-tour-guide', 'active')

@section('content')
<div class="page-header mb-4">
    <h1 class="text-white">Sửa Tour Guide</h1>
</div>

<div class="card-dark p-4">
    <form action="{{ route('edit-tour-guide/'.$detail->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label text-white">Chuyến đi <span class="text-danger">*</span></label>
            <select name="departure_id" class="form-select" required>
                <option value="">-- Chọn chuyến đi --</option>
                @foreach($departures as $d)
                    @php
                        $start = !empty($d->start_date) ? $d->start_date : $d->booking_start_date;
                        $end = !empty($d->end_date) ? $d->end_date : $d->booking_end_date;
                    @endphp
                    <option value="{{ $d->id }}" {{ $d->id == $detail->departure_id ? 'selected' : '' }}>
                        {{ $d->tour_name }} ({{ $start ? date('d/m/Y', strtotime($start)) : 'N/A' }} - {{ $end ? date('d/m/Y', strtotime($end)) : 'N/A' }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Hướng dẫn viên <span class="text-danger">*</span></label>
            <select name="guide_id" class="form-select" required>
                <option value="">-- Chọn hướng dẫn viên --</option>
                @foreach($guides as $g)
                    <option value="{{ $g->id }}" {{ $g->id == $detail->guide_id ? 'selected' : '' }}>
                       {{ $g->fullname }} ({{ $g->account_name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label text-white">Vai trò <span class="text-danger">*</span></label>
            <select name="role" class="form-select" required>
                <option value="main" {{ $detail->role === 'main' ? 'selected' : '' }}>Trưởng đoàn (Main)</option>
                <option value="assistant" {{ $detail->role === 'assistant' ? 'selected' : '' }}>Phó đoàn (Assistant)</option>
                <option value="support" {{ $detail->role === 'support' ? 'selected' : '' }}>Hỗ trợ (Support)</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" name="btn-submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('list-tour-guide') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>
@endsection