@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Catégories</h1>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <a href="{{ route('admin.categories.create') }}">Créer une catégorie</a>

        <ul style="margin-top: 20px;">
            @forelse($categories as $category)
                <li>
                    #{{ $category->id }} — {{ $category->name }}
                    <a href="{{ route('admin.categories.edit', $category) }}">Modifier</a>

                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Supprimer</button>
                    </form>
                </li>
            @empty
                <li>Aucune catégorie</li>
            @endforelse
        </ul>
    </div>
@endsection
