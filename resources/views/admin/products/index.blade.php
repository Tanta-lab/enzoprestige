@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion des Produits</h1>

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

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Créer un produit</a>

        <table border="1" cellpadding="10" cellspacing="0" style="margin-top:20px; width:100%;">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }} €</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="{{ route('admin.products.show', $product) }}">Voir</a> |
                        <a href="{{ route('admin.products.edit', $product) }}">Modifier</a> |

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucun produit</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
