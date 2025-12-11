@extends('layout.dashboard')
@section('title', 'Danh sách khách hàng')
@section('active-customer', 'active')

@section('content')
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-white mb-1">Quản lý khách hàng</h1>
            <p class="text-white-50 mb-0">Quản lý thông tin khách hàng và lịch sử đặt tour.</p>
        </div>
        <a href="{{ route('add-customer') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
            <i class="bi bi-person-plus-fill"></i> Thêm khách hàng
        </a>
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

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success mb-4">
            {{ $_SESSION['success'] }}
        </div>
        @php unset($_SESSION['success']) @endphp
    @endif

    <div class="card-dark p-3">
        <div class="table-responsive">
            <table class="table table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">ID</th>
                        <th>Họ tên</th>
                        <th>Liên hệ</th>
                        <th>Quốc tịch</th>
                        <th>Thông tin cá nhân</th>
                        <th>Ghi chú</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center" style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td class="text-center text-white-50">{{ $c->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center me-2 text-info" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="text-white fw-bold">{{ $c->fullname }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-white-50"><i class="bi bi-telephone me-2"></i>{{ $c->phone }}</span>
                                <span class="text-white-50"><i class="bi bi-envelope me-2"></i>{{ $c->email ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="text-white-50">{{ $c->nationality ?? 'N/A' }}</td>
                        <td>
                            <div class="small text-white-50">
                                <div>NS: {{ $c->dob ? date('d/m/Y', strtotime($c->dob)) : 'N/A' }}</div>
                                <div>GT: 
                                    <span class="badge {{ $c->gender === 'Nam' || $c->gender === 'male' ? 'bg-info' : 'bg-warning' }} bg-opacity-25 text-white border-0">
                                        {{ $c->gender === 'male' ? 'Nam' : ($c->gender === 'female' ? 'Nữ' : $c->gender) }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="text-white-50 small">{{ $c->note ?: '—' }}</td>
                        <td class="text-center text-white-50 font-monospace">
                            {{ date('d/m/Y', strtotime($c->created_at)) }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('detail-customer/' . $c->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                <i class="fas fa-edit"></i>Sửa
                            </a>
                            <a href="{{ route('delete-customer/' . $c->id) }}" class="btn btn-sm btn-outline-danger" title="Xóa"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng: {{ $c->fullname }}?')">
                                <i class="fas fa-trash-alt"></i>Xóa
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-white-50 py-4">Chưa có khách hàng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection