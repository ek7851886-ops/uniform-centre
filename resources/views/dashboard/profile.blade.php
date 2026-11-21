@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="mb-4" data-reveal="fade-up"><span class="section-label">Account</span><h2 class="mt-2">My Profile</h2></div>
    <div class="card p-4 mx-auto" style="max-width:600px" data-reveal="fade-up">
      <form method="POST" action="{{ route('profile.update') }}">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name', $user->company_name) }}" required></div>
        <div class="mb-3"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $user->contact_person) }}" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
        <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required></div>
        <div class="mb-3"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea></div>
        <div class="mb-3"><label class="form-label">City</label><input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}"></div>
        <hr><p class="small text-muted">Leave password fields blank to keep your current password.</p>
        <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="password" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Confirm New Password</label><input type="password" name="password_confirmation" class="form-control"></div>
        <button type="submit" class="btn btn-gold w-100">Save Changes</button>
      </form>
    </div>
  </div>
</section>
@endsection
