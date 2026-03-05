@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dashboard Admin</h1>

        <ul>
            <li><strong>Produits :</strong> {{ $productsCount }}</li>
            <li><strong>Catégories :</strong> {{ $categoriesCount }}</li>
            <li><strong>Commandes :</strong> {{ $ordersCount }}</li>
        </ul>

        <p>
            <a href="{{ route('admin.products.index') }}">Gérer les produits</a> |
            <a href="{{ route('admin.categories.index') }}">Gérer les catégories</a>
        </p>
    </div>
@endsection
