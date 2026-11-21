@extends('layouts.app')
@section('title', 'Home')
@section('meta_description', 'Professional uniforms manufactured for corporate, industrial, security and hospitality businesses.')

@section('content')
<section class="hero-section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-reveal="fade-right">
        <span class="section-label">Custom Uniform Manufacturing</span>
        <h1 class="mt-3 mb-4">Professional Uniforms. Made for Your Business.</h1>
        <p class="lead">Custom-made corporate, industrial and professional uniforms designed for your workforce.</p>
        <div class="mt-4 d-flex flex-wrap gap-3">
          <a href="{{ route('quotations.create') }}" class="btn btn-gold btn-lg">Request a Quote</a>
          <a href="{{ route('uniforms.index') }}" class="btn btn-outline-steel btn-lg">Explore Uniforms</a>
        </div>
      </div>
      <div class="col-lg-6" data-reveal="fade-left" data-reveal-delay="150">
        <div class="hero-image-wrap">
          <img src="{{ asset('images/hero-uniform.jpg') }}" alt="Professional workwear" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-py">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up">
      <span class="section-label">Why Choose Us</span>
      <h2 class="mt-2">Built for Businesses That Need It Right</h2>
    </div>
    <div class="row g-4">
      @foreach ($features as $i => $f)
        <div class="col-lg-3 col-md-6" data-reveal="fade-up" data-reveal-delay="{{ $i * 80 }}">
          <div class="feature-card">
            <div class="icon-wrap">{{ $f['icon'] }}</div>
            <h5>{{ $f['title'] }}</h5>
            <p class="text-muted small mb-0">{{ $f['desc'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="section-py bg-navy text-white">
  <div class="container text-center" data-reveal="fade-up">
    <span class="section-label">Get Started</span>
    <h2 class="mt-2 mb-3">Ready to Outfit Your Team?</h2>
    <p class="text-white-50 mb-4">Tell us what you need — we'll put together a detailed quotation for your business.</p>
    <a href="{{ route('quotations.create') }}" class="btn btn-gold btn-lg">Request a Quote</a>
  </div>
</section>
@endsection
