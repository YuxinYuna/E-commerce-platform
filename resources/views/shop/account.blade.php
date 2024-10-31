@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <ul class="list-group">
                <li class="list-group-item {{ $section == 'profile' ? 'active' : '' }}">
                    <a href="{{ route('account', ['section' => 'profile']) }}">Profile</a>
                </li>
                <li class="list-group-item {{ $section == 'order-history' ? 'active' : '' }}">
                    <a href="{{ route('account', ['section' => 'order-history']) }}">Order History</a>
                </li>
                <li class="list-group-item {{ $section == 'cart' ? 'active' : '' }}">
                    <a href="{{ route('account', ['section' => 'cart']) }}">Cart</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            @if ($section == 'profile')
                <h3>Profile</h3>
                <p>Name: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>

            @elseif ($section == 'order-history')
                <h3>Order History</h3>
                @if (isset($orders) && $orders->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($orders as $order)
                            <li class="list-group-item">
                                Order #{{ $order->id }} - Status: {{ $order->status }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No orders found.</p>
                @endif

            @elseif ($section == 'cart')
                <h3>Cart</h3>
                @if (isset($cartItems) && $cartItems->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item">
                                {{ $item->product->name }} - Quantity: {{ $item->quantity }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Your cart is empty.</p>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
