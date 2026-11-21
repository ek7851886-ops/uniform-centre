@extends('layouts.app')
@section('title', 'Request a Quote')
@section('meta_description', 'Request a detailed quotation for custom uniforms.')
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up">
      <span class="section-label">Get a Quotation</span><h1 class="mt-2">Request a Quote</h1>
      <p class="text-muted mt-2">Tell us your requirements — we'll prepare a detailed quotation for your business.</p>
    </div>
    <form method="POST" action="{{ route('quotations.store') }}" enctype="multipart/form-data" class="mx-auto" style="max-width:840px" data-loading-text="Submitting..." data-reveal="fade-up">
      @csrf
      <div class="card p-4 mb-4">
        <h5 class="mb-3">Company Information</h5>
        <div class="row">
          <div class="col-md-6 mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name', auth()->user()->company_name ?? '') }}" required></div>
          <div class="col-md-6 mb-3"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', auth()->user()->contact_person ?? '') }}" required></div>
          <div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required></div>
          <div class="col-md-6 mb-3"><label class="form-label">Phone / WhatsApp</label><input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" required></div>
          <div class="col-12 mb-3"><label class="form-label">Company Address</label><textarea name="company_address" class="form-control" rows="2">{{ old('company_address') }}</textarea></div>
        </div>
      </div>

      <div class="card p-4 mb-4">
        <h5 class="mb-3">Uniform Requirements</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Uniform / Product</label>
            <select name="product_id" class="form-select">
              <option value="">-- Not sure / General --</option>
              @foreach ($products as $p)<option value="{{ $p->id }}" {{ (old('product_id', $selectedProduct?->id)) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
              <option value="">-- Select --</option>
              @foreach ($categories as $cat)<option value="{{ $cat->name }}" {{ old('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
            </select>
          </div>
          <div class="col-md-4 mb-3"><label class="form-label">Total Quantity</label><input type="number" name="quantity" min="1" class="form-control" value="{{ old('quantity', 1) }}" required></div>
          <div class="col-md-4 mb-3"><label class="form-label">Preferred Fabric</label><input type="text" name="preferred_fabric" class="form-control" value="{{ old('preferred_fabric') }}"></div>
          <div class="col-md-4 mb-3"><label class="form-label">Preferred Color</label><input type="text" name="preferred_color" class="form-control" value="{{ old('preferred_color') }}"></div>
        </div>
        <label class="form-label mt-2">Quantity per Size</label>
        <div class="row">
          @foreach ($sizeOptions as $s)
            <div class="col-4 col-md-2 mb-3"><label class="form-label small text-muted">{{ $s }}</label><input type="number" min="0" name="sizes[{{ $s }}]" class="form-control form-control-sm" value="{{ old('sizes.' . $s, 0) }}"></div>
          @endforeach
        </div>
        <div class="row">
          <div class="col-md-6 mb-3"><label class="form-label small text-muted">Custom Size Label</label><input type="text" name="custom_size_label" class="form-control form-control-sm" placeholder="e.g. 44in chest"></div>
          <div class="col-md-6 mb-3"><label class="form-label small text-muted">Custom Size Quantity</label><input type="number" min="0" name="custom_size_qty" class="form-control form-control-sm" value="0"></div>
        </div>
      </div>

      <div class="card p-4 mb-4">
        <h5 class="mb-3">Customization</h5>
        <div class="mb-3">
          <label class="form-label d-block">Logo Required?</label>
          <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="logo_required" value="yes" id="logoYes" {{ old('logo_required') === 'yes' ? 'checked' : '' }}><label class="form-check-label" for="logoYes">Yes</label></div>
          <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="logo_required" value="no" id="logoNo" {{ old('logo_required', 'no') === 'no' ? 'checked' : '' }}><label class="form-check-label" for="logoNo">No</label></div>
        </div>
        <div class="mb-3"><label class="form-label">Upload Company Logo <span class="text-muted small">(PNG, JPG, JPEG or PDF)</span></label><input type="file" name="logo" class="form-control" accept=".png,.jpg,.jpeg,.pdf"></div>
        <div class="row">
          @foreach (['embroidery_required'=>'Embroidery Required?','printing_required'=>'Printing Required?','reflective_strips_required'=>'Reflective Strips Required?','name_embroidery_required'=>'Name Embroidery Required?'] as $field => $label)
            <div class="col-md-6 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" name="{{ $field }}" value="yes" id="{{ $field }}" {{ old($field) === 'yes' ? 'checked' : '' }}><label class="form-check-label" for="{{ $field }}">{{ $label }}</label></div></div>
          @endforeach
        </div>
        <div class="mb-0 mt-2"><label class="form-label">Additional Requirements</label><textarea name="additional_requirements" class="form-control" rows="3">{{ old('additional_requirements') }}</textarea></div>
      </div>

      <div class="card p-4 mb-4">
        <h5 class="mb-3">Delivery Information</h5>
        <div class="row">
          <div class="col-md-4 mb-3"><label class="form-label">Required Delivery Date</label><input type="date" name="required_delivery_date" class="form-control" value="{{ old('required_delivery_date') }}"></div>
          <div class="col-md-4 mb-3"><label class="form-label">Delivery City</label><input type="text" name="delivery_city" class="form-control" value="{{ old('delivery_city', 'Karachi') }}"></div>
          <div class="col-md-4 mb-3"><label class="form-label">Delivery Address</label><input type="text" name="delivery_address" class="form-control" value="{{ old('delivery_address') }}"></div>
        </div>
      </div>
      <button type="submit" class="btn btn-gold btn-lg w-100">Send Quotation Request</button>
    </form>
  </div>
</section>
@endsection
