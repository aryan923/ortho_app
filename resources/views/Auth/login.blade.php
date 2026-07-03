@extends('layouts.app')

@section('title', 'Login | OrthoCore Clinic')

@push('styles')
<style>
    .auth-page {
        padding: 56px 0 80px;
        background: linear-gradient(180deg, #f6fbff 0%, #ffffff 100%);
    }

    .auth-grid {
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        gap: 24px;
        align-items: center;
    }

    .auth-copy {
        padding: 24px 8px;
    }

    .auth-copy h1 {
        font-size: clamp(2rem, 3vw, 2.7rem);
        font-weight: 800;
        letter-spacing: -0.02em;
        margin: 12px 0 10px;
        color: #0f1f3a;
    }

    .auth-copy p {
        color: #5f6f85;
        font-size: 15px;
        line-height: 1.7;
        max-width: 520px;
    }

    .auth-list {
        margin-top: 18px;
        display: grid;
        gap: 10px;
    }

    .auth-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #24416a;
        font-weight: 600;
    }

    .auth-list .dot {
        width: 9px;
        height: 9px;
        border-radius: 999px;
        background: linear-gradient(135deg, #1253c8, #4fd3cc);
        flex-shrink: 0;
    }

    .auth-card {
        background: #fff;
        border: 1px solid #dde8f7;
        border-radius: 24px;
        box-shadow: 0 18px 45px rgba(15, 31, 58, 0.08);
        padding: 28px;
    }

    .auth-card h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f1f3a;
        margin-bottom: 8px;
    }

    .auth-card .subtext {
        color: #5f6f85;
        font-size: 14px;
        margin-bottom: 18px;
    }

    .alert {
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 16px;
        font-size: 14px;
    }

    .alert-success {
        background: #e9fbf4;
        color: #166b46;
        border: 1px solid #b8ebce;
    }

    .alert-error {
        background: #fff1f0;
        color: #b42318;
        border: 1px solid #f7c7c2;
    }

    .field {
        display: block;
        margin-bottom: 14px;
    }

    .field span {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 700;
        color: #24416a;
    }

    .field input {
        width: 100%;
        border: 1px solid #d6e3f2;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .field input:focus {
        border-color: #1253c8;
        box-shadow: 0 0 0 3px rgba(18, 83, 200, 0.12);
    }

    .field input.input-error {
        border-color: #d92d20;
    }

    .helper-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: 4px;
        margin-bottom: 16px;
        font-size: 13px;
    }

    .helper-row label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #5f6f85;
    }

    .helper-row a {
        color: #1253c8;
        font-weight: 700;
    }

    .login-btn {
        width: 100%;
        border: none;
        border-radius: 999px;
        padding: 12px 16px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #1253c8, #4fd3cc);
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .login-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(18, 83, 200, 0.2);
    }

    .auth-footer {
        margin-top: 16px;
        text-align: center;
        color: #5f6f85;
        font-size: 14px;
    }

    .auth-footer a {
        color: #1253c8;
        font-weight: 700;
    }

    .error-text {
        display: block;
        margin-top: 4px;
        color: #d92d20;
        font-size: 12px;
    }

    @media (max-width: 860px) {
        .auth-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="wrap auth-grid">
        <div class="auth-copy">
            <span class="tag">Patient Portal</span>
            <h1>Welcome back to OrthoCore</h1>
            <p>Login to manage your appointments, track recovery progress, and stay connected with your care team in one secure place.</p>

            <ul class="auth-list" aria-label="Benefits of logging in">
                <li><span class="dot"></span> View upcoming appointments and treatment plans</li>
                <li><span class="dot"></span> Receive recovery reminders and care updates</li>
                <li><span class="dot"></span> Access your personal patient dashboard anytime</li>
            </ul>
        </div>

        <div class="auth-card">
            <h2>Sign in</h2>
            <p class="subtext">Use your email and password to continue.</p>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    Please review the highlighted fields below.
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <label class="field">
                    <span>Email address</span>
                    <input type="email" name="email" value="{{ old('email') }}" class="@error('email') input-error @enderror" placeholder="you@example.com" required>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </label>

                <label class="field">
                    <span>Password</span>
                    <input type="password" name="password" class="@error('password') input-error @enderror" placeholder="••••••••" required>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </label>

                <div class="helper-row">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        Keep me signed in
                    </label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn">Sign in</button>
            </form>

            <div class="auth-footer">
                Don’t have an account? <a href="{{ route('register') }}">Create one</a>
            </div>
        </div>
    </div>
</div>
@endsection
