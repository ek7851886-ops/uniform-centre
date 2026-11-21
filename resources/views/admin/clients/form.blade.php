@extends('layouts.admin')
@section('title', $client ? 'Edit Client' : 'Add Client')
@section('content')
<h3 class="mb-4">{{ $client ? 'Edit Client' : 'Add Client' }}</h3>
<div class="card bg-white p-4" style="max-width:600px">
  <form method="POST" action="{{ $client ? route('admin.clients.update', $client) : route('admin.clients.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($client) @method('PUT') @endif
    <div class="mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name', $client->company_name ?? '') }}" required></div>
    <div class="mb-3"><label class="form-label">Description (optional)</label><textarea name="description" class="form-control" rows="2">{{ old('description', $client->description ?? '') }}</textarea></div>
    <div class="mb-3"><label class="form-label">Display Order</label><input type="number" name="display_order" class="form-control" value="{{ old('display_order', $client->display_order ?? 0) }}"></div>
    <div class="mb-3"><label class="form-label">Company Logo</label><input type="file" name="logo" class="form-control" accept="image/*">
      @if ($client && $client->logo_path)<img src="{{ asset('storage/'.$client->logo_path) }}" class="mt-2" style="height:50px;object-fit:contain">@endif
    </div>
    <div class="mb-3 form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}><label class="form-check-label" for="isActive">Active (visible on site)</label></div>
    <button type="submit" class="btn btn-dark">{{ $client ? 'Save Changes' : 'Add Client' }}</button>
    <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
