<!-- resources/views/admin/orders.blade.php -->
@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Orders</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Status</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @php
                    // Decode the items JSON data and initialize total cost
                    $items = json_decode($order->items, true) ?? [];
                    $totalCost = 0;

                    // Calculate the total by summing the price * quantity for each item
                    foreach ($items as $item) {
                        $totalCost += $item['price'] * $item['quantity'];
                    }
                @endphp
                <tr data-toggle="collapse" data-target="#orderDetails{{ $order->id }}" class="clickable">
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>${{ number_format($totalCost, 2) }}</td>
                    <td>
                        @if($order->status === 'Pending')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-primary">Mark as Shipped</button>
                            </form>
                        @else
                            <span class="badge badge-success">Shipped</span>
                        @endif
                    </td>
                </tr>
                <tr id="orderDetails{{ $order->id }}" class="collapse">
                    <td colspan="5">
                        <div class="p-3">
                            <h5>Order Details</h5>
                            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                            <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            <p><strong>Items:</strong></p>
                            <ul>
                                @foreach($items as $item)
                                    @php
                                        $itemTotal = $item['quantity'] * $item['price'];
                                    @endphp
                                    <li>
                                        <img src="{{ asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width: 50px;">
                                        {{ $item['name'] }} - Quantity: {{ $item['quantity'] }} - Price: ${{ number_format($item['price'], 2) }} - Total: ${{ number_format($itemTotal, 2) }}
                                    </li>
                                @endforeach
                            </ul>
                            <p><strong>Total Cost:</strong> ${{ number_format($totalCost, 2) }}</p>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
