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

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" >
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

            <div style="margin-top: 10px;">
                <label>Ajouter de nouvelles images</label>
                <input type="file" name="images[]" multiple accept="image/*">
            </div>

            @if($product->images->count())
                <div style="margin-top: 15px; display:flex; gap:10px; flex-wrap:wrap;">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                    @endforeach
                </div>
            @endif

            <button type="submit">Mettre à jour</button>
        </form>
    </div>
@endsection
