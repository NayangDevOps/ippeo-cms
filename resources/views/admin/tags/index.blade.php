@extends('layouts.admin')

@section('title', 'Tags Management')

@section('content')
<div class="table-toolbar">
    <div class="toolbar-left">
        <h2 class="mb-0">Tags Management</h2>
    </div>
    <div class="toolbar-right">
        <a href="{{ route('admin.tags.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> Add New Tag
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Created</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $tag)
                    <tr>
                        <td><strong>{{ $tag->name }}</strong></td>
                        <td>{{ $tag->slug }}</td>
                        <td>
                            <span class="badge bg-info">{{ $tag->products->count() }} products</span>
                        </td>
                        <td>{{ $tag->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this tag?');">
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
                        <td colspan="5" class="text-center py-4">
                            <p class="text-muted mb-0">No tags found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
