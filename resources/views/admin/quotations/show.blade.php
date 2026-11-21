@extends('layouts.admin')
@section('title', $quotation->quote_number)
@section('content')
<h3 class="mb-4">{{ $quotation->quote_number }}</h3>
<div class="row g-4">
  <div class="col-lg-7">
    <div class="card bg-white p-4 mb-3">
      <h5 class="mb-3">Company & Requirements</h5>
      <p class="mb-1"><strong>Company:</strong> {{ $quotation->company_name }} ({{ $quotation->contact_person }})</p>
      <p class="mb-1"><strong>Email / Phone:</strong> {{ $quotation->email }} / {{ $quotation->phone }}</p>
      <p class="mb-1"><strong>Address:</strong> {{ $quotation->company_address ?: '-' }}</p>
      <hr>
      <p class="mb-1"><strong>Product:</strong> {{ optional($quotation->product)->name ?? $quotation->category ?? '-' }}</p>
      <p class="mb-1"><strong>Quantity:</strong> {{ $quotation->quantity }}</p>
      <p class="mb-1"><strong>Fabric / Color:</strong> {{ $quotation->preferred_fabric ?: '-' }} / {{ $quotation->preferred_color ?: '-' }}</p>
      @if ($quotation->sizes)<p class="mb-1"><strong>Sizes:</strong> @foreach ($quotation->sizes as $s => $qty)<span class="badge bg-secondary me-1">{{ $s }}: {{ $qty }}</span>@endforeach</p>@endif
      <p class="mb-1"><strong>Logo:</strong> {{ $quotation->logo_required ? 'Required' : 'Not required' }} @if ($quotation->logo_path) — <a href="{{ asset('storage/'.$quotation->logo_path) }}" target="_blank">View uploaded logo</a> @endif</p>
      <p class="mb-1"><strong>Embroidery:</strong> {{ $quotation->embroidery_required?'Yes':'No' }} &middot; <strong>Printing:</strong> {{ $quotation->printing_required?'Yes':'No' }} &middot; <strong>Reflective:</strong> {{ $quotation->reflective_strips_required?'Yes':'No' }} &middot; <strong>Name Embroidery:</strong> {{ $quotation->name_embroidery_required?'Yes':'No' }}</p>
      @if ($quotation->additional_requirements)<p class="mb-0"><strong>Notes from customer:</strong> {{ $quotation->additional_requirements }}</p>@endif
    </div>
    <div class="card bg-white p-4">
      <h5 class="mb-3">Delivery</h5>
      <p class="mb-1"><strong>Required Date:</strong> {{ optional($quotation->required_delivery_date)->format('d M Y') ?? '-' }}</p>
      <p class="mb-1"><strong>City:</strong> {{ $quotation->delivery_city ?: '-' }}</p>
      <p class="mb-0"><strong>Address:</strong> {{ $quotation->delivery_address ?: '-' }}</p>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card bg-white p-4 mb-3">
      <h5 class="mb-3">Pricing & Status</h5>
      <form method="POST" action="{{ route('admin.quotations.update', $quotation) }}" id="pricingForm">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Status</label>
          <select name="status" class="form-select">
            @foreach (['pending'=>'Pending','under_review'=>'Under Review','quoted'=>'Quotation Sent','approved'=>'Approved','rejected'=>'Rejected'] as $val=>$label)
              <option value="{{ $val }}" {{ $quotation->status===$val?'selected':'' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="row">
          <div class="col-6 mb-2"><label class="form-label small">Price Per Unit</label><input type="number" step="0.01" name="price_per_unit" id="pricePerUnit" class="form-control pricing-input" value="{{ $quotation->price_per_unit }}"></div>
          <div class="col-6 mb-2"><label class="form-label small">Quantity</label><input type="text" class="form-control" value="{{ $quotation->quantity }}" disabled></div>
          <div class="col-6 mb-2"><label class="form-label small">Embroidery Charges</label><input type="number" step="0.01" name="embroidery_charges" class="form-control pricing-input" value="{{ $quotation->embroidery_charges }}"></div>
          <div class="col-6 mb-2"><label class="form-label small">Printing Charges</label><input type="number" step="0.01" name="printing_charges" class="form-control pricing-input" value="{{ $quotation->printing_charges }}"></div>
          <div class="col-6 mb-2"><label class="form-label small">Delivery Charges</label><input type="number" step="0.01" name="delivery_charges" class="form-control pricing-input" value="{{ $quotation->delivery_charges }}"></div>
          <div class="col-6 mb-2"><label class="form-label small">Other Charges</label><input type="number" step="0.01" name="other_charges" class="form-control pricing-input" value="{{ $quotation->other_charges }}"></div>
          <div class="col-6 mb-2"><label class="form-label small">Discount</label><input type="number" step="0.01" name="discount" class="form-control pricing-input" value="{{ $quotation->discount }}"></div>
          <div class="col-6 mb-2"><label class="form-label small">Grand Total</label><input type="text" id="grandTotalDisplay" class="form-control fw-bold" value="{{ number_format($quotation->grand_total ?? $quotation->calculateGrandTotal(), 2) }}" disabled></div>
        </div>
        <div class="mb-3"><label class="form-label small">Admin Notes (visible to customer)</label><textarea name="admin_notes" class="form-control" rows="2">{{ $quotation->admin_notes }}</textarea></div>
        <button type="submit" class="btn btn-dark w-100">Save & Send</button>
      </form>
    </div>
    @if ($quotation->status === 'approved' && !$quotation->order)
      <form action="{{ route('admin.quotations.convert', $quotation) }}" method="POST">@csrf<button type="submit" class="btn btn-success w-100">Convert to Order</button></form>
    @elseif ($quotation->order)
      <a href="{{ route('admin.orders.show', $quotation->order) }}" class="btn btn-outline-success w-100">View Order {{ $quotation->order->order_number }}</a>
    @endif
  </div>
</div>
@push('scripts')
<script>
  const qty = {{ (int) $quotation->quantity }};
  function recalcTotal() {
    const unit = parseFloat(document.getElementById('pricePerUnit').value) || 0;
    let total = unit * qty;
    document.querySelectorAll('.pricing-input').forEach(function (el) {
      if (el.id === 'pricePerUnit') return;
      const val = parseFloat(el.value) || 0;
      total += el.name === 'discount' ? -val : val;
    });
    document.getElementById('grandTotalDisplay').value = total.toFixed(2);
  }
  document.querySelectorAll('.pricing-input').forEach(el => el.addEventListener('input', recalcTotal));
</script>
@endpush
@endsection
