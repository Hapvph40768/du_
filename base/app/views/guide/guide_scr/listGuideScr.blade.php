@extends('layout.guide.GuideLayout')
@section('title', 'Yêu cầu thay đổi dịch vụ')

@section('active-guide-scr', 'active')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Yêu cầu thay đổi dịch vụ</h1>
        <a href="{{ route('add-guide-scr') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-2"></i> Thêm yêu cầu
        </a>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success">
            {{ $_SESSION['success'] }}
        </div>
    @endif

    <div class="card-dark p-0">
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Booking</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                    <tr>
                        <td class="ps-4">{{ $req->id }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-white">{{ $req->customer_name }}</span>
                                <small class="text-white-50" style="font-size: 0.8rem;">{{ $req->tour_name }}</small>
                            </div>
                        </td>
                        <td>{{ mb_substr($req->request, 0, 50) }}...</td>
                        <td>
                            @if($req->status === 'pending')
                                <span class="badge bg-warning text-dark">Đang chờ</span>
                            @elseif($req->status === 'approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-danger">Từ chối</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('detail-guide-scr/' . $req->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-pencil me-1"></i> Sửa
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Chưa có yêu cầu nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
