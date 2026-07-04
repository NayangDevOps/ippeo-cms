@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-green-lightest">
    <div class="container">
        <h1 class="section-title mb-0">Contact Us</h1>
        <p class="text-center text-muted">We'd love to hear from you</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Send us a Message</h3>
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subject *</label>
                                    <input type="text" name="subject" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message *</label>
                                <textarea name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-green btn-lg px-5">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4"><i class="fas fa-map-marker-alt text-green me-2"></i>Address</h5>
                        <p>{!! nl2br(e(App\Models\SiteSetting::get('contact_address', '123 Beauty Street, City, Country'))) !!}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><i class="fas fa-phone text-green me-2"></i>Phone</h5>
                        <p class="mb-0">{{ App\Models\SiteSetting::get('contact_phone', '+1 234 567 890') }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><i class="fas fa-envelope text-green me-2"></i>Email</h5>
                        <p class="mb-0">{{ App\Models\SiteSetting::get('contact_email', 'info@cosmetic.com') }}</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><i class="fas fa-clock text-green me-2"></i>Working Hours</h5>
                        <p class="mb-1"><strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM</p>
                        <p class="mb-0"><strong>Saturday - Sunday:</strong> 10:00 AM - 4:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
