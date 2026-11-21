@extends('layouts.app')
@section('title', 'Create Business Account')
@section('content')
<div class="container section-py pt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5" data-reveal="zoom-in">
      <div class="card shadow-sm p-4">
        <h3 class="mb-3">Create a Business Account</h3>
        <p class="text-muted small">For companies requesting uniform quotations.</p>
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required></div>
          <div class="mb-3"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}" required></div>
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
          <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required></div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
          <div class="mb-3"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control" required></div>
          <button type="submit" class="btn btn-gold w-100">Create Account</button>
        </form>
        <p class="mt-3 text-center small">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
