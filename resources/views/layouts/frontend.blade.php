<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home') - {{ config('app.name') }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Premium Cosmetic Products')">
    <meta name="keywords" content="@yield('meta_keywords', 'cosmetics, beauty, skincare')">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="{{ asset('storage/settings/site-favicon.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/frontend-style.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Top Bar -->
        <div class="top-bar bg-green-dark text-white py-2">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <small><i class="fas fa-envelope me-2"></i><a href="mailto:{{ App\Models\SiteSetting::get('contact_email', 'info@ippeo.in') }}" class="text-white text-decoration-none">{{ App\Models\SiteSetting::get('contact_email', 'info@ippeo.in') }}</a></small>
                        <small class="ms-3"><i class="fas fa-phone me-2"></i><a href="tel:{{ App\Models\SiteSetting::get('contact_phone', '+917498686978') }}" class="text-white text-decoration-none">{{ App\Models\SiteSetting::get('contact_phone', '+91 74986 86978') }}</a></small>
                    </div>
                    <div>
                        <a href="{{ App\Models\SiteSetting::get('facebook_url', '#') }}" class="text-white me-2" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="{{ App\Models\SiteSetting::get('instagram_url', '#') }}" class="text-white" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-green" href="{{ route('home') }}">
                    @php $logo = App\Models\SiteSetting::get('site_logo'); @endphp
                    @if($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="{{ config('app.name') }}" height="100" width="150" class="me-2">
                    @else
                        <i class="fas fa-leaf me-2"></i>{{ config('app.name') }}
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Mobile Offcanvas Menu -->
                <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="navbarOffcanvas" aria-labelledby="navbarOffcanvasLabel">
                    <div class="offcanvas-header bg-green-dark text-white">
                        <h5 class="offcanvas-title" id="navbarOffcanvasLabel">Menu</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body p-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a class="d-block px-4 py-3 border-bottom nav-link fw-medium" href="{{ route('home') }}">Home</a>
                            </li>
                            <li>
                                <a class="d-block px-4 py-3 border-bottom nav-link fw-medium" href="{{ route('products.index') }}">Products</a>
                            </li>
                            <li>
                                <a class="d-block px-4 py-3 border-bottom nav-link fw-medium" href="{{ route('blog.index') }}">Blog</a>
                            </li>
                            <li>
                                <a class="d-block px-4 py-3 border-bottom nav-link fw-medium" href="{{ route('about') }}">About</a>
                            </li>
                            <li>
                                <a class="d-block px-4 py-3 border-bottom nav-link fw-medium" href="{{ route('contact') }}">Contact</a>
                            </li>
                            <li>
                                <a class="d-block px-4 py-3 border-bottom nav-link fw-medium" href="{{ route('faq') }}">FAQ</a>
                            </li>
                        </ul>
                        <div class="p-4">
                            <form class="d-flex" action="{{ route('search') }}" method="GET" onsubmit="if(document.querySelector('.offcanvas.show')){bootstrap.Offcanvas.getInstance(document.getElementById('navbarOffcanvas')).hide()}">
                                <input class="form-control me-2 flex-grow-1" type="search" name="q" placeholder="Search products..." required>
                                <button class="btn btn-green" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
                        </li>
                    </ul>
                    <form class="d-flex ms-3" action="{{ route('search') }}" method="GET">
                        <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Search products..." required>
                        <button class="btn btn-green btn-sm" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer bg-green-dark text-white mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">{{ config('app.name') }}</h5>
                    <p>{{ App\Models\SiteSetting::get('footer_about', 'Premium natural cosmetic products for your beauty care.') }}</p>
                    <div class="social-links mt-3">
                        <a href="{{ App\Models\SiteSetting::get('facebook_url', '#') }}" class="text-white me-3" target="_blank"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="{{ App\Models\SiteSetting::get('instagram_url', '#') }}" class="text-white" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-6 col-md-2 mb-4">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-white-50">Products</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-white-50">Blog</a></li>
                        <li><a href="{{ route('about') }}" class="text-white-50">About Us</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-2 mb-4">
                    <h6 class="fw-bold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('contact') }}" class="text-white-50">Contact</a></li>
                        <li><a href="{{ route('faq') }}" class="text-white-50">FAQ</a></li>
                        <li><a href="{{ route('page.show', 'privacy-policy') }}" class="text-white-50">Privacy Policy</a></li>
                        <li><a href="{{ route('page.show', 'terms-conditions') }}" class="text-white-50">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold mb-3">Newsletter</h6>
                    <p class="small">Subscribe to get special offers and updates.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Your email" required>
                            <button class="btn btn-green-light" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 bg-white">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>
