<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'my_shop')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 60px;
        }

        /* Sidebar styling */
        .sidebar {
            background-color: #2A2F45;
            color: #ffffff;
            height: 100vh;
            position: fixed;
            width: 250px;
            padding-top: 20px;
            z-index: 1;
        }
        .sidebar .nav-link {
            color: #ffffff;
        }
        .sidebar .nav-link.active {
            background-color: #5867DD;
        }
        .sidebar .nav-link:hover {
            color: #5867DD;
        }

        /* Main content styling */
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Card styling */
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dashboard-card h5 {
            font-weight: bold;
            font-size: 24px;
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
        @guest
            <a class="navbar-brand" href="{{ url('/') }}">my_shop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        @endguest
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <!-- Hide Shop link for Admins -->
                    @if(auth()->check() && auth()->user()->role !== 'admin')
                    <a class="navbar-brand" href="{{ url('/') }}">my_shop</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    @endif
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        <!-- Show Login/Register for guests -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.role') }}">Login / Register</a>
                        </li>
                    @else
                        <!-- Admin-specific menu item -->
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                            </li>
                        @endif

                        <!-- Dropdown menu for user options -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <!-- Show Profile, Cart, and Order History only for customers -->
                                @if(auth()->user()->role !== 'admin')
                                    <a class="dropdown-item" href="{{ route('account', ['section' => 'profile']) }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('account', ['section' => 'cart']) }}">Cart</a>
                                    <a class="dropdown-item" href="{{ route('account', ['section' => 'order-history']) }}">Order History</a>
                                @endif

                                <!-- Logout link available for both admins and customers -->
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
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            @else
                <!-- Main content area for Regular Users without Sidebar -->
                <main class="col-md-12 mt-4">
            @endif
                    <!-- Display success and error messages -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Yield content for specific pages -->
                    @yield('content')
                </main>
            </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
