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
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>${{ $order->total }}</td>
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
            @endforeach
        </tbody>
    </table>
</div>
@endsection
