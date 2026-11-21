@extends('layouts.admin')
@section('title', $order->order_number)
@section('content')
<h3 class="mb-4">{{ $order->order_number }}</h3>
<div class="row g-4">
  <div class="col-lg-7">
    <div class="card bg-white p-4 mb-3">
      <h5 class="mb-3">Customer & Order Info</h5>
      <p class="mb-1"><strong>Customer:</strong> {{ $order->user->company_name }} ({{ $order->user->email }})</p>
      <p class="mb-1"><strong>Product:</strong> {{ optional(optional($order->quotation)->product)->name ?? optional($order->quotation)->category ?? '-' }}</p>
      <p class="mb-1"><strong>Quantity:</strong> {{ optional($order->quotation)->quantity ?? '-' }}</p>
      <p class="mb-1"><strong>Total Amount:</strong> Rs. {{ number_format($order->total_amount) }}</p>
      <p class="mb-0"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
    </div>
    <div class="card bg-white p-4">
      <h5 class="mb-3">Status History</h5>
      @forelse ($order->statusHistory as $h)
        <div class="border-bottom py-2"><div class="fw-semibold">{{ \App\Models\Order::statusLabels()[$h->status] ?? ucfirst($h->status) }}</div><div class="small text-muted">{{ $h->created_at->format('d M Y, h:i A') }}</div>@if ($h->note)<div class="small mt-1">{{ $h->note }}</div>@endif</div>
      @empty <p class="text-muted small mb-0">No status history yet.</p> @endforelse
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card bg-white p-4">
      <h5 class="mb-3">Update Order</h5>
      <form method="POST" action="{{ route('admin.orders.update', $order) }}">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Status</label>
          <select name="status" class="form-select">
            @foreach (\App\Models\Order::statusSteps() as $s)<option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ \App\Models\Order::statusLabels()[$s] }}</option>@endforeach
          </select>
        </div>
        <div class="mb-3"><label class="form-label">Expected Delivery Date</label><input type="date" name="expected_delivery_date" class="form-control" value="{{ optional($order->expected_delivery_date)->format('Y-m-d') }}"></div>
        <div class="mb-3"><label class="form-label">Status Update Note</label><input type="text" name="status_note" class="form-control" placeholder="e.g. Fabric received from supplier"></div>
        <div class="mb-3"><label class="form-label">Internal Notes</label><textarea name="internal_notes" class="form-control" rows="2">{{ $order->internal_notes }}</textarea></div>
        <button type="submit" class="btn btn-dark w-100">Update Order</button>
      </form>
    </div>
  </div>
</div>
@endsection
