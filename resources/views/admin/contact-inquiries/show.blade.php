@extends('layouts.admin')

@section('title', 'Contact Inquiry Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Inquiry Details</h2>
    <a href="{{ route('admin.contact-inquiries.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Inquiries
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $contactInquiry->subject }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h6>Contact Information</h6>
                <p><strong>Name:</strong> {{ $contactInquiry->name }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $contactInquiry->email }}">{{ $contactInquiry->email }}</a></p>
                <p><strong>Phone:</strong> {{ $contactInquiry->phone ?? 'Not provided' }}</p>
            </div>
            <div class="col-md-6">
                <h6>Inquiry Details</h6>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $contactInquiry->status == 'new' ? 'primary' : ($contactInquiry->status == 'read' ? 'info' : 'success') }}">
                        {{ ucfirst($contactInquiry->status) }}
                    </span>
                </p>
                <p><strong>Date:</strong> {{ $contactInquiry->created_at->format('M d, Y H:i A') }}</p>
            </div>
        </div>
        
        <hr>
        
        <h6>Message</h6>
        <div class="p-3 bg-light rounded">
            {{ $contactInquiry->message }}
        </div>
        
        <div class="mt-4">
            <div class="btn-group">
                @if($contactInquiry->status != 'read')
                <form action="{{ route('admin.contact-inquiries.mark-read', $contactInquiry) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Mark as Read
                    </button>
                </form>
                @endif
                
                @if($contactInquiry->status != 'replied')
                <form action="{{ route('admin.contact-inquiries.mark-replied', $contactInquiry) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-reply me-2"></i>Mark as Replied
                    </button>
                </form>
                @endif
                
                <a href="mailto:{{ $contactInquiry->email }}?subject=Re: {{ urlencode($contactInquiry->subject) }}" class="btn btn-info">
                    <i class="fas fa-envelope me-2"></i>Reply via Email
                </a>
                
                <form action="{{ route('admin.contact-inquiries.destroy', $contactInquiry) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this inquiry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
