@extends('layouts.app')

@section('content')
<style>
    /* Main Container */
    .login-container {
        display: flex;
        height: 60vh;
        width: 70%;
        transition: all 0.5s ease; /* Smooth transition for container changes */
    }

    /* Entrance Sections */
    .login-entrance {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5em;
        font-weight: bold;
        color: #fff;
        cursor: pointer;
        transition: flex 0.5s ease; /* Smooth transition for resizing */
        position: relative;
        overflow: hidden;
    }

    .customer-entrance {
        background-color: #FFD966;
    }

    .admin-entrance {
        background-color: #92C9F1;
    }

    /* Expanded and Shrunk State Styling */
    .login-container.customer-active .customer-entrance {
        flex: 7; /* Expand Customer Entrance to 70% */
    }

    .login-container.customer-active .admin-entrance {
        flex: 3; /* Shrink Admin Entrance to 30% */
    }

    .login-container.admin-active .admin-entrance {
        flex: 7; /* Expand Admin Entrance to 70% */
    }

    .login-container.admin-active .customer-entrance {
        flex: 3; /* Shrink Customer Entrance to 30% */
    }

    /* Login Form Styling */
    .login-form {
        width: 100%;
        max-width: 300px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.0);
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.0);
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    /* Show form when active */
    .login-container.customer-active .customer-entrance .login-form {
        opacity: 1;
    }

    .login-container.admin-active .admin-entrance .login-form {
        opacity: 1;
    }
</style>

<div class="login-container customer-active" id="loginContainer">
    <!-- Customer Entrance -->
    <div class="login-entrance customer-entrance" onclick="switchToCustomer()">
        <div class="login-form" id="customerForm">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3>Login as Customer</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="role" value="customer">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
                <div class="mt-3">
                    <a href="{{ route('password.request') }}">Forgot Password?</a> |
                    <a href="{{ route('register.role', 'customer') }}">Register</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Admin Entrance -->
    <div class="login-entrance admin-entrance" onclick="switchToAdmin()">
        <div class="login-form" id="adminForm" style="opacity: 0;">
            <h3>Login as Admin</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="role" value="admin">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
                <div class="mt-3">
                    <a href="{{ route('password.request') }}">Forgot Password?</a> |
                    <a href="{{ route('register.role', 'admin') }}">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function switchToCustomer() {
        // Activate customer view by updating the container class
        document.getElementById('loginContainer').classList.add('customer-active');
        document.getElementById('loginContainer').classList.remove('admin-active');
        
        // Show customer form, hide admin form
        document.getElementById('customerForm').style.opacity = '1';
        document.getElementById('adminForm').style.opacity = '0';
    }

    function switchToAdmin() {
        // Activate admin view by updating the container class
        document.getElementById('loginContainer').classList.add('admin-active');
        document.getElementById('loginContainer').classList.remove('customer-active');
        
        // Show admin form, hide customer form
        document.getElementById('adminForm').style.opacity = '1';
        document.getElementById('customerForm').style.opacity = '0';
    }
</script>
@endsection

