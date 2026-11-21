<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') - {{ \App\Models\Setting::get('company_name', 'Uniform Manufacturing Co.') }}</title>
<meta name="description" content="@yield('meta_description', 'Custom-made corporate, industrial and professional uniforms manufactured for businesses.')">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stack('styles')
</head>
<body>

<x-navbar />

@if (session('success'))
  <div class="container mt-5 pt-5"><div class="alert alert-success">{{ session('success') }}</div></div>
@endif
@if (session('info'))
  <div class="container mt-5 pt-5"><div class="alert alert-info">{{ session('info') }}</div></div>
@endif
@if ($errors->any())
  <div class="container {{ session('success') || session('info') ? '' : 'mt-5 pt-5' }}">
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  </div>
@endif

<main>
  @yield('content')
</main>

<x-footer />
<x-whatsapp-button />

<div class="lightbox-overlay" id="lightbox">
  <span class="lightbox-close">&times;</span>
  <img id="lightboxImg" src="" alt="">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
