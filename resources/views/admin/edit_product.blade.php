<!-- resources/views/admin/edit_product.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<h1>Edit Product</h1>
<form action="{{ route('admin.products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
    </div>
    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
    </div>
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" name="image" class="form-control" required>
        @if($product->image)
            <img src="{{ asset('images/products/' . $product->image) }}" alt="Product Image" class="img-thumbnail mt-2" width="150">
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
