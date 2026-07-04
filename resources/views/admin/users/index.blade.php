@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="table-container">
    <div class="table-toolbar">
        <div class="toolbar-left">
            <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex align-items-center gap-2">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}">
                </div>
                <select name="role" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                @endif
            </form>
        </div>
        <div class="toolbar-right">
            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add User
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-{{ $user->is_active ? 'success' : 'secondary' }}" style="min-width:65px"
                                    {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id != auth()->id())
                            <button type="button" class="btn btn-danger" title="Delete"
                                onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h5>No Users Found</h5>
                            <p>There are no users matching your criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
