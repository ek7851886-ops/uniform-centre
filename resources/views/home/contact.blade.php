@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_description', 'Get in touch for uniform manufacturing inquiries, bulk orders, or custom requirements.')

@section('content')
<section class="section-py pt-5">
  <div class="container">
    <div class="text-center mb-5" data-reveal="fade-up">
      <span class="section-label">Get In Touch</span>
      <h1 class="mt-2">Contact Us</h1>
    </div>
    <div class="row g-5">
      <div class="col-lg-7" data-reveal="fade-right">
        <div class="card p-4">
          <form method="POST" action="{{ route('contact.store') }}" data-loading-text="Sending...">
            @csrf
            <div class="row">
              <div class="col-md-6 mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
              <div class="col-md-6 mb-3"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}"></div>
              <div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
              <div class="col-md-6 mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
              <div class="col-12 mb-3"><label class="form-label">Message</label><textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea></div>
            </div>
            <button type="submit" class="btn btn-gold w-100">Send Message</button>
          </form>
        </div>
      </div>
      <div class="col-lg-5" data-reveal="fade-left">
        <div class="card p-4 h-100">
          <h5 class="mb-4">Business Information</h5>
          <div class="mb-3"><div class="small text-muted">Phone</div><div class="fw-semibold">{{ \App\Models\Setting::get('phone', '+92 300 0000000') }}</div></div>
          <div class="mb-3"><div class="small text-muted">WhatsApp</div><div class="fw-semibold"><a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number', '923000000000') }}" target="_blank">{{ \App\Models\Setting::get('whatsapp_number', '923000000000') }}</a></div></div>
          <div class="mb-3"><div class="small text-muted">Email</div><div class="fw-semibold">{{ \App\Models\Setting::get('email', 'info@company.com') }}</div></div>
          <div class="mb-3"><div class="small text-muted">Business Address</div><div class="fw-semibold">{{ \App\Models\Setting::get('address', 'Karachi, Pakistan') }}</div></div>
          <div class="mb-0"><div class="small text-muted">Working Hours</div><div class="fw-semibold">{{ \App\Models\Setting::get('working_hours', 'Mon–Sat, 9AM–6PM') }}</div></div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
