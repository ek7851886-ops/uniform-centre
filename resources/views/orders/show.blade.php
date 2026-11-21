@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4" data-reveal="fade-up"><h2 class="mb-0">{{ $order->order_number }}</h2><span class="badge bg-secondary fs-6">{{ $order->statusLabel() }}</span></div>
    <div class="card p-4 mb-4" data-reveal="fade-up"><x-order-timeline :order="$order" /></div>
    <div class="row g-4">
      <div class="col-lg-6" data-reveal="fade-up">
        <div class="card p-4 h-100">
          <h5 class="mb-3">Order Summary</h5>
          <p class="mb-1"><strong>Product/Category:</strong> {{ optional(optional($order->quotation)->product)->name ?? optional($order->quotation)->category ?? '-' }}</p>
          <p class="mb-1"><strong>Quantity:</strong> {{ optional($order->quotation)->quantity ?? '-' }}</p>
          <p class="mb-1"><strong>Total Amount:</strong> Rs. {{ number_format($order->total_amount) }}</p>
          <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
          <p class="mb-0"><strong>Expected Delivery:</strong> {{ optional($order->expected_delivery_date)->format('d M Y') ?? 'TBD' }}</p>
        </div>
      </div>
      <div class="col-lg-6" data-reveal="fade-up" data-reveal-delay="100">
        <div class="card p-4 h-100">
          <h5 class="mb-3">Status History</h5>
          @forelse ($order->statusHistory as $h)
            <div class="border-bottom py-2"><div class="fw-semibold">{{ \App\Models\Order::statusLabels()[$h->status] ?? ucfirst($h->status) }}</div><div class="small text-muted">{{ $h->created_at->format('d M Y, h:i A') }}</div>@if ($h->note)<div class="small mt-1">{{ $h->note }}</div>@endif</div>
          @empty <p class="text-muted small mb-0">No status updates recorded yet.</p> @endforelse
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
