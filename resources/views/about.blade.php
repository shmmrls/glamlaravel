@extends('layouts.app')

@section('content')
<main class="about-wrapper">
    <h1 class="about-title">About GlamEssentials</h1>
    <div class="about-subtitle">Elevating Professional Beauty Standards</div>
    <div class="about-divider"></div>
    <div class="about-content">
        <p>GlamEssentials was founded with a singular vision: to provide salon professionals and beauty enthusiasts with premium-quality products that deliver exceptional results. We understand that in the world of beauty, excellence isn't optional—it's essential.</p>
        <br>

        <p><strong><span style="text-align:center;display:block;">OUR MISSION</span></strong>
        We curate only the finest salon essentials for the modern professional who demands both quality and performance. Every product in our collection is carefully selected to meet the highest industry standards, ensuring that you have access to tools and products that elevate your craft.</p>
        <br>

        <p><strong><span style="text-align:center;display:block;">WHY CHOOSE GlamEssentials?</span></strong>
        We don't just sell products—we curate experiences. Each item is carefully selected and vetted for its quality, effectiveness, and professional-grade performance. Whether you're a salon owner, an independent stylist, or a passionate beauty enthusiast, our products are crafted to meet professional standards and deliver exceptional results. Staying ahead of industry trends, we offer modern solutions that blend timeless elegance with cutting-edge technology, ensuring you always have access to the best the beauty industry has to offer.</p>
        <br>

        <p><strong><span style="text-align:center;display:block;">OUR COMMITMENT</span></strong>
        At GlamEssentials, we believe that great beauty work starts with great products. We're committed to being your trusted partner in delivering exceptional results to every client, every time.</p>
        <br>
        <br>
        <p class="about-tagline">Discover the difference that true quality makes.</p>
    </div>
</main>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('includes/style/pages/about-faq.css') }}">
@endpush
