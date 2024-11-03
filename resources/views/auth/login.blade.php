<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('content')
<style>
    /* Main Container */
    body {
        background-color: #f8f9fa;
    }
    .login-container {
        margin: auto;
        margin-top: 10%;
        display: flex;
        height: 60vh;
        width: 60%;
        transition: all 0.5s ease;
    }

    /* Entrance Sections */
    .login-entrance {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5em;
        font-weight: bold;
        cursor: pointer;
        transition: flex 0.5s ease;
        position: relative;
        overflow: hidden;
    }

    .customer-entrance {
        background-color: #ffffff;
        color: #000000;
    }

    .admin-entrance {
        background-color: rgba(0, 0, 0, 1);
        color: #ffffff;
    }

    /* Expanded and Shrunk State Styling */
    .login-container.customer-active .customer-entrance {
        flex: 7;
    }

    .login-container.customer-active .admin-entrance {
        flex: 3;
    }

    .login-container.admin-active .admin-entrance {
        flex: 7;
    }

    .login-container.admin-active .customer-entrance {
        flex: 3;
    }

    /* Login Form Styling */
    .login-form {
        width: 100%;
        max-width: 300px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.0);
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    /* Show form when active */
    .login-container.customer-active .customer-entrance .login-form,
    .login-container.admin-active .admin-entrance .login-form {
        display: block;
        opacity: 1;
    }

    /* Placeholder for the opposite entrance text */
    .placeholder-text {
        font-size: 1.2em;
        opacity: 0.7;
    }

    .login-container.customer-active .admin-entrance .placeholder-text {
        display: block;
    }

    .login-container.admin-active .customer-entrance .placeholder-text {
        display: block;
        color: #000000;
    }

    .login-container.customer-active .customer-entrance .placeholder-text,
    .login-container.admin-active .admin-entrance .placeholder-text {
        display: none;
    }

    /* Button and Input Styles */
    .btn-customer {
        background-color: #000;
        color: #fff;
        border: none;
    }
    .btn-customer:hover {
        color: rgba(255, 255, 255, 0.5);
    }

    .btn-admin {
        background-color: #fff;
        color: rgba(0, 0, 0, 0.5);
        border: none;
    }

    /* Input Underline Style */
    .form-control {
        border: none;
        border-bottom: 2px solid #000;
        border-radius: 0;
        box-shadow: none;
    }

    .form-control:focus {
        box-shadow: none;
        border-bottom: 2px solid rgba(0, 0, 0, 0.5);
    }

    /* Smaller Labels */
    .form-group label {
        font-size: 0.85em;
        font-weight: 600;
        color: #333;
    }

    .input-admin {
        background-color: #000;
        border-bottom: 2px solid #fff;
    }

    .input-admin:focus {
        background-color: #000;
        border-bottom: 2px solid rgba(255, 255, 255, 0.5);
    }

    /* Error Message Styling */
    .error-message {
        font-size: 0.75em;
        color: #d9534f;
        text-align: left;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .login-container {
            width: 90%;
            flex-direction: column;
        }
        .login-entrance {
            flex: 1 !important;
            padding: 20px;
        }
        .login-form {
            position: relative;
            top: 0;
            left: 0;
            transform: none;
            max-width: 100%;
            padding: 15px;
        }
    }
</style>

<div class="login-container customer-active" id="loginContainer">
    <!-- Customer Entrance -->
    <div class="login-entrance customer-entrance" onclick="switchToCustomer()">
        <div class="login-form" id="customerForm">
            <h3>Login as Customer</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="role" value="customer">
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-customer w-100">Sign In</button>
                <div class="mt-3">
                    <small><a href="{{ route('password.request') }}">Forgot Password?</a> |
                    <a href="{{ route('register.role', 'customer') }}">Register</a></small>
                </div>
            </form>
        </div>
        <!-- Placeholder for Admin Entrance -->
        <h5><div class="placeholder-text">Admin Entrance</div></h5>
    </div>

    <!-- Admin Entrance -->
    <div class="login-entrance admin-entrance" onclick="switchToAdmin()">
        <div class="login-form" id="adminForm">
            <h3>Login as Admin</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="role" value="admin">
                
                <div class="form-group">
                    <label style="color: #ffffff;" for="email">Email:</label>
                    <input type="email" name="email" class="form-control input-admin" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label style="color: #ffffff;" for="password">Password:</label>
                    <input type="password" name="password" class="form-control input-admin" required>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-admin w-100">Sign In</button>
                <div class="mt-3">
                    <small><a href="{{ route('password.request') }}" style="color: #ffffff;">Forgot Password?</a> |
                    <a href="{{ route('register.role', 'admin') }}" style="color: #ffffff;">Register</a></small>
                </div>
            </form>
        </div>
        <!-- Placeholder for Customer Entrance -->
        <h5><div class="placeholder-text">Customer Entrance</div></h5>
    </div>
</div>

<script>
    function switchToCustomer() {
        const container = document.getElementById('loginContainer');
        container.classList.add('customer-active');
        container.classList.remove('admin-active');
    }

    function switchToAdmin() {
        const container = document.getElementById('loginContainer');
        container.classList.add('admin-active');
        container.classList.remove('customer-active');
    }
</script>
@endsection
