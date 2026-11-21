@extends('layouts.app')
@section('title', 'Track Your Order')
@section('meta_description', 'Track your uniform order status by order number.')
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up"><span class="section-label">Order Status</span><h1 class="mt-2">Track Your Order</h1><p class="text-muted mt-2">Enter your order number and the email used when registering.</p></div>
    <form method="POST" action="{{ route('orders.track.post') }}" class="row g-2 justify-content-center mb-5" data-reveal="fade-up">
      @csrf
      <div class="col-md-4"><input type="text" name="order_number" class="form-control" placeholder="Order Number (e.g. ORD-2026-00001)" value="{{ old('order_number') }}" required></div>
      <div class="col-md-4"><input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required></div>
      <div class="col-md-2"><button type="submit" class="btn btn-gold w-100">Track</button></div>
    </form>
    @if ($notFound)<div class="alert alert-warning mx-auto text-center" style="max-width:500px">No matching order found. Please check your order number and email.</div>@endif
    @if ($order)
      <div class="card p-4 mx-auto" style="max-width:800px" data-reveal="fade-up">
        <div class="d-flex justify-content-between align-items-center mb-4"><h4 class="mb-0">{{ $order->order_number }}</h4><span class="badge bg-secondary">{{ $order->statusLabel() }}</span></div>
        <x-order-timeline :order="$order" />
        <div class="row mt-4">
          <div class="col-md-6 mb-2"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</div>
          <div class="col-md-6 mb-2"><strong>Expected Delivery:</strong> {{ optional($order->expected_delivery_date)->format('d M Y') ?? 'TBD' }}</div>
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
