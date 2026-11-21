@extends('layouts.admin')
@section('title', 'Portfolio')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="mb-0">Portfolio</h3>
  <a href="{{ route('admin.portfolio.create') }}" class="btn btn-dark">+ Add Portfolio Item</a>
</div>
<div class="row g-3">
  @forelse ($items as $item)
    <div class="col-md-3">
      <div class="card bg-white h-100">
        <img src="{{ asset('storage/'.$item->image_path) }}" style="height:150px;object-fit:cover" class="card-img-top">
        <div class="p-2">
          <span class="badge bg-secondary">{{ $item->category }}</span>
          <h6 class="mt-2 mb-1">{{ $item->title }}</h6>
          <div class="d-flex gap-1 mt-2">
            <a href="{{ route('admin.portfolio.edit', $item) }}" class="btn btn-sm btn-outline-primary flex-fill">Edit</a>
            <form action="{{ route('admin.portfolio.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
          </div>
        </div>
      </div>
    </div>
  @empty <p class="text-muted">No portfolio items yet.</p> @endforelse
</div>
@endsection
