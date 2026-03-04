@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer un produit</h1>

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

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div>
                <label>Nom</label>
                <input type="text" name="name" required>
            </div>

            <div>
                <label>Description</label>
                <textarea name="description" required></textarea>
            </div>

            <div>
                <label>Prix</label>
                <input type="number" step="0.01" name="price" required>
            </div>

            <div>
                <label>Stock</label>
                <input type="number" name="stock" required>
            </div>

            <div style="margin-top: 10px;">
                <label>Catégories</label><br>

                @forelse($categories as $category)
                    <label style="display:block;">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                @empty
                    <p>Aucune catégorie. Crée-en d’abord.</p>
                @endforelse
            </div>

            <button type="submit">Enregistrer</button>
        </form>
    </div>
@endsection
