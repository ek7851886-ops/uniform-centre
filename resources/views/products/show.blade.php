@extends('layouts.app')
@section('title', $product->name)
@section('meta_description', \Illuminate\Support\Str::limit($product->description, 150))
@section('content')
<div class="container section-py">
  <div class="row g-5">
    <div class="col-lg-6" data-reveal="fade-right">
      @php $images = $product->images; @endphp
      <div class="gallery-main mb-3" style="border-radius:8px; overflow:hidden; box-shadow: var(--shadow-md);">
        <img id="galleryMain" src="{{ $images->isNotEmpty() ? asset('storage/' . $images->first()->image_path) : 'https://placehold.co/700x550?text=Uniform' }}" class="img-fluid w-100" alt="{{ $product->name }}" style="height:460px;object-fit:cover;transition:opacity .25s ease">
      </div>
      @if ($images->count() > 1)
        <div class="d-flex flex-wrap gap-2">
          @foreach ($images as $i => $img)
            <img src="{{ asset('storage/' . $img->image_path) }}" data-full="{{ asset('storage/' . $img->image_path) }}" class="gallery-thumb" style="width:76px;height:76px;object-fit:cover;border-radius:6px;cursor:pointer;border:2px solid {{ $i === 0 ? 'var(--gold)' : 'transparent' }}" onclick="document.getElementById('galleryMain').src=this.dataset.full; document.querySelectorAll('.gallery-thumb').forEach(t=>t.style.borderColor='transparent'); this.style.borderColor='var(--gold)';" alt="{{ $product->name }} photo {{ $i + 1 }}">
          @endforeach
        </div>
      @endif
    </div>
    <div class="col-lg-6" data-reveal="fade-left">
      <span class="badge-custom">{{ optional($product->category)->name ?? 'Uniform' }}</span>
      <h1 class="h2 mt-3">{{ $product->name }}</h1>
      <p class="mt-2">{{ $product->description }}</p>
      <div class="row mt-4">
        @if ($product->fabric_options)<div class="col-6 mb-3"><div class="small text-muted mb-1">Fabric Options</div><div class="fw-semibold">{{ $product->fabric_options }}</div></div>@endif
        @if ($product->color_options)<div class="col-6 mb-3"><div class="small text-muted mb-1">Color Options</div><div class="fw-semibold">{{ $product->color_options }}</div></div>@endif
      </div>
      @if (!empty($product->customizationBadges()))
        <div class="mb-4">
          <div class="small text-muted mb-2">Available Customizations</div>
          <div class="d-flex flex-wrap gap-2">
            @foreach ($product->customizationBadges() as $badge)<span class="badge-custom">✓ {{ $badge }}</span>@endforeach
            <span class="badge-custom">✓ Custom Sizes</span>
          </div>
        </div>
      @endif
      <a href="{{ route('quotations.create', ['product_id' => $product->id]) }}" class="btn btn-gold btn-lg">Request Quote For This Uniform</a>
    </div>
  </div>
  @if ($related->isNotEmpty())
    <h4 class="mt-5 mb-4" data-reveal="fade-up">You may also like</h4>
    <div class="row g-4">
      @foreach ($related as $r)
        <div class="col-lg-3 col-md-6" data-reveal="fade-up">
          <div class="product-card">
            <img src="{{ optional($r->primaryImage())->image_path ? asset('storage/' . $r->primaryImage()->image_path) : 'https://placehold.co/400x300?text=Uniform' }}" alt="{{ $r->name }}">
            <div class="p-3"><h6 class="mb-2">{{ $r->name }}</h6><a href="{{ route('uniforms.show', $r->slug) }}" class="btn btn-sm btn-outline-steel bg-navy w-100">View</a></div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
