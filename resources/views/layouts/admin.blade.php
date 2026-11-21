<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') - Admin | {{ \App\Models\Setting::get('company_name', 'Uniform Manufacturing Co.') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-light">

<div class="d-flex">
  <div class="admin-sidebar">
    <div class="admin-sidebar-brand">
      ✂ {{ \App\Models\Setting::get('company_name', 'Uniform Mfg. Co.') }}
    </div>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
    <a href="{{ route('admin.quotations.index') }}" class="{{ request()->routeIs('admin.quotations.*') ? 'active' : '' }}">📝 Quotations</a>
    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">📦 Orders</a>
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">👕 Products</a>
    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">🗂 Categories</a>
    <a href="{{ route('admin.clients.index') }}" class="{{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">🏢 Clients</a>
    <a href="{{ route('admin.portfolio.index') }}" class="{{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">🖼 Portfolio</a>
    <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">✉️ Messages</a>
    <a href="{{ route('admin.settings.edit') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">⚙️ Settings</a>
    <a href="{{ route('home') }}" target="_blank">🌐 View Site</a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="admin-sidebar-logout">🚪 Logout</button>
    </form>
  </div>

  <div class="flex-grow-1 p-4">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if (session('info'))
      <div class="alert alert-info alert-dismissible fade show">{{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    @yield('content')
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
