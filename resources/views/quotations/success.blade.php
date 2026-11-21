@extends('layouts.app')
@section('title', 'Quotation Request Sent')
@section('content')
<div class="container section-py text-center" data-reveal="zoom-in">
  <div style="font-size:3.5rem">✅</div>
  <h1 class="mt-3">Quotation Request Received</h1>
  <p class="text-muted mt-2">Your request has been submitted successfully. Our team will review it and get back to you with pricing shortly.</p>
  <div class="card p-4 mx-auto mt-4" style="max-width:420px">
    <div class="small text-muted">Your Quotation Reference Number</div>
    <div class="h3 text-gold mb-0">{{ $quotation->quote_number }}</div>
  </div>
  <div class="mt-4 d-flex justify-content-center gap-3">
    @auth<a href="{{ route('dashboard') }}" class="btn btn-gold">Go to Dashboard</a>
    @else<a href="{{ route('register') }}" class="btn btn-gold">Create an Account to Track This</a>@endauth
    <a href="{{ route('uniforms.index') }}" class="btn btn-outline-steel bg-navy">Browse More Uniforms</a>
  </div>
</div>
@endsection
