@extends('layouts.app')
@section('title', 'Customize Your Uniform')
@section('meta_description', 'See how businesses can customize uniforms with logo embroidery, fabric, color and size options.')
@section('content')
<section class="section-py pt-5">
  <div class="container text-center mb-5" data-reveal="fade-up">
    <span class="section-label">Made to Your Brand</span>
    <h1 class="mt-2">Customize Your Uniform</h1>
    <p class="text-muted mt-3 mx-auto" style="max-width:640px">Every business is different — that's why every uniform we manufacture can be tailored to your brand, your team, and your environment.</p>
  </div>
</section>
@foreach ($sections as $i => $s)
  <section class="section-py pt-0">
    <div class="container">
      <div class="row align-items-center g-5 {{ $i % 2 === 1 ? 'flex-row-reverse' : '' }}">
        <div class="col-lg-6" data-reveal="{{ $i % 2 === 1 ? 'fade-left' : 'fade-right' }}"><img src="{{ asset('storage/' . $s['image']) }}" alt="{{ $s['title'] }}" class="img-fluid rounded shadow-sm"></div>
        <div class="col-lg-6" data-reveal="{{ $i % 2 === 1 ? 'fade-right' : 'fade-left' }}">
          <span class="section-label">Customization 0{{ $i + 1 }}</span>
          <h3 class="mt-2 mb-3">{{ $s['title'] }}</h3>
          <p class="text-muted">{{ $s['desc'] }}</p>
        </div>
      </div>
    </div>
  </section>
@endforeach
<section class="section-py bg-navy text-white">
  <div class="container text-center" data-reveal="fade-up">
    <h2 class="mb-3">Ready to Customize Your Team's Uniform?</h2>
    <a href="{{ route('quotations.create') }}" class="btn btn-gold btn-lg">Request a Quote</a>
  </div>
</section>
@endsection
