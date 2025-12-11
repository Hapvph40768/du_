@extends('layout.dashboard')
@section('title', 'Sửa thanh toán')

@section('active-payment', 'active')
@section('content')
    <div class="page-header mb-4">
        <h1 class="text-white mb-1">Cập nhật thanh toán</h1>
        <p class="text-white-50 mb-0">Chỉnh sửa thông tin giao dịch #{{ $detail->id }}</p>
    </div>

    {{-- Thông báo lỗi --}}
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

    {{-- Thông báo thành công --}}
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success mb-4">
            <span>{{ $_SESSION['success'] }}</span>
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card-dark p-4">
                <form action="{{ route('edit-payment/' . $detail->id) }}" method="post">
                    
                    {{-- chọn booking --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Booking <span class="text-danger">*</span></label>
                        <select name="booking_id" class="form-select" required>
                            @foreach($bookings as $b)
                                <option value="{{ $b->id }}" data-price="{{ $b->total_price }}" {{ $b->id == $detail->booking_id ? 'selected' : '' }}>
                                    Booking #{{ $b->id }} - {{ $b->tour_name }} ({{ date('d/m/Y', strtotime($b->start_date)) }} - {{ date('d/m/Y', strtotime($b->end_date)) }}) ({{ number_format($b->total_price) }} VND)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Khong bat buoc booking service --}}
                    <div class="mb-3">
                        <label class="form-label text-white-50">Booking Service (Tùy chọn)</label>
                        <select name="booking_service_id" class="form-select">
                            <option value="" data-price="0">-- Không chọn --</option>
                            @foreach($bookingServices as $bs)
                                <option value="{{ $bs->id }}" data-price="{{ $bs->price }}" {{ $bs->id == $detail->booking_service_id ? 'selected' : '' }}>
                                    BS #{{ $bs->id }} - Booking: {{ $bs->booking_id }} - {{ $bs->service_name }} (+{{ number_format($bs->price) }} VND)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Số tiền <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" name="amount" id="amount" value="{{ $detail->amount }}" required>
                                <span class="input-group-text bg-dark text-white-50 border-secondary">VND</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Phương thức <span class="text-danger">*</span></label>
                            <select name="method" class="form-select" required>
                                <option value="cash" {{ $detail->method === 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                                <option value="bank" {{ $detail->method === 'bank' ? 'selected' : '' }}>Ngân hàng</option>
                                <option value="card" {{ $detail->method === 'card' ? 'selected' : '' }}>Thẻ tín dụng/Ghi nợ</option>
                                <option value="momo" {{ $detail->method === 'momo' ? 'selected' : '' }}>Ví MoMo</option>
                                <option value="zalo" {{ $detail->method === 'zalo' ? 'selected' : '' }}>ZaloPay</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Mã giao dịch</label>
                            <input type="text" class="form-control" name="transaction_code" value="{{ $detail->transaction_code }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50">Thời gian thanh toán</label>
                            <input type="datetime-local" class="form-control" name="paid_at" 
                                   value="{{ $detail->paid_at ? date('Y-m-d\TH:i', strtotime($detail->paid_at)) : '' }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white-50">Trạng thái <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $detail->status === 'pending' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="success" {{ $detail->status === 'success' ? 'selected' : '' }}>Thành công</option>
                            <option value="failed" {{ $detail->status === 'failed' ? 'selected' : '' }}>Thất bại</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('list-payment') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        <button type="submit" class="btn btn-primary px-4" name="btn-submit">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingSelect = document.querySelector('select[name="booking_id"]');
            const serviceSelect = document.querySelector('select[name="booking_service_id"]');
            const amountInput = document.getElementById('amount');

            function updateAmount() {
                if (!bookingSelect || !serviceSelect || !amountInput) return;

                const bookingOption = bookingSelect.options[bookingSelect.selectedIndex];
                const serviceOption = serviceSelect.options[serviceSelect.selectedIndex];

                const bookingPrice = parseFloat(bookingOption.getAttribute('data-price')) || 0;
                const servicePrice = parseFloat(serviceOption.getAttribute('data-price')) || 0;

                const total = bookingPrice + servicePrice;
                
                if (total > 0) {
                    amountInput.value = total;
                }
            }

            if (bookingSelect) {
                bookingSelect.addEventListener('change', updateAmount);
            }
            if (serviceSelect) {
                serviceSelect.addEventListener('change', updateAmount);
            }
        });
    </script>
@endsection
