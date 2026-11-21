@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="mb-4" data-reveal="fade-up"><span class="section-label">Dashboard</span><h2 class="mt-2">Welcome, {{ $user->company_name }}</h2></div>
    <div class="row g-4 mb-5">
      <div class="col-md-3 col-6" data-reveal="fade-up"><div class="card p-3 text-center h-100"><div class="counter-value">{{ $pendingQuotations }}</div><div class="small text-muted">Pending Quotations</div></div></div>
      <div class="col-md-3 col-6" data-reveal="fade-up" data-reveal-delay="80"><div class="card p-3 text-center h-100"><div class="counter-value">{{ $approvedQuotations }}</div><div class="small text-muted">Approved Quotations</div></div></div>
      <div class="col-md-3 col-6" data-reveal="fade-up" data-reveal-delay="160"><div class="card p-3 text-center h-100"><div class="counter-value">{{ $activeOrders }}</div><div class="small text-muted">Active Orders</div></div></div>
      <div class="col-md-3 col-6" data-reveal="fade-up" data-reveal-delay="240"><div class="card p-3 text-center h-100"><div class="counter-value">{{ $completedOrders }}</div><div class="small text-muted">Completed Orders</div></div></div>
    </div>
    <div class="d-flex flex-wrap gap-3 mb-5" data-reveal="fade-up">
      <a href="{{ route('quotations.create') }}" class="btn btn-gold">Request New Quote</a>
      <a href="{{ route('quotations.index') }}" class="btn btn-outline-steel bg-navy">My Quotations</a>
      <a href="{{ route('my-orders.index') }}" class="btn btn-outline-steel bg-navy">My Orders</a>
      <a href="{{ route('profile.edit') }}" class="btn btn-outline-steel bg-navy">My Profile</a>
    </div>
    <div class="row g-4">
      <div class="col-lg-6" data-reveal="fade-up">
        <div class="card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Recent Quotations</h5><a href="{{ route('quotations.index') }}" class="small">View all →</a></div>
          @forelse ($recentQuotations as $q)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
              <div><a href="{{ route('quotations.show', $q) }}" class="fw-semibold">{{ $q->quote_number }}</a><div class="small text-muted">{{ $q->created_at->format('d M Y') }} &middot; Qty: {{ $q->quantity }}</div></div>
              <span class="badge bg-{{ $q->statusBadgeClass() }}">{{ $q->statusLabel() }}</span>
            </div>
          @empty <p class="text-muted small mb-0">No quotations yet.</p> @endforelse
        </div>
      </div>
      <div class="col-lg-6" data-reveal="fade-up" data-reveal-delay="120">
        <div class="card p-4 h-100">
          <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Recent Orders</h5><a href="{{ route('my-orders.index') }}" class="small">View all →</a></div>
          @forelse ($recentOrders as $o)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
              <div><span class="fw-semibold">{{ $o->order_number }}</span><div class="small text-muted">{{ $o->created_at->format('d M Y') }}</div></div>
              <span class="badge bg-secondary">{{ $o->statusLabel() }}</span>
            </div>
          @empty <p class="text-muted small mb-0">No orders yet.</p> @endforelse
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
