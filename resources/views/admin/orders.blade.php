<!-- resources/views/admin/orders.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Order Management</h1>
    @foreach($orders as $order)
        <div class="card my-3">
            <div class="card-body">
                <h5>Order #{{ $order->id }} - {{ ucfirst($order->status) }}</h5>
                <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                <ul>
                    @foreach($order->products as $product)
                        <li>{{ $product->name }} - Quantity: {{ $product->pivot->quantity }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" class="mt-3">
                    @csrf
                    <select name="status" class="form-select">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
