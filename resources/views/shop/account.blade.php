@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar-full-height">
            <nav class="nav flex-column bg-light p-3 border-right h-100">
                <a class="nav-link {{ $section == 'profile' ? 'active' : '' }}" href="{{ route('account', ['section' => 'profile']) }}">
                    <i class="bi bi-person"></i> Profile
                </a>
                <a class="nav-link {{ $section == 'order-history' ? 'active' : '' }}" href="{{ route('account', ['section' => 'order-history']) }}">
                    <i class="bi bi-clock-history"></i> Order History
                </a>
                <a class="nav-link {{ $section == 'cart' ? 'active' : '' }}" href="{{ route('account', ['section' => 'cart']) }}">
                    <i class="bi bi-cart"></i> Cart
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            @if ($section == 'profile')
                <h3>Profile</h3>
                <p>Name: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Address: {{ $user->address ?? 'Not provided' }}</p>

                <button class="btn btn-primary mt-3" onclick="toggleEditForm()">Edit Profile</button>

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" style="display: none;" class="mt-4">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                    </div>

                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleEditForm()">Cancel</button>
                </form>

            @elseif ($section == 'order-history')
            <h3>Order History</h3>
                @if (isset($orders) && $orders->isNotEmpty())
                    @foreach ($orders as $order)
                        <div class="order-history mb-5 p-3 shadow-sm rounded">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                            <strong>Order #{{ $order->order_number }}</strong>
                                            <span class="text-muted">({{ $order->created_at->format('F j, Y, g:i a') }})</span>
                                        </th>
                                        <th>Status: {{ $order->status }}</th>
                                        <th class="text-right">Total Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $orderItems = json_decode($order->items, true);
                                        $totalCost = 0;
                                    @endphp
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                    @foreach ($orderItems as $item)
                                        @php
                                            $itemTotal = $item['quantity'] * $item['price'];
                                            $totalCost += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>
                                                <img src="{{ asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width: 50px; height: auto; margin-right: 10px; border-radius: 5px;">
                                                {{ $item['name'] }}
                                            </td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>${{ number_format($item['price'], 2) }}</td>
                                            <td>${{ number_format($itemTotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Total Cost:</td>
                                        <td class="font-weight-bold">${{ number_format($totalCost, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endforeach
                @else
                    <p>No orders found.</p>
                @endif

            @elseif ($section == 'cart')
                <h3>Cart</h3>
                @if ($cartItems->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item->product->id) }}" method="POST">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control w-50 d-inline">
                                            <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                                        </form>
                                    </td>
                                    <td>${{ number_format($item->product->price, 2) }}</td>
                                    <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Proceed to Checkout</button>
                    </form>
                @else
                    <p>Your cart is empty.</p>
                @endif
            @endif
        </div>
    </div>
</div>

<script>
    function toggleEditForm() {
        const form = document.getElementById('editProfileForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>

<style>
    .sidebar-full-height {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        padding-top: 60px;
        width: 250px;
        background-color: #f8f9fa;
    }

    .nav.flex-column .nav-link {
        font-size: 1rem;
        color: #333;
        padding: 10px 15px;
    }

    .nav.flex-column .nav-link.active {
        background-color: #007bff;
        color: white !important;
        border-radius: 5px;
    }

    .col-md-9 {
        margin-left: 250px;
        padding-top: 20px;
    }

    @media (max-width: 768px) {
        .sidebar-full-height {
            position: relative;
            width: 100%;
            height: auto;
        }
        
        .col-md-9 {
            margin-left: 0;
        }
    }
    .order-history {
    background-color: #f8f9fa;
    }

    .table th {
        font-weight: bold;
        background-color: #ffffff;
    }

    .table td, .table th {
        border-top: none !important; /* Remove top border */
        padding: 10px;
    }

    .table th {
        color: #333;
    }

    .table thead tr th {
        border-bottom: 2px solid #e9ecef; /* Soft line under header */
    }

    .table tfoot tr td {
        font-size: 1.1em;
        color: #333;
    }


</style>
@endsection
