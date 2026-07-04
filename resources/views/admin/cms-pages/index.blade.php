@extends('layouts.admin')

@section('title', 'CMS Pages Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">CMS Pages Management</h2>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('admin.cms-pages.index') }}" class="d-flex align-items-center gap-2">
            <select name="template" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Templates</option>
                @foreach($templates as $tpl)
                    <option value="{{ $tpl }}" {{ request('template') == $tpl ? 'selected' : '' }}>{{ ucfirst($tpl) }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @if(request('template') || request('status'))
                <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.cms-pages.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Page
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cmsPages as $page)
                    <tr>
                        <td><strong>{{ $page->title }}</strong></td>
                        <td><code>{{ $page->slug }}</code></td>
                        <td><span class="badge bg-secondary">{{ $page->template ?? 'default' }}</span></td>
                        <td>
                            <form action="{{ route('admin.cms-pages.toggle-status', $page) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $page->is_active ? 'success' : 'secondary' }}">
                                    {{ $page->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>{{ $page->updated_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($page->is_active)
                                <a href="{{ route('page.show', $page->slug) }}" class="btn btn-info" target="_blank" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                <a href="{{ route('admin.cms-pages.edit', $page) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.cms-pages.destroy', $page) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this page?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted mb-0">No CMS pages found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
