@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Galerie produits</h1>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form method="GET" action="{{ route('products.index') }}" style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input
                type="text"
                name="search"
                placeholder="Rechercher un produit..."
                value="{{ $search }}"
                style="padding: 8px; min-width: 250px;"
            >

            <select name="category" style="padding: 8px;">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (string)$categoryId === (string)$category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit">Filtrer</button>
            <a href="{{ route('products.index') }}">Réinitialiser</a>
        </form>

        @if($products->isEmpty())
            <p>Aucun produit trouvé.</p>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
                @foreach($products as $product)
                    <div style="border: 1px solid #ddd; border-radius: 10px; padding: 15px; background: #fff;">

                        @if($product->images->count())
                            <a href="{{ route('products.show', $product) }}">
                                <img
                                    src="{{ asset('storage/' . $product->images->first()->path) }}"
                                    alt="{{ $product->name }}"
                                    style="width: 100%; height: 220px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;"
                                >
                            </a>
                        @elseif($product->image)
                            <a href="{{ route('products.show', $product) }}">
                                <img
                                    src="{{ $product->image }}"
                                    alt="{{ $product->name }}"
                                    style="width: 100%; height: 220px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;"
                                >
                            </a>
                        @else
                            <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: inherit;">
                                <div style="width: 100%; height: 220px; background: #f3f3f3; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 12px;">
                                    <span>Pas d’image</span>
                                </div>
                            </a>
                        @endif

                        <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: inherit;">
                            <h3 style="margin-bottom: 8px;">{{ $product->name }}</h3>
                        </a>

                        <p style="margin-bottom: 8px;">
                            {{ \Illuminate\Support\Str::limit($product->description, 100) }}
                        </p>

                        <p style="margin-bottom: 8px;"><strong>Prix :</strong> {{ number_format($product->price, 2, ',', ' ') }} €</p>
                        <p style="margin-bottom: 8px;"><strong>Stock :</strong> {{ $product->stock }}</p>

                        <p style="margin-bottom: 12px;">
                            <strong>Catégories :</strong>
                            @if($product->categories->count())
                                {{ $product->categories->pluck('name')->join(', ') }}
                            @else
                                Aucune
                            @endif
                        </p>

                        @auth
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                                    @csrf
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 70px; padding: 6px;">
                                    <button type="submit">Ajouter au panier</button>
                                </form>
                            @else
                                <p style="color: red;"><strong>Rupture de stock</strong></p>
                            @endif
                        @else
                            <p>
                                <a href="{{ route('login') }}">Connectez-vous</a> pour ajouter au panier
                            </p>
                        @endauth

                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
