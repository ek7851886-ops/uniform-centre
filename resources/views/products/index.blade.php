@extends('layouts.app')
@section('title', 'Uniforms')
@section('meta_description', 'Browse corporate, industrial, security, hospitality and custom uniform categories.')
@section('content')
@if ($showCategoryCards)
<section class="section-py pt-5">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up"><span class="section-label">Uniform Categories</span><h2 class="mt-2">Browse by Category</h2></div>
    <div class="row g-4">
      @foreach ($categories as $i => $cat)
        <div class="col-lg-3 col-md-6" data-reveal="fade-up" data-reveal-delay="{{ $i * 60 }}">
          <div class="category-card">
            <div style="height:200px; background:linear-gradient(135deg, var(--navy), var(--steel-blue));"></div>
            <div class="overlay">
              <h6 class="mb-1">{{ $cat->name }}</h6>
              <p class="small mb-2 text-white-50">{{ \Illuminate\Support\Str::limit($cat->description, 60) }}</p>
              <a href="{{ route('uniforms.index', ['category' => $cat->slug]) }}" class="btn btn-sm btn-gold">View Collection</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="section-py {{ $showCategoryCards ? 'pt-0' : 'pt-5' }}">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up">
      <span class="section-label">Our Uniforms</span>
      <h2 class="mt-2">{{ $categorySlug ? $categories->firstWhere('slug', $categorySlug)?->name : 'All Uniforms' }}</h2>
    </div>
    <form method="GET" action="{{ route('uniforms.index') }}" class="row g-2 mb-4 justify-content-center">
      <div class="col-md-6"><input type="text" name="q" class="form-control" placeholder="Search uniforms..." value="{{ $search }}"></div>
      <input type="hidden" name="category" value="{{ $categorySlug }}">
      <div class="col-md-2"><button type="submit" class="btn btn-gold w-100">Search</button></div>
    </form>
    <div class="text-center mb-4">
      <a href="{{ route('uniforms.index') }}" class="btn btn-sm {{ $categorySlug === '' ? 'btn-gold' : 'btn-outline-steel' }} bg-navy me-2 mb-2">All</a>
      @foreach ($categories as $cat)
        <a href="{{ route('uniforms.index', ['category' => $cat->slug]) }}" class="btn btn-sm {{ $categorySlug === $cat->slug ? 'btn-gold' : 'btn-outline-steel' }} bg-navy me-2 mb-2">{{ $cat->name }} ({{ $cat->products_count }})</a>
      @endforeach
    </div>
    @if ($products->isEmpty())<p class="text-muted text-center">No uniforms found{{ $search ? ' for "' . $search . '"' : '' }}.</p>@endif
    <div class="row g-4">
      @foreach ($products as $i => $p)
        <div class="col-lg-3 col-md-6" data-reveal="fade-up" data-reveal-delay="{{ $i % 4 * 70 }}">
          <div class="product-card">
            <img src="{{ optional($p->primaryImage())->image_path ? asset('storage/' . $p->primaryImage()->image_path) : 'https://placehold.co/400x300?text=Uniform' }}" alt="{{ $p->name }}">
            <div class="p-3">
              <span class="badge-custom">{{ optional($p->category)->name ?? 'Uniform' }}</span>
              <h6 class="mt-2 mb-1">{{ $p->name }}</h6>
              <p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit($p->description, 70) }}</p>
              <div class="d-flex flex-wrap gap-1 mb-3">
                @foreach (array_slice($p->customizationBadges(), 0, 2) as $badge)<span class="badge-custom">{{ $badge }}</span>@endforeach
              </div>
              <div class="d-flex gap-2">
                <a href="{{ route('uniforms.show', $p->slug) }}" class="btn btn-sm btn-outline-steel bg-navy flex-fill">View Details</a>
                <a href="{{ route('quotations.create', ['product_id' => $p->id]) }}" class="btn btn-sm btn-gold flex-fill">Request Quote</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
