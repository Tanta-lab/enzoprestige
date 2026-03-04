@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le produit</h1>

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

        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label>Nom</label>
                <input type="text" name="name" value="{{ $product->name }}" required>
            </div>

            <div>
                <label>Description</label>
                <textarea name="description" required>{{ $product->description }}</textarea>
            </div>

            <div>
                <label>Prix</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>
            </div>

            <div>
                <label>Stock</label>
                <input type="number" name="stock" value="{{ $product->stock }}" required>
            </div>

            <div style="margin-top: 10px;">
                <label>Catégories</label><br>

                @foreach($categories as $category)
                    <label style="display:block;">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                            {{ $product->categories->contains($category->id) ? 'checked' : '' }}
                        >
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
@endsection
