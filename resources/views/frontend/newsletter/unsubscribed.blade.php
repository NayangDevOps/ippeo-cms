@extends('layouts.frontend')

@section('title', 'Unsubscribed')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow-sm">
                    <div class="card-body py-5">
                        <i class="fas fa-envelope-open-text fa-4x text-success mb-4"></i>
                        <h2 class="fw-bold mb-3">Successfully Unsubscribed</h2>
                        <p class="text-muted mb-4">You have been unsubscribed from our newsletter. You will no longer receive marketing emails from us.</p>
                        <a href="{{ route('home') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
