@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Créer une catégorie</h1>

        @if($errors->any())
            <ul style="color:red;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST">

            @csrf

            <div>
                <label>Nom de la catégorie</label>
                <input type="text" name="name" required>
            </div>

            <br>

            <button type="submit">Créer</button>

        </form>

    </div>
@endsection
