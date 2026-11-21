@extends('layouts.admin')
@section('title', 'Categories')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="mb-0">Categories</h3>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-dark">+ Add Category</a>
</div>
<div class="card bg-white p-3">
  <div class="table-responsive">
  <table class="table align-middle">
    <thead><tr><th>Image</th><th>Name</th><th>Products</th><th>Active</th><th></th></tr></thead>
    <tbody>
      @forelse ($categories as $cat)
        <tr>
          <td><img src="{{ $cat->image ? asset('storage/'.$cat->image) : 'https://placehold.co/50x50' }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px"></td>
          <td>{{ $cat->name }}</td>
          <td>{{ $cat->products_count }}</td>
          <td>{{ $cat->is_active ? 'Yes' : 'No' }}</td>
          <td>
            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
          </td>
        </tr>
      @empty <tr><td colspan="5" class="text-center text-muted py-3">No categories yet.</td></tr> @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
