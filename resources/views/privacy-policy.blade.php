@extends('layouts.app')

@section('content')
<main class="policy-page">
  <div class="policy-container">
    <div class="policy-header">
      <h1 class="policy-title">Privacy Policy</h1>
      <p class="policy-subtitle">How we collect, use, and protect your information</p>
    </div>

    <section class="policy-section">
      <h2 class="section-title">1. Overview</h2>
      <p class="section-text">This Privacy Policy explains what information we collect when you use our website, how we use and share it, and the choices you have. By using our site, you agree to the practices described here.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">2. Information We Collect</h2>
      <ul class="section-list">
        <li>Account information such as name, email, phone, and shipping address</li>
        <li>Order and payment details processed securely via our payment partners</li>
        <li>Device, log, and usage data to improve site performance and security</li>
        <li>Communications you send to our support team</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2 class="section-title">3. How We Use Information</h2>
      <ul class="section-list">
        <li>To provide and deliver products, process transactions, and manage orders</li>
        <li>To personalize your experience and improve our services</li>
        <li>To communicate about orders, updates, and customer support</li>
        <li>To prevent fraud, enforce policies, and ensure site security</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2 class="section-title">4. Cookies and Similar Technologies</h2>
      <p class="section-text">We use cookies and similar technologies to remember preferences, analyze traffic, and improve functionality. You can control cookies through your browser settings. Disabling cookies may affect site features.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">5. Sharing of Information</h2>
      <p class="section-text">We may share information with service providers who help operate our business (such as payment processors, shipping partners, and analytics services). These providers are authorized to use your information only as necessary to provide services to us.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">6. Data Retention</h2>
      <p class="section-text">We retain information for as long as necessary to fulfill the purposes outlined in this policy unless a longer retention period is required or permitted by law.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">7. Your Rights</h2>
      <p class="section-text">Depending on your location, you may have rights to access, correct, or delete your personal information, or to object to or restrict certain processing. To exercise these rights, contact us using the details below.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">8. Children's Privacy</h2>
      <p class="section-text">Our services are not directed to children. We do not knowingly collect personal information from individuals under the age of 13 (or the applicable age in your jurisdiction).</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">9. Changes to This Policy</h2>
      <p class="section-text">We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated effective date.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">10. Contact Us</h2>
      <p class="section-text">If you have questions about this Privacy Policy or your information, please contact us at <a href="mailto:glamessentialscompany@gmail.com">glamessentialscompany@gmail.com</a>.</p>
    </section>
  </div>
</main>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('includes/style/pages/policy.css') }}">
@endpush
