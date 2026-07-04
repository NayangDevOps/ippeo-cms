@extends('layouts.admin')

@section('title', 'Blog Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Blog Management</h2>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="d-flex align-items-center gap-2">
            <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            @if(request('status'))
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Post
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                    <tr>
                        <td>
                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" 
                                 class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td><strong>{{ $blog->title }}</strong></td>
                        <td>{{ $blog->author->name }}</td>
                        <td><span class="badge bg-info">{{ $blog->views }}</span></td>
                        <td>
                            <form action="{{ route('admin.blogs.toggle-publish', $blog) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $blog->is_published ? 'success' : 'secondary' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($blog->is_published)
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-info" target="_blank" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this blog post?');">
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
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">No blog posts found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($blogs->hasPages())
    <div class="card-footer">
        {{ $blogs->links() }}
    </div>
    @endif
</div>
@endsection
