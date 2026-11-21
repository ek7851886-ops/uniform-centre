@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
<h3 class="mb-4">Site Settings</h3>
<div class="card bg-white p-4" style="max-width:600px">
  <form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf @method('PUT')
    <div class="mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] }}"></div>
    <div class="mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ $settings['phone'] }}"></div>
    <div class="mb-3"><label class="form-label">WhatsApp Number <span class="small text-muted">(country code, no + or spaces, e.g. 923001234567)</span></label><input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] }}"></div>
    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ $settings['email'] }}"></div>
    <div class="mb-3"><label class="form-label">Business Address</label><textarea name="address" class="form-control" rows="2">{{ $settings['address'] }}</textarea></div>
    <div class="mb-3"><label class="form-label">Working Hours</label><input type="text" name="working_hours" class="form-control" value="{{ $settings['working_hours'] }}"></div>
    <button type="submit" class="btn btn-dark w-100">Save Settings</button>
  </form>
</div>
@endsection
