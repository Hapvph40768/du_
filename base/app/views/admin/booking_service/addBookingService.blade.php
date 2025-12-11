@extends('layout.dashboard')
@section('title', 'Thêm Dịch vụ vào Booking')
@section('active-booking-service', 'active')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">
            <i class="fas fa-plus-circle"></i> Thêm Dịch vụ vào Booking
        </h1>
        <a href="{{ route('list-booking-service') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('post-booking-service') }}" method="post">
                <div class="mb-3">
                    <label class="form-label">Booking</label>
                    <select name="booking_id" class="form-select" required>
                        <option value="">-- Chọn Booking --</option>
                        @foreach($bookings as $b)
                            <option value="{{ $b->id }}">
                                Booking #{{ $b->id }} - {{ $b->fullname }} - {{ $b->tour_name }} 
                                ({{ date('d/m/Y', strtotime($b->start_date)) }} - {{ date('d/m/Y', strtotime($b->end_date)) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Chọn Dịch vụ</label>
                    <div class="service-list" style="max-height: 400px; overflow-y: auto;">
                        @foreach($services as $s)
                            <div class="d-flex align-items-center gap-3 p-2 border-bottom">
                                <div class="form-check mb-0">
                                    <input class="form-check-input service-checkbox" type="checkbox" 
                                           name="services[{{ $s->id }}][selected]" 
                                           value="1" 
                                           id="srv_{{ $s->id }}"
                                           data-price="{{ $s->price > 0 ? $s->price : $s->default_price }}">
                                    <label class="form-check-label" for="srv_{{ $s->id }}">
                                        {{ $s->name }}
                                    </label>
                                </div>
                                <div class="ms-auto d-flex align-items-center gap-2" id="inputs_{{ $s->id }}" style="display:none;">
                                    <input type="number" name="services[{{ $s->id }}][quantity]" value="1" min="1" 
                                           class="form-control form-control-sm text-center" style="width: 70px" placeholder="SL" title="Số lượng">
                                    <div class="input-group input-group-sm" style="width: 140px">
                                        <input type="number" step="0.01" name="services[{{ $s->id }}][price]" 
                                               value="{{ $s->price > 0 ? $s->price : $s->default_price }}" 
                                               class="form-control" placeholder="Giá" title="Giá tại thời điểm đặt">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" name="btn-submit">
                    <i class="fas fa-save"></i> Thêm
                </button>
                <a href="{{ route('list-booking-service') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.service-checkbox');
        
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const srvId = this.id.replace('srv_', '');
                const inputsDiv = document.getElementById('inputs_' + srvId);
                if (this.checked) {
                     inputsDiv.style.display = 'flex';
                } else {
                     inputsDiv.style.display = 'none';
                }
            });
        });
    });
</script>