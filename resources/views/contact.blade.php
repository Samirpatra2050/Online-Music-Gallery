@extends('layouts.app')

@section('content')
<div class="contact-container">
    <h2 class="contact-title">Contact Us</h2>
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Fixed the route name from contact.submit to contact.store -->
    <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   placeholder="Your name" 
                   value="{{ old('name') }}" 
                   required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   placeholder="Your email" 
                   value="{{ old('email') }}" 
                   required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" 
                      id="message" 
                      rows="5" 
                      placeholder="Your message" 
                      required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn-send">Send</button>
    </form>

    <footer class="footer">
        <p>© 2025 All Rights Reserved</p>
    </footer>
</div>
@endsection

@push('styles')
<style>
/* Background */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #1d2671, #0f0c29);
    color: #fff;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Contact container */
.contact-container {
    background: rgba(255, 255, 255, 0.05);
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    width: 400px;
    text-align: center;
    max-width: 90%;
}

/* Title */
.contact-title {
    font-size: 24px;
    margin-bottom: 20px;
    color: #fff;
}

/* Form */
.contact-form {
    display: flex;
    flex-direction: column;
}

.form-group {
    text-align: left;
    margin-bottom: 15px;
}

.form-group label {
    font-size: 14px;
    display: block;
    margin-bottom: 5px;
    color: #ddd;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 6px;
    outline: none;
    font-size: 14px;
    box-sizing: border-box;
}

/* Button */
.btn-send {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

.btn-send:hover {
    background: #0056b3;
}

/* Footer */
.footer {
    margin-top: 15px;
    font-size: 12px;
    color: #ccc;
}

/* Alert Messages */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 6px;
    text-align: left;
}

.alert-success {
    background-color: rgba(40, 167, 69, 0.8);
    color: white;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.8);
    color: white;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.alert i {
    margin-right: 8px;
}

/* Responsive */
@media (max-width: 480px) {
    .contact-container {
        width: 95%;
        padding: 20px;
    }
    
    .contact-title {
        font-size: 20px;
    }
}
</style>
@endpush