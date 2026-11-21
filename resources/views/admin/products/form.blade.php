@extends('layouts.admin')
@section('title', $product ? 'Edit Product' : 'Add Product')
@section('content')
<h3 class="mb-4">{{ $product ? 'Edit Uniform' : 'Add New Uniform' }}</h3>
<div class="card bg-white p-4" style="max-width:750px">
  <form method="POST" action="{{ $product ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($product) @method('PUT') @endif
    <div class="mb-3"><label class="form-label">Uniform Name</label><input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required></div>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
          <option value="">-- None --</option>
          @foreach ($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
        </select>
      </div>
      <div class="col-md-6 mb-3"><label class="form-label">Fabric Options</label><input type="text" name="fabric_options" class="form-control" placeholder="e.g. Cotton Blend, Twill" value="{{ old('fabric_options', $product->fabric_options ?? '') }}"></div>
    </div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $product->description ?? '') }}</textarea></div>
    <div class="mb-3"><label class="form-label">Color Options</label><input type="text" name="color_options" class="form-control" placeholder="e.g. Navy, Charcoal, White" value="{{ old('color_options', $product->color_options ?? '') }}"></div>
    <div class="mb-3">
      <label class="form-label">Available Customizations</label>
      <div class="row">
        @php $selected = old('customization_options', $product->customization_options ?? []); @endphp
        @foreach ($customizationOptions as $key => $label)
          <div class="col-md-4 mb-2"><div class="form-check"><input class="form-check-input" type="checkbox" name="customization_options[]" value="{{ $key }}" id="cust_{{ $key }}" {{ in_array($key, $selected) ? 'checked' : '' }}><label class="form-check-label" for="cust_{{ $key }}">{{ $label }}</label></div></div>
        @endforeach
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Uniform Photos (select multiple)</label>
      <input type="file" name="images[]" id="productImages" class="form-control" accept="image/*" multiple>
      <div id="imagePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
    </div>
    @if ($product && $product->images->isNotEmpty())
      <div class="mb-3">
        <label class="form-label">Existing Photos</label>
        <div class="d-flex flex-wrap gap-2">
          @foreach ($product->images as $img)
            <div class="position-relative">
              <img src="{{ asset('storage/' . $img->image_path) }}" style="width:70px;height:70px;object-fit:cover;border-radius:6px;border:2px solid {{ $img->is_primary ? 'var(--gold)' : 'transparent' }}">
              <form action="{{ route('admin.products.deleteImage', $img) }}" method="POST" class="position-absolute top-0 end-0" style="margin:-6px">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm rounded-circle p-0" style="width:22px;height:22px;line-height:1">&times;</button></form>
            </div>
          @endforeach
        </div>
      </div>
    @endif
    <div class="mb-3 form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}><label class="form-check-label" for="isActive">Active (visible on site)</label></div>
    <button type="submit" class="btn btn-dark">{{ $product ? 'Save Changes' : 'Add Uniform' }}</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
