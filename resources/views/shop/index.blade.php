@extends('layouts.app')

@section('content')
<style>
    .card{
        border-color: #333;
        border-width: 1px;
    }
    .custom-image-size {
    width: 860px;
    height: 560px;
    object-fit: cover;
    }

    .product-img {
        height: 500px;
        object-fit: cover;
    }

    /* Main action button styling */
    .main-action-button {
        background-color: #007bff;
        color: white;
        border-radius: 30px;
        font-weight: 600; /* Reduce font weight */
        font-size: 0.9rem; /* Make font size smaller */
        padding: 0.4rem 1.2rem;
    }

    /* Secondary button styling */
    .secondary-button {
        border: 1px solid #ddd;
        border-radius: 30px;
        padding: 0.3rem 1rem;
        font-weight: 500; /* Reduce font weight */
        font-size: 0.85rem; /* Make font size smaller */
        color: #333;
        display: flex;
        align-items: center;
    }

    /* Adjust font sizes for product details */
    .card-title {
        font-size: 1rem; /* Smaller title font size */
        font-weight: 500; /* Thinner font */
    }

    .card-text {
        font-size: 0.9rem; /* Smaller font for stock and price */
        font-weight: 400;
    }

    .form-group label {
        font-size: 0.8rem; /* Smaller font size for quantity label */
        font-weight: 400; /* Regular weight for label */
    }

    .secondary-button i {
        margin-right: 5px;
    }
    .quantity-label {
    font-size: 0.8rem;
    font-weight: 500;
    }

    .quantity-selector {
        border: none;
        border-bottom: 1px solid #ccc;
        background: none;
        width: 50px;
        font-size: 0.9rem;
        text-align: center;
        padding: 2px;
        -webkit-appearance: none; /* Remove default styling in Safari */
        -moz-appearance: none; /* Remove default styling in Firefox */
        appearance: none; /* Remove default styling in modern browsers */
    }

    .quantity-selector:focus {
        outline: none;
        border-bottom: 1px solid #007bff; /* Change underline color on focus */
    }

    .main-action-button {
        background-color: rgba(88, 103, 221, 1);
        color: white;
        border-radius: 30px;
        padding: 0.4rem 1.2rem;
        margin-left: 8px; /* Add spacing between dropdown and button */
    }
</style>
<div class="container">
    <!-- Carousel for featured images -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 custom-image-size" src="{{ asset('images/pexels-nietjuh-934070.jpg') }}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 custom-image-size" src="{{ asset('images/pexels-lum3n-44775-322207.jpg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 custom-image-size" src="{{ asset('images/pexels-olly-720606.jpg') }}" alt="Third slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 custom-image-size" src="{{ asset('images/pexels-ron-lach-9532890.jpg') }}" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Product List -->
    <div class="row mt-4">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <!-- Product Image -->
                    @if($product->image)
                        <img src="{{ asset('images/products/' . $product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Placeholder Image">
                    @endif

                    <div class="card-body text-center">
                        <h5 class="card-title" style="height: 40px;">{{ $product->name }}</h5>
                        <div style="margin-bottom: 20px;">
                            <small class="card-text">${{ number_format($product->price, 2) }}</small>
                            <!-- <small class="card-text" >Stock: {{ $product->stock }}</small> -->
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center justify-content-center mb-3">
                                @csrf
                                <label for="quantity-{{ $product->id }}" class="quantity-label mr-2">Qty</label>
                                <select id="quantity-{{ $product->id }}" name="quantity" class="quantity-selector mr-3">
                                    @for($i = 1; $i <= $product->stock; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn main-action-button">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </form>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="button" class="btn secondary-button mr-2">
                                <i class="fas fa-heart"></i> Add To List
                            </button>
                            <button type="button" class="btn secondary-button">
                                <i class="fas fa-share"></i> Share
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
