@extends('layouts.app')
@section('title', 'Our Work')
@section('meta_description', 'Examples of our uniform manufacturing work — corporate, industrial, embroidery, hospitality and security uniforms.')
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up"><span class="section-label">Portfolio</span><h1 class="mt-2">Our Work</h1></div>
    <div class="text-center mb-4">
      @foreach ($categories as $cat)
        <a href="{{ route('portfolio.index', ['category' => $cat]) }}" class="btn btn-sm {{ ($category === $cat) || ($category === '' && $cat === 'All') ? 'btn-gold' : 'btn-outline-steel' }} bg-navy me-2 mb-2">{{ $cat }}</a>
      @endforeach
    </div>
    @if ($items->isEmpty())<p class="text-muted text-center">No portfolio items to show yet.</p>@endif
    <div class="row g-3">
      @foreach ($items as $i => $item)
        <div class="col-lg-4 col-md-6" data-reveal="fade-up" data-reveal-delay="{{ $i % 3 * 70 }}">
          <a href="#" data-lightbox="{{ asset('storage/' . $item->image_path) }}" class="d-block position-relative overflow-hidden rounded" style="cursor:zoom-in">
            <img src="{{ asset('storage/' . $item->image_path) }}" class="img-fluid w-100" style="height:280px;object-fit:cover;transition:transform .4s ease" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'" alt="{{ $item->title }}">
            <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background:linear-gradient(to top, rgba(10,20,32,0.85), transparent)">
              <span class="badge-custom">{{ $item->category }}</span>
              <div class="text-white fw-semibold mt-1">{{ $item->title }}</div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
