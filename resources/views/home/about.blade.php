@extends('layouts.app')
@section('title', 'About Us')
@section('meta_description', 'About Uniform Manufacturing Co. — experienced manufacturers of corporate, industrial and hospitality uniforms.')
@section('content')
<section class="hero-section" style="padding: 150px 0 90px;">
  <div class="container text-center" data-reveal="fade-up">
    <span class="section-label">About Us</span>
    <h1 class="mt-3">Uniforms Built on Experience</h1>
    <p class="lead mx-auto">Over a decade of manufacturing quality uniforms for businesses across industries.</p>
  </div>
</section>

<section class="section-py">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6" data-reveal="fade-right"><img src="{{ asset('storage/products/hospitality-uniform-set.jpg') }}" alt="Our uniforms" class="img-fluid rounded shadow-sm"></div>
      <div class="col-lg-6" data-reveal="fade-left">
        <span class="section-label">Who We Are</span>
        <h2 class="mt-2 mb-3">A Trusted Manufacturing Partner</h2>
        <p class="text-muted">We manufacture custom uniforms for corporate offices, industrial facilities, security firms, malls, hotels and restaurants. Every uniform is made to order — sized, colored, and branded to match exactly what your business needs.</p>
        <span class="section-label">What We Do</span>
        <p class="text-muted mt-2">From a single sample piece to bulk orders of thousands, we handle fabric sourcing, cutting, stitching, embroidery, printing and quality control in-house — so you deal with one team from quote to delivery.</p>
      </div>
    </div>
  </div>
</section>

<section class="section-py bg-navy text-white">
  <div class="container">
    <div class="row text-center g-4">
      @foreach ($stats as $s)
        <div class="col-md-3 col-6" data-reveal="fade-up">
          <div class="counter-value text-white" data-counter="{{ $s['value'] }}" data-suffix="{{ $s['suffix'] }}">0</div>
          <div class="small text-white-50 mt-1">{{ $s['label'] }}</div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="section-py">
  <div class="container">
    <div class="row g-5 align-items-center flex-row-reverse">
      <div class="col-lg-6" data-reveal="fade-left"><img src="{{ asset('storage/products/embroidery-design-continental.jpg') }}" alt="Our process" class="img-fluid rounded shadow-sm"></div>
      <div class="col-lg-6" data-reveal="fade-right">
        <span class="section-label">Our Manufacturing Process</span>
        <h2 class="mt-2 mb-3">From Quote to Delivery</h2>
        <p class="text-muted">Request a quote → we confirm fabric, sizes and customization → cutting and stitching → embroidery or printing → quality check → delivery to your doorstep, with status updates at every step.</p>
        <span class="section-label">Our Mission</span>
        <p class="text-muted mt-2">To make outfitting a workforce simple — reliable quality, honest pricing, and on-time delivery, every time.</p>
      </div>
    </div>
  </div>
</section>

<section class="section-py">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up"><span class="section-label">Why Businesses Choose Us</span><h2 class="mt-2">Built for Businesses That Need It Right</h2></div>
    <div class="row g-4">
      @foreach ($features as $i => $f)
        <div class="col-lg-3 col-md-6" data-reveal="fade-up" data-reveal-delay="{{ $i * 80 }}">
          <div class="feature-card"><div class="icon-wrap">{{ $f['icon'] }}</div><h5>{{ $f['title'] }}</h5><p class="text-muted small mb-0">{{ $f['desc'] }}</p></div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="section-py bg-navy text-white">
  <div class="container text-center" data-reveal="fade-up"><h2 class="mb-3">Ready to Outfit Your Team?</h2><a href="{{ route('quotations.create') }}" class="btn btn-gold btn-lg">Request a Quote</a></div>
</section>
@endsection
