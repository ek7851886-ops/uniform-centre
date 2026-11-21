@extends('layouts.admin')
@section('title', 'Clients')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h3 class="mb-0">Clients</h3>
  <a href="{{ route('admin.clients.create') }}" class="btn btn-dark">+ Add Client</a>
</div>
<div class="card bg-white p-3">
  <div class="table-responsive">
  <table class="table align-middle">
    <thead><tr><th>Logo</th><th>Company Name</th><th>Order</th><th>Active</th><th></th></tr></thead>
    <tbody>
      @forelse ($clients as $c)
        <tr>
          <td><img src="{{ $c->logo_path ? asset('storage/'.$c->logo_path) : 'https://placehold.co/60x40?text=Logo' }}" style="height:40px;object-fit:contain"></td>
          <td>{{ $c->company_name }}</td>
          <td>{{ $c->display_order }}</td>
          <td>{{ $c->is_active ? 'Yes' : 'No' }}</td>
          <td>
            <a href="{{ route('admin.clients.edit', $c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('admin.clients.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this client?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
          </td>
        </tr>
      @empty <tr><td colspan="5" class="text-center text-muted py-3">No clients yet.</td></tr> @endforelse
    </tbody>
  </table>
  </div>
</div>
@endsection
