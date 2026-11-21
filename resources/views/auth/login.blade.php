@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="container section-py pt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5" data-reveal="zoom-in">
      <div class="card shadow-sm p-4">
        <h3 class="mb-3">Login</h3>
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
          <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
          <div class="mb-3 form-check"><input type="checkbox" name="remember" class="form-check-input" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
          <button type="submit" class="btn btn-gold w-100">Login</button>
        </form>
        <p class="mt-3 text-center small">Don't have an account? <a href="{{ route('register') }}">Register your company</a></p>
      </div>
    </div>
  </div>
</div>
@endsection
