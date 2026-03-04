@extends('layouts.app')

@section('content')
<main class="policy-page">
  <div class="policy-container">
    <div class="policy-header">
      <h1 class="policy-title">Terms of Service</h1>
      <p class="policy-subtitle">Please read these terms carefully before using our site or placing an order</p>
    </div>

    <section class="policy-section">
      <h2 class="section-title">1. Agreement to Terms</h2>
      <p class="section-text">By accessing or using this website, you agree to be bound by these Terms of Service and our Privacy Policy. If you do not agree, please do not use the site.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">2. Eligibility</h2>
      <p class="section-text">You must be at least the age of majority in your jurisdiction to use this site or place orders.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">3. Accounts</h2>
      <ul class="section-list">
        <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
        <li>You agree to provide accurate, current, and complete information.</li>
        <li>You are responsible for all activities under your account.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2 class="section-title">4. Orders, Pricing, and Availability</h2>
      <ul class="section-list">
        <li>All orders are subject to acceptance and availability.</li>
        <li>We reserve the right to cancel or refuse any order (e.g., due to suspected fraud or stock errors).</li>
        <li>Prices are subject to change without notice. Taxes and shipping fees may apply.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2 class="section-title">5. Shipping & Delivery</h2>
      <p class="section-text">Shipping times are estimates and not guarantees. Risk of loss passes to you upon delivery to the carrier. See our Shipping & Delivery page for details.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">6. Returns & Refunds</h2>
      <p class="section-text">Returns are accepted according to our Returns policy. Refunds are issued to the original payment method after inspection. Certain items may be final sale for hygiene/safety reasons.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">7. Intellectual Property</h2>
      <p class="section-text">All content on this site, including logos, images, text, and designs, is owned by or licensed to us and protected by applicable laws. You may not use, reproduce, or distribute content without permission.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">8. Prohibited Uses</h2>
      <ul class="section-list">
        <li>Using the site for unlawful purposes</li>
        <li>Interfering with security or integrity of the site</li>
        <li>Infringing the rights of others</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2 class="section-title">9. Disclaimers</h2>
      <p class="section-text">The site and products are provided "as is" without warranties of any kind, to the fullest extent permitted by law.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">10. Limitation of Liability</h2>
      <p class="section-text">To the maximum extent permitted by law, we are not liable for any indirect, incidental, special, consequential, or punitive damages, or lost profits arising from your use of the site or products.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">11. Indemnification</h2>
      <p class="section-text">You agree to indemnify and hold us harmless from any claims arising out of your use of the site or violation of these Terms.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">12. Governing Law</h2>
      <p class="section-text">These Terms are governed by the laws of our principal place of business, without regard to conflict of law principles. Venue for disputes will be in the courts located in that jurisdiction.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">13. Changes to Terms</h2>
      <p class="section-text">We may update these Terms from time to time. Continued use of the site after changes constitutes acceptance of the updated Terms.</p>
    </section>

    <section class="policy-section">
      <h2 class="section-title">14. Contact</h2>
      <p class="section-text">Questions about these Terms? Contact us at <a href="mailto:glamessentialscompany@gmail.com">glamessentialscompany@gmail.com</a>.</p>
    </section>
  </div>
</main>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('includes/style/pages/policy.css') }}">
@endpush
