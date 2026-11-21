@extends('layouts.app')
@section('title', 'Quotation ' . $quotation->quote_number)
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4" data-reveal="fade-up">
      <div><span class="section-label">Quotation Detail</span><h2 class="mt-2">{{ $quotation->quote_number }}</h2></div>
      <span class="badge bg-{{ $quotation->statusBadgeClass() }} fs-6">{{ $quotation->statusLabel() }}</span>
    </div>
    <div class="row g-4">
      <div class="col-lg-7" data-reveal="fade-up">
        <div class="card p-4 mb-4">
          <h5 class="mb-3">Requirements</h5>
          <p class="mb-1"><strong>Product/Category:</strong> {{ optional($quotation->product)->name ?? $quotation->category ?? '-' }}</p>
          <p class="mb-1"><strong>Quantity:</strong> {{ $quotation->quantity }}</p>
          <p class="mb-1"><strong>Fabric:</strong> {{ $quotation->preferred_fabric ?: '-' }}</p>
          <p class="mb-1"><strong>Color:</strong> {{ $quotation->preferred_color ?: '-' }}</p>
          @if ($quotation->sizes)<p class="mb-1"><strong>Sizes:</strong> @foreach ($quotation->sizes as $size => $qty)<span class="badge-custom me-1">{{ $size }}: {{ $qty }}</span>@endforeach</p>@endif
          <p class="mb-1"><strong>Logo Required:</strong> {{ $quotation->logo_required ? 'Yes' : 'No' }} @if ($quotation->logo_path) — <a href="{{ asset('storage/' . $quotation->logo_path) }}" target="_blank">View Logo</a> @endif</p>
          <p class="mb-1"><strong>Embroidery:</strong> {{ $quotation->embroidery_required ? 'Yes' : 'No' }} &middot; <strong>Printing:</strong> {{ $quotation->printing_required ? 'Yes' : 'No' }} &middot; <strong>Reflective:</strong> {{ $quotation->reflective_strips_required ? 'Yes' : 'No' }} &middot; <strong>Name Embroidery:</strong> {{ $quotation->name_embroidery_required ? 'Yes' : 'No' }}</p>
          @if ($quotation->additional_requirements)<p class="mb-0"><strong>Additional Requirements:</strong> {{ $quotation->additional_requirements }}</p>@endif
        </div>
        <div class="card p-4">
          <h5 class="mb-3">Delivery</h5>
          <p class="mb-1"><strong>Required Date:</strong> {{ optional($quotation->required_delivery_date)->format('d M Y') ?? '-' }}</p>
          <p class="mb-1"><strong>City:</strong> {{ $quotation->delivery_city ?: '-' }}</p>
          <p class="mb-0"><strong>Address:</strong> {{ $quotation->delivery_address ?: '-' }}</p>
        </div>
      </div>
      <div class="col-lg-5" data-reveal="fade-up" data-reveal-delay="100">
        @if ($quotation->status === 'quoted' || $quotation->status === 'approved')
          <div class="card p-4 mb-4">
            <h5 class="mb-3">Pricing</h5>
            <table class="table table-sm">
              <tr><td>Price Per Unit</td><td class="text-end">Rs. {{ number_format($quotation->price_per_unit ?? 0) }}</td></tr>
              <tr><td>Quantity</td><td class="text-end">{{ $quotation->quantity }}</td></tr>
              <tr><td>Subtotal</td><td class="text-end">Rs. {{ number_format($quotation->subtotal()) }}</td></tr>
              <tr><td>Embroidery Charges</td><td class="text-end">Rs. {{ number_format($quotation->embroidery_charges) }}</td></tr>
              <tr><td>Printing Charges</td><td class="text-end">Rs. {{ number_format($quotation->printing_charges) }}</td></tr>
              <tr><td>Delivery Charges</td><td class="text-end">Rs. {{ number_format($quotation->delivery_charges) }}</td></tr>
              <tr><td>Other Charges</td><td class="text-end">Rs. {{ number_format($quotation->other_charges) }}</td></tr>
              <tr><td>Discount</td><td class="text-end">- Rs. {{ number_format($quotation->discount) }}</td></tr>
              <tr class="fw-bold border-top"><td>Grand Total</td><td class="text-end">Rs. {{ number_format($quotation->grand_total ?? $quotation->calculateGrandTotal()) }}</td></tr>
            </table>
            @if ($quotation->admin_notes)<p class="small text-muted mt-2 mb-0"><strong>Note from our team:</strong> {{ $quotation->admin_notes }}</p>@endif
          </div>
          @if ($quotation->status === 'quoted')
            <div class="d-flex gap-3">
              <form action="{{ route('quotations.approve', $quotation) }}" method="POST" class="flex-fill">@csrf<button type="submit" class="btn btn-gold w-100">Approve Quotation</button></form>
              <form action="{{ route('quotations.reject', $quotation) }}" method="POST" class="flex-fill">@csrf<button type="submit" class="btn btn-outline-steel bg-navy w-100">Reject</button></form>
            </div>
          @elseif ($quotation->status === 'approved')
            <div class="alert alert-success mb-0">Approved — our team will convert this into an order shortly.</div>
          @endif
        @else
          <div class="card p-4"><p class="text-muted mb-0">Our team is reviewing your request. Pricing will appear here once a quotation has been prepared.</p></div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
