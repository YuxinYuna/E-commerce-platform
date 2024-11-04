<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'my_shop')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <style>
        body {
            padding-top: 60px;
        }
        .brand-name {
            font-family: 'Lobster', cursive; /* Replace 'Lobster' with your chosen font */
            font-size: 2.5rem; /* Adjust size as needed */
            font-weight: bold;
            color: #333; /* Customize color */
        }

        /* Sidebar styling */
        .sidebar {
            background-color: rgba(0, 0, 0, 0.8);
            color: #ffffff;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            z-index: 1;
        }
        .sidebar .nav-link {
            color: #ffffff;
        }
        .sidebar .nav-link.active {
            background-color: #000000;
        }
        /* .sidebar .nav-link:hover {
            color: #5867DD;
        } */
        .admin-container {
            margin-left: 20%;
            width: 100%;

        }

        /* Main content styling */
        .content {
            margin-left: 250px;
            position: fixed;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Top bar styling */
        .top-bar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2;
        }
        .add-to-cart-notification {
            position: fixed;
            top: 70px; /* Adjust to avoid overlapping the navbar */
            right: 100px;
            z-index: 1050; /* Higher than the navbar */
            width: auto;
            max-width: 300px;
            padding: 15px;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .add-to-cart-notification .close {
            color: white;
            opacity: 0.8;
        }

        .add-to-cart-notification .close:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <!-- Navbar Brand - Only for Guests and Non-admin Users -->
            @guest
                <a class="navbar-brand brand-name" href="{{ url('/') }}">Velvet & Vine</a>
            @else
                @if(auth()->user()->role !== 'admin')
                    <a class="navbar-brand" href="{{ url('/') }}">Home</a>
                @endif
            @endguest
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <!-- Shop Link - Only for Non-admin Users -->
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <!-- Show Login/Register for Guests -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.role') }}">Login / Register</a>
                        </li>
                    @else
                        <!-- Admin Dashboard Link for Admins -->
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @endif

                        <!-- User Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <!-- Profile, Cart, and Order History for Non-admin Users -->
                                @if(auth()->user()->role !== 'admin')
                                    <a class="dropdown-item" href="{{ route('account', ['section' => 'profile']) }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('account', ['section' => 'cart']) }}">Cart</a>
                                    <a class="dropdown-item" href="{{ route('account', ['section' => 'order-history']) }}">Order History</a>

                                @endif

                                <!-- Logout for All Users -->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content with Conditional Admin Sidebar -->
    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar for Navigation (Only Visible for Admins) -->
            @if(auth()->check() && auth()->user()->role === 'admin')
                <nav class="col-md-3 col-lg-2 sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('admin.products.index')) active @endif" href="{{ route('admin.products.index') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->routeIs('admin.orders.index')) active @endif" href="{{ route('admin.orders.index') }}">Orders</a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Main content area for Admin with Sidebar -->
                <div class="admin-container">
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4 ">
                
            @else
                <!-- Main content area for Regular Users without Sidebar -->
                <main class="col-md-12 mt-4">
            @endif
                    <!-- Display success and error messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show add-to-cart-notification" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <!-- Yield content for specific pages -->
                    @yield('content')
                </main>
                </div>
            </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.add-to-cart-notification').alert('close');
            }, 3000); // 3000ms = 3 seconds
        });
    </script>
    @yield('scripts')
</body>
</html>
