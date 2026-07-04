@extends('layouts.frontend')

@section('title', $page->title)
@section('meta_description', $page->meta_description ?? strip_tags($page->content))
@section('meta_keywords', $page->meta_keywords)

@section('content')
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $page->title }}</li>
        </ol>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="fw-bold mb-4">{{ $page->title }}</h1>
                <div class="cms-content">
                    {!! nl2br(e($page->content)) !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
