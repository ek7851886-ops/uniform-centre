@extends('layouts.admin')
@section('title', $item ? 'Edit Portfolio Item' : 'Add Portfolio Item')
@section('content')
<h3 class="mb-4">{{ $item ? 'Edit Portfolio Item' : 'Add Portfolio Item' }}</h3>
<div class="card bg-white p-4" style="max-width:600px">
  <form method="POST" action="{{ $item ? route('admin.portfolio.update', $item) : route('admin.portfolio.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif
    <div class="mb-3"><label class="form-label">Title</label><input type="text" name="title" class="form-control" value="{{ old('title', $item->title ?? '') }}" required></div>
    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category" class="form-select" required>
        @foreach ($categories as $cat)<option value="{{ $cat }}" {{ old('category', $item->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>@endforeach
      </select>
    </div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ old('description', $item->description ?? '') }}</textarea></div>
    <div class="mb-3"><label class="form-label">Client Name (optional)</label><input type="text" name="client_name" class="form-control" value="{{ old('client_name', $item->client_name ?? '') }}"></div>
    <div class="mb-3"><label class="form-label">Photo</label><input type="file" name="image" class="form-control" accept="image/*" {{ $item ? '' : 'required' }}>
      @if ($item && $item->image_path)<img src="{{ asset('storage/'.$item->image_path) }}" class="mt-2" style="height:70px;border-radius:6px">@endif
    </div>
    <div class="mb-3 form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}><label class="form-check-label" for="isActive">Active (visible on site)</label></div>
    <button type="submit" class="btn btn-dark">{{ $item ? 'Save Changes' : 'Add Item' }}</button>
    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
