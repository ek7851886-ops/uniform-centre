@extends('layouts.admin')
@section('title', 'Messages')
@section('content')
<h3 class="mb-4">Contact Messages</h3>
@forelse ($messages as $m)
  <div class="card bg-white p-3 mb-3 {{ $m->is_read ? '' : 'border-warning' }}">
    <div class="d-flex justify-content-between align-items-start flex-wrap">
      <div>
        <h6 class="mb-1">{{ $m->name }} @if($m->company_name) — {{ $m->company_name }} @endif</h6>
        <p class="small text-muted mb-1">{{ $m->email }} @if($m->phone) &middot; {{ $m->phone }} @endif &middot; {{ $m->created_at->format('d M Y, h:i A') }}</p>
        <p class="mb-0">{{ $m->message }}</p>
      </div>
      <div>
        @if (!$m->is_read)
          <form action="{{ route('admin.messages.read', $m) }}" method="POST">@csrf<button type="submit" class="btn btn-sm btn-outline-success">Mark Read</button></form>
        @else <span class="badge bg-secondary">Read</span> @endif
      </div>
    </div>
  </div>
@empty <p class="text-muted">No messages yet.</p> @endforelse
@endsection
