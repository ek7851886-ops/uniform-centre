@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<h3 class="mb-4">Dashboard</h3>
<div class="row g-3 mb-4">
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0">{{ $totalCustomers }}</h3><div class="small text-muted">Total Customers</div></div></div>
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0">{{ $totalQuoteRequests }}</h3><div class="small text-muted">Quote Requests</div></div></div>
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0 text-warning">{{ $pendingQuotes }}</h3><div class="small text-muted">Pending Quotes</div></div></div>
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0 text-success">{{ $approvedQuotes }}</h3><div class="small text-muted">Approved Quotes</div></div></div>
</div>
<div class="row g-3 mb-4">
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0">{{ $activeOrders }}</h3><div class="small text-muted">Active Orders</div></div></div>
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0">{{ $completedOrders }}</h3><div class="small text-muted">Completed Orders</div></div></div>
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0">{{ $totalProducts }}</h3><div class="small text-muted">Total Products</div></div></div>
  <div class="col-md-3 col-6"><div class="card p-3 text-center bg-white admin-stat-card"><h3 class="mb-0">{{ $totalClients }}</h3><div class="small text-muted">Total Clients</div></div></div>
</div>
<div class="card p-3 bg-white mb-4">
  <h5 class="mb-3">Quote Requests — Last 7 Days</h5>
  @if ($quotesLast7Days->isEmpty())<p class="text-muted small mb-0">No quote requests in the last 7 days yet.</p>
  @else
    <div class="d-flex align-items-end gap-2" style="height:120px">
      @php $max = $quotesLast7Days->max('total') ?: 1; @endphp
      @foreach ($quotesLast7Days as $day)
        <div class="text-center flex-fill"><div class="rounded-top mx-auto" style="width:100%; background: var(--gold); height:{{ max(6, ($day->total / $max) * 100) }}px"></div><div class="small text-muted mt-1">{{ \Carbon\Carbon::parse($day->day)->format('d M') }}</div></div>
      @endforeach
    </div>
  @endif
</div>
<div class="card p-3 bg-white mb-4">
  <div class="d-flex justify-content-between align-items-center mb-2"><h5 class="mb-0">Recent Quotations</h5><a href="{{ route('admin.quotations.index') }}" class="small">View all →</a></div>
  <table class="table table-sm">
    <thead><tr><th>Quote #</th><th>Company</th><th>Quantity</th><th>Status</th><th>Date</th></tr></thead>
    <tbody>
      @foreach ($recentQuotations as $q)
        <tr><td><a href="{{ route('admin.quotations.show', $q) }}">{{ $q->quote_number }}</a></td><td>{{ $q->company_name }}</td><td>{{ $q->quantity }}</td><td><span class="badge bg-{{ $q->statusBadgeClass() }}">{{ $q->statusLabel() }}</span></td><td>{{ $q->created_at->format('d M') }}</td></tr>
      @endforeach
    </tbody>
  </table>
</div>
@if ($unreadMessages > 0)
  <div class="card p-3 bg-white"><p class="mb-0">✉️ <strong>{{ $unreadMessages }}</strong> unread contact message{{ $unreadMessages === 1 ? '' : 's' }}. <a href="{{ route('admin.messages.index') }}">Review →</a></p></div>
@endif
@endsection
