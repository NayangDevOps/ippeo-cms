@extends('layouts.frontend')

@section('title', 'About Us - Cosmetic CMS')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">About Us</li>
        </ol>
    </div>
</nav>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        @if($page)
            <h1 class="mb-4">{{ $page->title }}</h1>
            <div class="content">
                {!! $page->content !!}
            </div>
        @else
            <!-- Default About Content -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-4 mb-3">About <span class="text-success">Cosmetic CMS</span></h1>
                    <p class="lead">Your trusted source for premium cosmetic products</p>
                    <p>Welcome to Cosmetic CMS, where beauty meets innovation. We are dedicated to providing the highest quality cosmetic products that enhance your natural beauty and boost your confidence.</p>
                    <p>Our carefully curated selection of products combines cutting-edge science with natural ingredients, ensuring that you get the best results without compromising on safety or efficacy.</p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/about-placeholder.jpg') }}" alt="About Us" class="img-fluid rounded shadow" onerror="this.src='https://via.placeholder.com/600x400?text=About+Us'">
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <div class="card border-success h-100">
                        <div class="card-body">
                            <div class="text-success mb-3">
                                <i class="fas fa-bullseye fa-3x"></i>
                            </div>
                            <h3 class="card-title">Our Mission</h3>
                            <p class="card-text">To empower individuals with high-quality, effective cosmetic products that celebrate their unique beauty while promoting confidence and self-expression.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card border-success h-100">
                        <div class="card-body">
                            <div class="text-success mb-3">
                                <i class="fas fa-eye fa-3x"></i>
                            </div>
                            <h3 class="card-title">Our Vision</h3>
                            <p class="card-text">To become the leading online destination for cosmetic products, known for our commitment to quality, innovation, and customer satisfaction.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Values -->
            <div class="row mb-5">
                <div class="col-12 mb-4">
                    <h2 class="text-center mb-4">Our Values</h2>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5>Quality</h5>
                        <p class="text-muted">Only the finest ingredients and formulations</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-leaf fa-3x text-success mb-3"></i>
                        <h5>Natural</h5>
                        <p class="text-muted">Eco-friendly and sustainable practices</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                        <h5>Safety</h5>
                        <p class="text-muted">Dermatologically tested and approved</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-heart fa-3x text-success mb-3"></i>
                        <h5>Care</h5>
                        <p class="text-muted">Passionate about customer satisfaction</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center bg-light p-5 rounded">
                <h3 class="mb-3">Ready to Transform Your Beauty Routine?</h3>
                <p class="lead mb-4">Explore our collection of premium cosmetic products</p>
                <a href="{{ route('products.index') }}" class="btn btn-success btn-lg">Shop Now</a>
            </div>
        @endif
    </div>
</section>
@endsection
