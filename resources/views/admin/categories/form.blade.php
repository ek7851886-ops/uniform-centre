@extends('layouts.admin')
@section('title', $category ? 'Edit Category' : 'Add Category')
@section('content')
<h3 class="mb-4">{{ $category ? 'Edit Category' : 'Add Category' }}</h3>
<div class="card bg-white p-4" style="max-width:600px">
  <form method="POST" action="{{ $category ? route('admin.categories.update', $category) : route('admin.categories.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($category) @method('PUT') @endif
    <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea></div>
    <div class="mb-3"><label class="form-label">Display Order</label><input type="number" name="display_order" class="form-control" value="{{ old('display_order', $category->display_order ?? 0) }}"></div>
    <div class="mb-3"><label class="form-label">Image</label><input type="file" name="image" class="form-control" accept="image/*">
      @if ($category && $category->image)<img src="{{ asset('storage/'.$category->image) }}" class="mt-2" style="height:70px;border-radius:6px">@endif
    </div>
    <div class="mb-3 form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}><label class="form-check-label" for="isActive">Active (visible on site)</label></div>
    <button type="submit" class="btn btn-dark">{{ $category ? 'Save Changes' : 'Add Category' }}</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
