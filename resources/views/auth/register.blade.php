@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-form-wrapper">
            <div class="login-header">
                <h1>Create Account</h1>
                <p>Join GlamEssentials and start shopping</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="login-form" enctype="multipart/form-data">
                @csrf

                <!-- Profile Picture -->
                <div class="form-group">
                    <label class="form-label">Profile Picture (Optional)</label>
                    <br>
                    <div class="profile-picture-upload">
                        <div class="avatar-preview">
                            <img id="avatar-preview" 
                                 src="{{ asset('user/images/profile_pictures/nopfp.jpg') }}" 
                                 alt="Profile Preview"
                                 class="avatar-image"
                                 onerror="this.src='{{ asset('user/images/profile_pictures/nopfp.jpg') }}'">
                        </div>
                        <div class="upload-section">
                            <label for="profile_picture" class="upload-btn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <span class="upload-text">Choose New Picture</span>
                                <span class="upload-hint">JPG, PNG, GIF · Max 5MB</span>
                            </label>
                            <input type="file" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif" 
                                   class="file-input"
                                   onchange="previewImage(this)">
                            <div class="file-info">
                                <div id="file-name" class="file-name">No file chosen</div>
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                </div>

                <!-- Name -->
                <div class="form-group">
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-input"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="form-input"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="form-actions">
                    <a class="back-to-login-link" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="login-btn">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="login-footer">
                <p>Already have an account? <a href="{{ route('login') }}" class="register-link">Sign in here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    @vite(['resources/css/login.css'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
    .form-group {
        margin-bottom: 30px;
    }
    
    .profile-picture-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
        width: 100%;
    }
    
    .avatar-preview {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .avatar-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e9ecef;
        background-color: #f8f9fa;
    }
    
    .upload-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 400px;
    }
    
    .upload-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 20px 16px;
        background: #fff;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        width: 100%;
        justify-content: center;
        box-sizing: border-box;
        min-height: 100px;
    }
    
    .upload-btn:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #000;
    }
    
    .upload-btn svg {
        color: #6c757d;
        margin-bottom: 4px;
    }
    
    .upload-text {
        font-weight: 500;
        color: #495057;
    }
    
    .upload-hint {
        font-size: 12px;
        color: #6c757d;
        font-weight: normal;
    }
    
    .file-input {
        display: none;
    }
    
    .file-info {
        margin-top: 8px;
        width: 100%;
        display: flex;
        justify-content: center;
    }
    
    .file-name {
        font-size: 14px;
        color: #6c757d;
        padding: 8px 12px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        text-align: center;
        word-wrap: break-word;
        word-break: break-all;
        white-space: normal;
        max-width: 100%;
        overflow-wrap: break-word;
        width: 100%;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #495057;
    }
    
    .text-muted {
        color: #6c757d !important;
        font-weight: normal;
    }
    </style>
@endpush

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('avatar-preview');
    const fileName = document.getElementById('file-name');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, or GIF).');
            input.value = '';
            fileName.textContent = 'No file chosen';
            return;
        }
        
        // Validate file size (5MB)
        if (file.size > 5242880) {
            alert('Image size must be less than 5MB.');
            input.value = '';
            fileName.textContent = 'No file chosen';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            fileName.textContent = file.name;
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '{{ asset('user/images/profile_pictures/nopfp.jpg') }}';
        fileName.textContent = 'No file chosen';
    }
}
</script>
@endpush
