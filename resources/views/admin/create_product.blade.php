<!-- resources/views/admin/create_product.blade.php -->
@extends('layouts.app')

@section('title', 'Create Product')

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
<h1>Create Product</h1>
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" step="0.01" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" name="stock" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" name="image" class="form-control" required>
        @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save Product</button>
</form>
@endsection
