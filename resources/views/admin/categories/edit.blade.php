@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Modifier la catégorie</h1>

        @if($errors->any())
            <ul style="color:red;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">

            @csrf
            @method('PUT')

            <div>
                <label>Nom de la catégorie</label>
                <input type="text" name="name" value="{{ $category->name }}" required>
            </div>

            <br>

            <button type="submit">Mettre à jour</button>

        </form>

    </div>
@endsection
