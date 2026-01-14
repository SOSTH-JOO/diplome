@extends('Auditeur.layouts.app')

@section('title', 'Connexion Auditeur')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow w-full max-w-md">
        <h2 class="text-center text-2xl font-bold mb-6">Connexion Auditeur</h2>

        @if ($errors->any())
            <div class="text-red-600 mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('auditeur.login.post') }}">
            @csrf
            <div class="mb-4">
                <label for="auditeur_id" class="block mb-1">Matricule</label>
                <input type="text" name="auditeur_id" id="auditeur_id" value="{{ old('auditeur_id') }}" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white p-2 rounded">Se connecter</button>
        </form>
    </div>
</div>
@endsection
