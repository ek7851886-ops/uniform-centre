@extends('layouts.app')
@section('title', 'My Orders')
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="mb-4" data-reveal="fade-up"><span class="section-label">Orders</span><h2 class="mt-2">My Orders</h2></div>
    <div class="card p-3" data-reveal="fade-up">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead><tr><th>Order ID</th><th>Product</th><th>Total</th><th>Order Date</th><th>Delivery Date</th><th>Status</th><th></th></tr></thead>
          <tbody>
            @forelse ($orders as $o)
              <tr>
                <td>{{ $o->order_number }}</td>
                <td>{{ optional(optional($o->quotation)->product)->name ?? optional($o->quotation)->category ?? '-' }}</td>
                <td>Rs. {{ number_format($o->total_amount) }}</td>
                <td>{{ $o->created_at->format('d M Y') }}</td>
                <td>{{ optional($o->expected_delivery_date)->format('d M Y') ?? 'TBD' }}</td>
                <td><span class="badge bg-secondary">{{ $o->statusLabel() }}</span></td>
                <td><a href="{{ route('my-orders.show', $o) }}" class="btn btn-sm btn-outline-steel bg-navy">View</a></td>
              </tr>
            @empty <tr><td colspan="7" class="text-center text-muted py-4">No orders yet.</td></tr> @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
