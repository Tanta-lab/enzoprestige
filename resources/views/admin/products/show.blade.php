@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détail du produit</h1>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if($errors->any())
            <ul style="color: red;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <p><strong>ID :</strong> {{ $product->id }}</p>
        <p><strong>Nom :</strong> {{ $product->name }}</p>
        <p><strong>Description :</strong> {{ $product->description }}</p>
        <p><strong>Prix :</strong> {{ $product->price }} €</p>
        <p><strong>Stock :</strong> {{ $product->stock }}</p>
        <p><strong>Catégories :</strong>
            @if($product->categories->count())
                {{ $product->categories->pluck('name')->join(', ') }}
            @else
                Aucune
            @endif
        </p>

        <a href="{{ route('admin.products.index') }}">Retour</a>
    </div>
@endsection
