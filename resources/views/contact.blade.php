@extends('layouts.app')

@section('content')
<main class="contact-page">
  <div class="contact-container">
    <div class="contact-header">
      <h1 class="contact-title">Contact Us</h1>
      <p class="contact-subtitle">We're here to help</p>
    </div>

    <section class="contact-section">
      <div class="contact-card">
        <div class="contact-item">
          <div class="contact-label">Email</div>
          <a class="contact-value" href="mailto:glamessentialscompany@gmail.com">glamessentialscompany@gmail.com</a>
        </div>
        <div class="divider"></div>
        <div class="contact-item">
          <div class="contact-label">Cellphone</div>
          <a class="contact-value" href="tel:09308357185">09308357185</a>
        </div>
      </div>
      <p class="contact-note">Business hours: Mon–Fri, 9:00 AM – 6:00 PM</p>
    </section>
  </div>
</main>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('includes/style/pages/contact.css') }}">
@endpush
