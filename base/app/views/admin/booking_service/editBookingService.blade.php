@extends('layout.dashboard')
@section('title', 'Sửa Dịch vụ Booking')

@section('active-booking-service', 'active')
@section('content')
    <h3>Sửa Dịch vụ Booking #{{ $detail->id }}</h3>

    <form action="{{ route('edit-booking-service/' . $detail->id) }}" method="post">
        <div class="mb-3">
            <label>Booking</label>
            <select name="booking_id" class="form-select" required>
                @foreach($bookings as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $detail->booking_id ? 'selected' : '' }}>
                        Booking #{{ $b->id }} - {{ $b->fullname }} - {{ $b->tour_name }} 
                        ({{ date('d/m/Y', strtotime($b->start_date)) }} - {{ date('d/m/Y', strtotime($b->end_date)) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Chọn Dịch vụ</label>
            <div class="service-list" style="max-height: 400px; overflow-y: auto;">
                @php
                    $activeMap = [];
                    foreach($activeServices as $as) {
                        $activeMap[$as->service_id] = $as;
                    }
                @endphp
                @foreach($services as $s)
                    @php
                        $isChecked = isset($activeMap[$s->id]);
                        $currentQty = $isChecked ? $activeMap[$s->id]->quantity : 1;
                        $currentPrice = $isChecked ? $activeMap[$s->id]->price : ($s->price > 0 ? $s->price : $s->default_price);
                    @endphp
                    <div class="d-flex align-items-center gap-3 p-2 border-bottom">
                        <div class="form-check mb-0">
                            <input class="form-check-input service-checkbox" type="checkbox" 
                                   name="services[{{ $s->id }}][selected]" 
                                   value="1" 
                                   id="srv_{{ $s->id }}"
                                   {{ $isChecked ? 'checked' : '' }}>
                            <label class="form-check-label" for="srv_{{ $s->id }}">
                                {{ $s->name }}
                            </label>
                        </div>
                        <div class="ms-auto d-flex align-items-center gap-2" id="inputs_{{ $s->id }}" style="{{ $isChecked ? 'display:flex;' : 'display:none;' }}">
                            <input type="number" name="services[{{ $s->id }}][quantity]" value="{{ $currentQty }}" min="1" 
                                   class="form-control form-control-sm text-center" style="width: 70px" placeholder="SL" title="Số lượng">
                            <div class="input-group input-group-sm" style="width: 140px">
                                <input type="number" step="0.01" name="services[{{ $s->id }}][price]" 
                                       value="{{ $currentPrice }}" 
                                       class="form-control" placeholder="Giá" title="Giá tại thời điểm đặt">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="btn-submit">Cập nhật (Lưu tất cả)</button>
        <a href="{{ route('list-booking-service') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection

<script>
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
</script>