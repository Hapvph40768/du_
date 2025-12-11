@extends('layout.dashboard')

@section('title', 'Danh sách người dùng')

@section('active-user', 'active')

@section('content')
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-white mb-1">Quản lý người dùng</h1>
            <p class="text-white-50 mb-0">Quản lý tài khoản, phân quyền và trạng thái người dùng.</p>
        </div>
        <a href="{{ route('add-user') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
            <i class="bi bi-person-plus-fill"></i> Thêm người dùng
        </a>
    </div>

    @if(isset($_SESSION['errors']) && isset($_GET['msg']))
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($_SESSION['errors'] as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($_SESSION['success']) && isset($_GET['msg']))
        <div class="alert alert-success mb-4">
            {{$_SESSION['success']}}
        </div>
    @endif

    <div class="card-dark p-3">
        <div class="table-responsive">
            <table class="table table-dark-custom align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Chức năng</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center" style="width: 150px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td class="text-center text-white-50">{{ $u->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($u->avatar)
                                    <img src="{{ $u->avatar }}" alt="avatar" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center me-2 text-white" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-white fw-bold">{{ $u->fullname ?? $u->username }}</div>
                                    <div class="text-white-50 small">{{ $u->username }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-white-50">{{ $u->email }}</td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-3">
                                {{ $u->role_name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($u->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">Hoạt động</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3">Đã khóa</span>
                            @endif
                        </td>
                        <td class="text-center text-white-50 font-monospace">
                            {{ date('d/m/Y', strtotime($u->created_at)) }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('detail-user/' . $u->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                <i class="fas fa-edit"></i>Sửa
                            </a>
                            <a href="{{ route('delete-user/' . $u->id) }}" class="btn btn-sm btn-outline-danger" title="Xóa"
                               onclick="return confirm('Bạn có chắc muốn xóa user này?')">
                                <i class="fas fa-trash-alt"></i>Xóa
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection