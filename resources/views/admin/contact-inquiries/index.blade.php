@extends('layouts.admin')

@section('title', 'Contact Inquiries')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Contact Inquiries</h2>
    <form method="GET" action="{{ route('admin.contact-inquiries.index') }}" class="d-flex align-items-center gap-2">
        <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
        </select>
        @if(request('status'))
            <a href="{{ route('admin.contact-inquiries.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contactInquiries as $inquiry)
                    <tr class="{{ $inquiry->status == 'new' ? 'table-info' : '' }}">
                        <td><strong>{{ $inquiry->name }}</strong></td>
                        <td>{{ $inquiry->email }}</td>
                        <td>{{ $inquiry->subject }}</td>
                        <td>{{ Str::limit($inquiry->message, 40) }}</td>
                        <td>
                            <span class="badge bg-{{ $inquiry->status == 'new' ? 'primary' : ($inquiry->status == 'read' ? 'info' : 'success') }}">
                                {{ ucfirst($inquiry->status) }}
                            </span>
                        </td>
                        <td>{{ $inquiry->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.contact-inquiries.show', $inquiry) }}" class="btn btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($inquiry->status != 'read')
                                <form action="{{ route('admin.contact-inquiries.mark-read', $inquiry) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" title="Mark as Read">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                @if($inquiry->status != 'replied')
                                <form action="{{ route('admin.contact-inquiries.mark-replied', $inquiry) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" title="Mark as Replied">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.contact-inquiries.destroy', $inquiry) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this inquiry?');">
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
                            <p class="text-muted mb-0">No inquiries found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($contactInquiries->hasPages())
    <div class="card-footer">
        {{ $contactInquiries->links() }}
    </div>
    @endif
</div>
@endsection
