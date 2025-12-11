@extends('layout.guide.GuideLayout')
@section('title', 'Danh sách yêu cầu đặc biệt')

@section('active-guide-sr', 'active')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách yêu cầu đặc biệt</h1>
        <a href="{{ route('add-guide-sr') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-plus-lg me-2"></i> Thêm yêu cầu
        </a>
    </div>

    {{-- Thông báo --}}
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
                    <th>Khách hàng</th>
                    <th>Nội dung yêu cầu</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                    <tr>
                        <td class="ps-4">{{ $req->id }}</td>
                        <td class="text-info">{{ $req->customer_name ?? 'N/A' }}</td>
                        <td>{{ mb_substr($req->request, 0, 50) }}...</td>
                        <td class="text-white-50">{{ $req->created_at }}</td>
                        <td class="text-white-50">{{ $req->updated_at }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('detail-guide-sr/' . $req->id) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil me-1"></i> Sửa
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có yêu cầu nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection