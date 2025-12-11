@extends('layout.dashboard')
@section('title', 'Thêm thanh toán')

@section('active-payment', 'active')
@section('content')
    <div class="page-header mb-4">
        <h1 class="text-white mb-1">Thêm thanh toán mới</h1>
        <p class="text-white-50 mb-0">Ghi nhận giao dịch thanh toán cho booking.</p>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php unset($_SESSION['errors']) @endphp
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card-dark p-4">
                <form action="{{ route('post-payment') }}" method="post">
                    
                    {{-- chọn booking --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Booking <span class="text-danger">*</span></label>
                        <select name="booking_id" class="form-select" required>
                            <option value="">-- Chọn Booking --</option>
                            @foreach($bookings as $b)
                                <option value="{{ $b->id }}" data-price="{{ $b->total_price }}">Booking #{{ $b->id }} - {{ $b->tour_name }} ({{ date('d/m/Y', strtotime($b->start_date)) }} - {{ date('d/m/Y', strtotime($b->end_date)) }}) ({{ number_format($b->total_price) }} VND)</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Khong bat buoc booking service --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Booking Service (Tùy chọn)</label>
                        <div class="border rounded p-3 bg-dark" style="max-height: 200px; overflow-y: auto;">
                            @foreach($bookingServices as $bs)
                            <div class="form-check">
                                <input class="form-check-input booking-service-checkbox" type="checkbox" name="booking_service_ids[]" value="{{ $bs->id }}" id="bs_{{ $bs->id }}" data-price="{{ $bs->price }}">
                                <label class="form-check-label text-white-50" for="bs_{{ $bs->id }}">
                                    BS #{{ $bs->id }} - Booking: {{ $bs->booking_id }} - {{ $bs->service_name }} (+{{ number_format($bs->price) }} VND)
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-text text-white-50">Chọn nhiều dịch vụ để cộng dồn vào tổng tiền.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Số tiền <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" name="amount" id="amount" required>
                                <span class="input-group-text bg-dark text-white-50 border-secondary">VND</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Phương thức <span class="text-danger">*</span></label>
                            <select name="method" class="form-select" required>
                                <option value="cash">Tiền mặt</option>
                                <option value="bank">Ngân hàng</option>
                                <option value="card">Thẻ tín dụng/Ghi nợ</option>
                                <option value="momo">Ví MoMo</option>
                                <option value="zalo">ZaloPay</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Mã giao dịch</label>
                            <input type="text" class="form-control" name="transaction_code" placeholder="VD: TRX123456789">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Thời gian thanh toán</label>
                            <input type="datetime-local" class="form-control" name="paid_at">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white-50">Trạng thái <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending">Đang xử lý</option>
                            <option value="success">Thành công</option>
                            <option value="failed">Thất bại</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('list-payment') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary px-4" name="btn-submit">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingSelect = document.querySelector('select[name="booking_id"]');
            const serviceCheckboxes = document.querySelectorAll('.booking-service-checkbox');
            const amountInput = document.getElementById('amount');

            function updateAmount() {
                if (!bookingSelect || !amountInput) return;

                const bookingOption = bookingSelect.options[bookingSelect.selectedIndex];
                const bookingPrice = parseFloat(bookingOption.getAttribute('data-price')) || 0;
                
                let servicePrice = 0;
                serviceCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        servicePrice += parseFloat(cb.getAttribute('data-price')) || 0;
                    }
                });

                const total = bookingPrice + servicePrice;
                
                if (total > 0) {
                    amountInput.value = total;
                } else {
                     amountInput.value = '';
                }
            }

            if (bookingSelect) {
                bookingSelect.addEventListener('change', updateAmount);
            }
            
            serviceCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateAmount);
            });
        });
    </script>
@endsection
