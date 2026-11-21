@extends('layouts.admin')
@section('title', 'Orders')
@section('content')
<h3 class="mb-4">Orders</h3>
<div class="mb-3">
  <a href="{{ route('admin.orders.index') }}" class="btn btn-sm {{ $status==='' ? 'btn-dark':'btn-outline-dark' }} me-2 mb-2">All</a>
  @foreach (\App\Models\Order::statusSteps() as $s)
    <a href="{{ route('admin.orders.index', ['status'=>$s]) }}" class="btn btn-sm {{ $status===$s ? 'btn-dark':'btn-outline-dark' }} me-2 mb-2">{{ \App\Models\Order::statusLabels()[$s] }}</a>
  @endforeach
</div>
<div class="card bg-white p-3">
  <div class="table-responsive"><table class="table align-middle">
    <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Expected Delivery</th><th></th></tr></thead>
    <tbody>
      @forelse ($orders as $o)
        <tr><td>{{ $o->order_number }}</td><td>{{ $o->user->company_name }}</td><td>Rs. {{ number_format($o->total_amount) }}</td><td><span class="badge bg-secondary">{{ $o->statusLabel() }}</span></td><td>{{ optional($o->expected_delivery_date)->format('d M Y') ?? '-' }}</td><td><a href="{{ route('admin.orders.show', $o) }}" class="btn btn-sm btn-outline-primary">Manage</a></td></tr>
      @empty <tr><td colspan="6" class="text-center text-muted py-3">No orders found.</td></tr> @endforelse
    </tbody>
  </table></div>
  <div class="mt-2">{{ $orders->links() }}</div>
</div>
@endsection
