@extends('layouts.app')

@section('content')
<main class="faq-page">
  <div class="faq-container">
    <div class="faq-header">
      <h1 class="faq-title">Frequently Asked Questions</h1>
      <p class="faq-subtitle">Everything you need to know about shopping with GlamEssentials</p>
    </div>

    <div class="faq-sections">
      <section class="faq-section">
        <div class="section-header">
          <h2 class="section-title">| Ordering & Payment</h2>
        </div>
        <div class="faq-grid">
          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">What payment methods do you accept?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>We accept all major credit cards (Visa, Mastercard, American Express), PayPal, and other secure payment methods at checkout.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Can I modify or cancel my order?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Orders can be modified or cancelled within 24 hours of placement. Please contact our customer service team immediately at <a href="mailto:support@glamessentials.com">support@glamessentials.com</a> for assistance.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">How do I place an order?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Simply browse our products, add items to your cart, and proceed to checkout. You'll need to create an account or sign in to complete your purchase.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Do you offer bulk or wholesale pricing?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Yes! We offer special pricing for salon professionals and bulk orders. Please contact us at <a href="mailto:sales@glamessentials.com">sales@glamessentials.com</a> for more information.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="faq-section">
        <div class="section-header">
          <h2 class="section-title">| Shipping & Delivery</h2>
        </div>
        <div class="faq-grid">
          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">How long does shipping take?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Standard shipping typically takes 5–7 business days. Express shipping options are available at checkout for faster delivery.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">How can I track my order?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Once your order ships, you'll receive a tracking number via email. You can also track your order by logging into your account.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Do you ship internationally?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Currently, we ship within selected regions. International shipping options may be available—please contact us for details.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">What if my order arrives damaged?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>We take great care in packaging, but if your order arrives damaged, please contact us within 48 hours with photos, and we'll send a replacement immediately.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="faq-section">
        <div class="section-header">
          <h2 class="section-title">|  Products & Quality</h2>
        </div>
        <div class="faq-grid">
          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Are your products authentic?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Absolutely. We only source authentic, professional-grade products directly from authorized distributors and manufacturers.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Are your products suitable for professional salon use?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Yes! All our products are curated specifically for professional use and meet industry standards.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Do you offer product samples?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Sample availability varies by product. Please check individual product pages or contact us for specific requests.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">What if I'm not satisfied with a product?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Your satisfaction is our priority. Please see our Returns & Exchanges policy for next steps.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="faq-section">
        <div class="section-header">
          <h2 class="section-title">| Returns & Exchanges</h2>
        </div>
        <div class="faq-grid">
          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">What is your return policy?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>We accept returns within 30 days of purchase for unopened products in original packaging. Opened products may be subject to restocking fees.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">How do I initiate a return?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Contact our customer service team at <a href="mailto:support@glamessentials.com">support@glamessentials.com</a> with your order number. We'll provide you with return instructions and a return authorization number.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">When will I receive my refund?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Refunds are processed within 5–7 business days after we receive your return. Please allow additional time for your bank to process the refund.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Do you offer exchanges?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Yes! If you'd like to exchange a product for a different item or size, please contact our customer service team.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="faq-section">
        <div class="section-header">
          <h2 class="section-title">| Account & Privacy</h2>
        </div>
        <div class="faq-grid">
          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Do I need an account to shop?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>While you can browse as a guest, creating an account allows you to track orders, save favorites, and enjoy exclusive member benefits.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">Is my personal information secure?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Yes. We use industry-standard encryption and security measures to protect your personal and payment information.</p>
            </div>
          </div>

          <div class="faq-item">
            <button class="faq-question" type="button">
              <span class="question-text">How do I sign up for exclusive deals?</span>
              <span class="faq-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
              </span>
            </button>
            <div class="faq-answer">
              <p>Click "SIGN UP NOW TO START SHOPPING" in our header banner or subscribe to our newsletter at the bottom of any page.</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</main>

@push('styles')
<link rel="stylesheet" href="{{ asset('includes/style/pages/about-faq.css') }}">
@endpush

@push('head-scripts')
<script src="{{ asset('includes/js/pages/faq.js') }}"></script>
@endpush
