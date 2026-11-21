@extends('layouts.app')
@section('title', 'Our Clients')
@section('meta_description', 'Companies we have manufactured uniforms for.')
@push('styles')
<style>
  .logo-slider-track { display: flex; gap: 50px; align-items: center; animation: scrollLogos 30s linear infinite; width: max-content; }
  .logo-slider-track img { height: 60px; object-fit: contain; filter: grayscale(100%); opacity: 0.7; transition: all 0.3s ease; }
  .logo-slider-track img:hover { filter: grayscale(0%); opacity: 1; }
  @keyframes scrollLogos { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  .logo-slider-wrap { overflow: hidden; width: 100%; }
</style>
@endpush
@section('content')
<section class="section-py pt-5">
  <div class="container text-center mb-5" data-reveal="fade-up"><span class="section-label">Trusted By</span><h1 class="mt-2">Companies We Have Served</h1><p class="text-muted mt-2">Proudly manufacturing uniforms for businesses across industries.</p></div>
  @if ($clients->isEmpty())
    <p class="text-muted text-center">Client logos will appear here soon.</p>
  @else
    <div class="logo-slider-wrap" data-reveal="fade-up">
      <div class="logo-slider-track">
        @foreach ($clients->concat($clients) as $c)
          <img src="{{ $c->logo_path ? asset('storage/'.$c->logo_path) : 'https://placehold.co/140x60?text=' . urlencode($c->company_name) }}" alt="{{ $c->company_name }}" title="{{ $c->company_name }}">
        @endforeach
      </div>
    </div>
    <div class="container mt-5">
      <div class="row g-4">
        @foreach ($clients as $i => $c)
          <div class="col-lg-3 col-md-4 col-6 text-center" data-reveal="fade-up" data-reveal-delay="{{ $i % 4 * 60 }}">
            <div class="card p-3 h-100 d-flex align-items-center justify-content-center">
              <img src="{{ $c->logo_path ? asset('storage/'.$c->logo_path) : 'https://placehold.co/140x60?text=' . urlencode($c->company_name) }}" style="height:50px;object-fit:contain" alt="{{ $c->company_name }}">
              <div class="small text-muted mt-2">{{ $c->company_name }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</section>
@endsection
