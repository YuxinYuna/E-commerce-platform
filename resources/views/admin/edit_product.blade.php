<!-- resources/views/admin/edit_product.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<h1>Edit Product</h1>
<form action="{{ route('admin.products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
    </div>
    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
