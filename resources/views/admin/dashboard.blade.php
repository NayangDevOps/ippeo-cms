@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <p class="text-muted mb-0">Welcome back, <strong>{{ auth()->user()->name }}</strong>! Here's what's happening today.</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stats-card primary">
        <div class="stats-icon"><i class="fas fa-box"></i></div>
        <div class="stats-label">Total Products</div>
        <div class="stats-value">{{ $stats['total_products'] }}</div>
        <div class="stats-accent"></div>
    </div>

    <div class="stats-card success">
        <div class="stats-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stats-label">Active Products</div>
        <div class="stats-value">{{ $stats['active_products'] }}</div>
        <div class="stats-accent"></div>
    </div>

    <div class="stats-card info">
        <div class="stats-icon"><i class="fas fa-list"></i></div>
        <div class="stats-label">Categories</div>
        <div class="stats-value">{{ $stats['total_categories'] }}</div>
        <div class="stats-accent"></div>
    </div>

    <div class="stats-card secondary">
        <div class="stats-icon"><i class="fas fa-users"></i></div>
        <div class="stats-label">Users</div>
        <div class="stats-value">{{ $stats['total_users'] }}</div>
        <div class="stats-accent"></div>
    </div>

    <div class="stats-card danger">
        <div class="stats-icon"><i class="fas fa-star"></i></div>
        <div class="stats-label">Pending Reviews</div>
        <div class="stats-value">{{ $stats['pending_reviews'] }}</div>
        <div class="stats-accent"></div>
    </div>

    <div class="stats-card warning">
        <div class="stats-icon"><i class="fas fa-envelope"></i></div>
        <div class="stats-label">New Inquiries</div>
        <div class="stats-value">{{ $stats['new_inquiries'] }}</div>
        <div class="stats-accent"></div>
    </div>

    <div class="stats-card success">
        <div class="stats-icon"><i class="fas fa-paper-plane"></i></div>
        <div class="stats-label">Subscribers</div>
        <div class="stats-value">{{ $stats['newsletter_subscribers'] }}</div>
        <div class="stats-accent"></div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Products -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-box text-success me-2"></i>Recent Products</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-success">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProducts as $product)
                            <tr>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ $product->category->name }}</td>
                                <td>₹{{ number_format($product->current_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->is_active ? 'success' : 'danger' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-envelope text-warning me-2"></i>Recent Inquiries</h5>
                <a href="{{ route('admin.contact-inquiries.index') }}" class="btn btn-sm btn-success">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInquiries as $inquiry)
                            <tr>
                                <td><strong>{{ $inquiry->name }}</strong></td>
                                <td>{{ Str::limit($inquiry->subject, 30) }}</td>
                                <td>
                                    <span class="badge bg-{{ $inquiry->status === 'new' ? 'danger' : ($inquiry->status === 'read' ? 'warning' : 'success') }}">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </td>
                                <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-star text-warning me-2"></i>Recent Reviews</h5>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-success">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentReviews as $review)
                            <tr>
                                <td><strong>{{ $review->product->name }}</strong></td>
                                <td>{{ $review->name }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $review->rating ? ' text-warning' : '-o text-muted' }}" style="font-size:0.85rem"></i>
                                    @endfor
                                </td>
                                <td>{{ Str::limit($review->comment, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $review->is_approved ? 'success' : 'warning' }}">
                                        {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $review->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
