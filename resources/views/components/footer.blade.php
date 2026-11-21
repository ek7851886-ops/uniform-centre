<footer class="site-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <h6>{{ \App\Models\Setting::get('company_name', 'Uniform Manufacturing Co.') }}</h6>
        <p class="small">Custom-made corporate, industrial and professional uniforms manufactured for businesses across the region.</p>
      </div>
      <div class="col-lg-2 col-md-6">
        <h6>Quick Links</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="{{ route('about') }}">About Us</a></li>
          <li class="mb-2"><a href="{{ route('portfolio.index') }}">Our Work</a></li>
          <li class="mb-2"><a href="{{ route('clients.index') }}">Clients</a></li>
          <li class="mb-2"><a href="{{ route('quotations.create') }}">Request a Quote</a></li>
          <li class="mb-2"><a href="{{ route('orders.track') }}">Track Order</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h6>Uniform Categories</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="{{ route('uniforms.index') }}">Corporate Uniforms</a></li>
          <li class="mb-2"><a href="{{ route('uniforms.index') }}">Industrial Uniforms</a></li>
          <li class="mb-2"><a href="{{ route('uniforms.index') }}">Security Uniforms</a></li>
          <li class="mb-2"><a href="{{ route('uniforms.index') }}">Hospitality Uniforms</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6">
        <h6>Contact</h6>
        <ul class="list-unstyled small">
          <li class="mb-2">📞 {{ \App\Models\Setting::get('phone', '+92 300 0000000') }}</li>
          <li class="mb-2">✉️ {{ \App\Models\Setting::get('email', 'info@company.com') }}</li>
          <li class="mb-2">📍 {{ \App\Models\Setting::get('address', 'Karachi, Pakistan') }}</li>
          <li class="mb-2">🕐 {{ \App\Models\Setting::get('working_hours', 'Mon–Sat, 9AM–6PM') }}</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; <span id="footerYear"></span> {{ \App\Models\Setting::get('company_name', 'Uniform Manufacturing Co.') }}. All Rights Reserved.
    </div>
  </div>
</footer>
<script>document.getElementById('footerYear').textContent = new Date().getFullYear();</script>
