@extends('layouts.app')
@section('title', 'My Quotations')
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="mb-4" data-reveal="fade-up"><span class="section-label">Quotations</span><h2 class="mt-2">My Quotations</h2></div>
    <div class="card p-3" data-reveal="fade-up">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead><tr><th>Quote ID</th><th>Product/Category</th><th>Quantity</th><th>Date</th><th>Status</th><th>Quoted Price</th><th></th></tr></thead>
          <tbody>
            @forelse ($quotations as $q)
              <tr>
                <td>{{ $q->quote_number }}</td>
                <td>{{ optional($q->product)->name ?? $q->category ?? '-' }}</td>
                <td>{{ $q->quantity }}</td>
                <td>{{ $q->created_at->format('d M Y') }}</td>
                <td><span class="badge bg-{{ $q->statusBadgeClass() }}">{{ $q->statusLabel() }}</span></td>
                <td>{{ $q->grand_total ? 'Rs. ' . number_format($q->grand_total) : '-' }}</td>
                <td><a href="{{ route('quotations.show', $q) }}" class="btn btn-sm btn-outline-steel bg-navy">View</a></td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-muted py-4">No quotations yet. <a href="{{ route('quotations.create') }}">Request one →</a></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
