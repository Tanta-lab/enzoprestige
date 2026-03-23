@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items:start;">

            <div>
                @if($product->images->count())
                    <div style="margin-bottom: 15px;">
                        <img id="main-product-image"
                             src="{{ asset('storage/' . $product->images->first()->path) }}"
                             alt="{{ $product->name }}"
                             style="width:100%; max-width:500px; height:500px; object-fit:cover; border-radius:12px;">
                    </div>

                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        @foreach($product->images as $image)
                            <img
                                src="{{ asset('storage/' . $image->path) }}"
                                alt="{{ $product->name }}"
                                style="width:90px; height:90px; object-fit:cover; border-radius:8px; cursor:pointer; border:1px solid #ddd;"
                                onclick="document.getElementById('main-product-image').src='{{ asset('storage/' . $image->path) }}'"
                            >
                        @endforeach
                    </div>
                @elseif($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width:100%; max-width:500px; height:500px; object-fit:cover; border-radius:12px;">
                @else
                    <div style="width:100%; max-width:500px; height:500px; background:#f3f3f3; display:flex; align-items:center; justify-content:center; border-radius:12px;">
                        Pas d’image
                    </div>
                @endif
            </div>

            <div>
                <p><strong>Prix :</strong> {{ number_format($product->price, 2, ',', ' ') }} €</p>
                <p><strong>Stock :</strong> {{ $product->stock }}</p>

                <p>
                    <strong>Catégories :</strong>
                    @if($product->categories->count())
                        {{ $product->categories->pluck('name')->join(', ') }}
                    @else
                        Aucune
                    @endif
                </p>

                <p style="margin-top:20px;">{{ $product->description }}</p>

                <div style="margin-top: 20px;">
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" style="display:flex; gap:10px; align-items:center;">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width:70px; padding:6px;">
                                <button type="submit">Ajouter au panier</button>
                            </form>
                        @else
                            <p style="color:red;"><strong>Rupture de stock</strong></p>
                        @endif
                    @else
                        <p><a href="{{ route('login') }}">Connectez-vous</a> pour ajouter ce produit au panier.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
