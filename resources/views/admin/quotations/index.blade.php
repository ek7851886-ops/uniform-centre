@extends('layouts.admin')
@section('title', 'Quotations')
@section('content')
<h3 class="mb-4">Quotation Requests</h3>
<form method="GET" class="row g-2 mb-3">
  <div class="col-md-4"><input type="text" name="q" class="form-control" placeholder="Search by quote # or company..." value="{{ $search }}"></div>
  <input type="hidden" name="status" value="{{ $status }}">
  <div class="col-md-2"><button type="submit" class="btn btn-outline-secondary w-100">Search</button></div>
</form>
<div class="mb-3">
  <a href="{{ route('admin.quotations.index') }}" class="btn btn-sm {{ $status==='' ? 'btn-dark':'btn-outline-dark' }} me-2 mb-2">All</a>
  @foreach (['pending','under_review','quoted','approved','rejected'] as $s)
    <a href="{{ route('admin.quotations.index', ['status'=>$s]) }}" class="btn btn-sm {{ $status===$s ? 'btn-dark':'btn-outline-dark' }} me-2 mb-2">{{ ucfirst(str_replace('_',' ',$s)) }}</a>
  @endforeach
</div>
<div class="card bg-white p-3">
  <div class="table-responsive"><table class="table align-middle">
    <thead><tr><th>Quote #</th><th>Company</th><th>Quantity</th><th>Status</th><th>Grand Total</th><th>Date</th><th></th></tr></thead>
    <tbody>
      @forelse ($quotations as $q)
        <tr><td>{{ $q->quote_number }}</td><td>{{ $q->company_name }}</td><td>{{ $q->quantity }}</td><td><span class="badge bg-{{ $q->statusBadgeClass() }}">{{ $q->statusLabel() }}</span></td><td>{{ $q->grand_total ? 'Rs. '.number_format($q->grand_total) : '-' }}</td><td>{{ $q->created_at->format('d M Y') }}</td><td><a href="{{ route('admin.quotations.show', $q) }}" class="btn btn-sm btn-outline-primary">Manage</a></td></tr>
      @empty <tr><td colspan="7" class="text-center text-muted py-3">No quotations found.</td></tr> @endforelse
    </tbody>
  </table></div>
  <div class="mt-2">{{ $quotations->links() }}</div>
</div>
@endsection
