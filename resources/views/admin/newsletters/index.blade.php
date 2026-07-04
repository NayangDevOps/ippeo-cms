@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Newsletter Subscribers</h2>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('admin.newsletters.index') }}" class="d-flex align-items-center gap-2">
            <select name="subscription" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Subscribers</option>
                <option value="subscribed" {{ request('subscription') == 'subscribed' ? 'selected' : '' }}>Active</option>
                <option value="unsubscribed" {{ request('subscription') == 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
            </select>
            @if(request('subscription'))
                <a href="{{ route('admin.newsletters.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.newsletters.export') }}" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Export to CSV
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Subscribed</th>
                        <th>Unsubscribed</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($newsletters as $newsletter)
                    <tr>
                        <td><strong>{{ $newsletter->email }}</strong></td>
                        <td>
                            <span class="badge bg-{{ $newsletter->is_subscribed ? 'success' : 'secondary' }}">
                                {{ $newsletter->is_subscribed ? 'Active' : 'Unsubscribed' }}
                            </span>
                        </td>
                        <td>{{ $newsletter->subscribed_at ? $newsletter->subscribed_at->format('M d, Y') : '-' }}</td>
                        <td>{{ $newsletter->unsubscribed_at ? $newsletter->unsubscribed_at->format('M d, Y') : '-' }}</td>
                        <td>
                            <form action="{{ route('admin.newsletters.destroy', $newsletter) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Remove this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <p class="text-muted mb-0">No subscribers found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($newsletters->hasPages())
    <div class="card-footer">
        {{ $newsletters->links() }}
    </div>
    @endif
</div>
@endsection
