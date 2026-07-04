@extends('layouts.frontend')

@section('title', 'FAQ')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-green-lightest">
    <div class="container">
        <h1 class="section-title mb-0">Frequently Asked Questions</h1>
        <p class="text-center text-muted">Find answers to common questions</p>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        @forelse($faqs as $category => $categoryFaqs)
        <div class="mb-5">
            @if($category)
            <h3 class="text-green mb-4">{{ $category }}</h3>
            @endif
            
            <div class="accordion" id="faqAccordion{{ $loop->index }}">
                @foreach($categoryFaqs as $faq)
                <div class="accordion-item border-0 shadow-sm mb-3">
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                         data-bs-parent="#faqAccordion{{ $loop->parent->index }}">
                        <div class="accordion-body">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="alert alert-info">No FAQs available at the moment.</div>
        @endforelse

        <!-- Contact CTA -->
        <div class="card bg-green text-white mt-5">
            <div class="card-body text-center py-5">
                <h3 class="mb-3">Still have questions?</h3>
                <p class="mb-4">Feel free to contact us and we'll be happy to help!</p>
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5">Contact Us</a>
            </div>
        </div>
    </div>
</section>
@endsection
