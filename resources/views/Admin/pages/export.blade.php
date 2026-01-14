@extends('Admin.layouts.app2')

@section('title', 'acceuil_export')

@section('content')

<main class="bg-gray-100 min-h-screen p-8">

<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-xl p-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-indigo-700">📄 Liste complète des étudiants</h1>
        <a href="{{ route('admin.diplome') }}"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                    👤 Retour
                </a>
        <a href="#"
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow">
            ⬇️ Exporter en Excel
        </a>
    </div>
    <form method="GET" class="mb-6 flex flex-col md:flex-row gap-4 items-center">

    <!-- Recherche -->
    <input type="text"
           name="search"
           value="{{ $search ?? '' }}"
           placeholder="🔍 Rechercher par nom, prénom ou email"
           class="w-full md:w-1/2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">

    <!-- Filtre statut -->
    <select name="status"
            class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500">
        <option value="">Tous les statuts</option>
        <option value="en_attente" {{ ($status ?? '') === 'en_attente' ? 'selected' : '' }}>En attente</option>
        <option value="valide" {{ ($status ?? '') === 'valide' ? 'selected' : '' }}>Validé</option>
        <option value="rejete" {{ ($status ?? '') === 'rejete' ? 'selected' : '' }}>Rejeté</option>
    </select>

    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
        Rechercher
    </button>

</form>



    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Prénom</th>
                    <th class="p-3">ID</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Filière</th>
                    <th class="p-3">Statut</th>
                </tr>
            </thead>

            <tbody class="divide-y">

            </tbody>
        </table>
    </div>

</div>

</main>
@endsection
