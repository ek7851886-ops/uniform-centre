@extends('layouts.admin')
@section('title', 'Products')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="mb-0">Products</h3>
  <a href="{{ route('admin.products.create') }}" class="btn btn-dark">+ Add Product</a>
</div>
<form method="GET" class="mb-3" style="max-width:400px"><input type="text" name="q" class="form-control" placeholder="Search products..." value="{{ request('q') }}"></form>
<div class="card bg-white p-3">
  <div class="table-responsive">
  <table class="table align-middle">
    <thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Active</th><th></th></tr></thead>
    <tbody>
      @foreach ($products as $p)
        <tr>
          <td><img src="{{ optional($p->primaryImage())->image_path ? asset('storage/'.$p->primaryImage()->image_path) : 'https://placehold.co/50x50' }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px"></td>
          <td>{{ $p->name }}</td>
          <td>{{ optional($p->category)->name ?? '-' }}</td>
          <td><form action="{{ route('admin.products.toggle', $p) }}" method="POST" class="d-inline">@csrf<button type="submit" class="badge {{ $p->is_active ? 'bg-success' : 'bg-danger' }} border-0">{{ $p->is_active ? 'Active' : 'Hidden' }}</button></form></td>
          <td>
            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  <div class="mt-2">{{ $products->links() }}</div>
</div>
@endsection
