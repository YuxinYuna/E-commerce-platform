<!-- resources/views/shop/checkout.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Order Summary</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>${{ $item->product->price * $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
@endsection
