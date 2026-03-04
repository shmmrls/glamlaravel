@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-form-wrapper">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your GlamEssentials account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-input"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="form-group checkbox-group">
                    <label for="remember_me" class="checkbox-label">
                        <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
                        <span class="checkbox-text">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="form-actions">
                    @if (Route::has('password.request'))
                        <a class="forgot-password-link" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="login-btn">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="login-footer">
                <p>Don't have an account? <a href="{{ route('register') }}" class="register-link">Register here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    @vite(['resources/css/login.css'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
@endpush
