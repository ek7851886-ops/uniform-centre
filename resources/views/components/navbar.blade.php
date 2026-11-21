<nav class="navbar navbar-expand-lg site-navbar fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      {{ \App\Models\Setting::get('company_name', 'Uniform Manufacturing Co.') }}
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('uniforms.*') ? 'active' : '' }}" href="{{ route('uniforms.index') }}">Uniforms</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}" href="{{ route('portfolio.index') }}">Our Work</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('customization.*') ? 'active' : '' }}" href="{{ route('customization.index') }}">Customization</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">Clients</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('orders.track') ? 'active' : '' }}" href="{{ route('orders.track') }}">Track Order</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">Contact</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        @auth
          <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="btn btn-outline-steel btn-sm">Dashboard</a>
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-steel btn-sm">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-outline-steel btn-sm">Login</a>
        @endauth
        <a href="{{ route('quotations.create') }}" class="btn btn-gold btn-sm">Request a Quote</a>
      </div>
    </div>
  </div>
</nav>
