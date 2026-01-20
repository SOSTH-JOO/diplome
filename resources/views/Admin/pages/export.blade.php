@extends('Admin.layouts.app2')

@section('title', 'Export des Auditeurs')

@section('content')

<main class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 min-h-screen p-8">

    <div class="max-w-7xl mx-auto">
        
        <!-- Card principale avec effet glassmorphism -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-8 mb-6">

            <!-- En-tête avec gradient -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-black bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        📄 Export des Étudiants
                    </h1>
                    <p class="text-gray-600 text-sm font-medium">Gérez et exportez vos données académiques</p>
                </div>
                <a href="{{ route('admin.diplome') }}"
                   class="group relative bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour
                    </span>
                </a>
            </div>

            <!-- Messages de succès/erreur avec animations -->
            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 px-6 py-4 rounded-xl shadow-lg mb-6 animate-slide-in" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-green-800 font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 px-6 py-4 rounded-xl shadow-lg mb-6 animate-slide-in" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-red-800 font-semibold">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Formulaire de sélection avec design moderne -->
            <form method="GET" action="{{ route('admin.export') }}" class="mb-8">
                <div class="relative bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-[2px] rounded-2xl shadow-xl">
                    <div class="bg-white rounded-2xl p-6">
                        <label class="flex items-center gap-2 text-xl font-bold text-gray-800 mb-4">
                            <span class="text-3xl">🎓</span>
                            <span>Sélectionnez une classe</span>
                        </label>
                        <div class="flex gap-4 items-end">
                            <div class="flex-1 relative">
                                <select name="classe_id"
                                        class="w-full appearance-none border-2 border-indigo-200 rounded-xl px-5 py-4 pr-12 focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 text-lg font-medium text-gray-800 bg-white transition-all duration-300 cursor-pointer hover:border-indigo-400"
                                        required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}"
                                                {{ ($selectedClasse && $selectedClasse->id == $classe->id) ? 'selected' : '' }}>
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            <button type="submit"
                                    class="group bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl shadow-xl font-bold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Afficher
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Tableau des auditeurs avec design premium -->
            @if($auditeurs->isNotEmpty())
                <div class="mb-6 flex justify-between items-center bg-gradient-to-r from-gray-50 to-indigo-50 p-5 rounded-xl border border-indigo-100">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total des étudiants</p>
                            <p class="text-2xl font-black text-indigo-600">{{ $auditeurs->count() }}</p>
                        </div>
                    </div>

                    <!-- Bouton Export premium -->
                    <form method="POST" action="{{ route('admin.export.excel') }}">
                        @csrf
                        <input type="hidden" name="classe_id" value="{{ $selectedClasse->id }}">
                        <button type="submit"
                                class="group relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-8 py-4 rounded-xl shadow-2xl font-bold transition-all duration-300 transform hover:scale-105">
                            <div class="absolute inset-0 bg-white/20 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                            <span class="relative flex items-center gap-3">
                                <svg class="w-6 h-6 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Exporter en Excel
                            </span>
                        </button>
                    </form>
                </div>

                <div class="overflow-hidden shadow-2xl rounded-2xl border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse bg-white">
                            <thead>
                                <tr class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Photo</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">ID</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Nom</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Prénom</th>
                                    <th class="p-4 text-center text-white font-bold text-sm uppercase tracking-wider">Genre</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Téléphone</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Date de naissance</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Pays de naissance</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Ville de naissance</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Pays de résidence</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Ville résidence</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Poste</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Employeur</th>
                                    <th class="p-4 text-left text-white font-bold text-sm uppercase tracking-wider">Email</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach($auditeurs as $index => $auditeur)
                                    <tr class="group hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/50' }}">
                                        <!-- Photo avec effet hover -->
                                        <td class="p-4">
                                            @if($auditeur->photo)
                                                <div class="relative">
                                                    <img src="{{ asset('storage/' . $auditeur->photo) }}"
                                                         alt="Photo de {{ $auditeur->prenom }}"
                                                         class="w-14 h-14 rounded-xl object-cover border-3 border-indigo-200 group-hover:border-indigo-400 transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                                                    <div class="absolute inset-0 rounded-xl bg-gradient-to-tr from-indigo-600/20 to-purple-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                </div>
                                            @else
                                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-black text-lg border-3 border-indigo-200 group-hover:border-indigo-400 transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg">
                                                    {{ strtoupper(substr($auditeur->prenom, 0, 1)) }}{{ strtoupper(substr($auditeur->nom, 0, 1)) }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- ID -->
                                        <td class="p-4">
                                            <span class="inline-block bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg font-bold text-sm">
                                                {{ $auditeur->auditeur_id }}
                                            </span>
                                        </td>

                                        <!-- Nom -->
                                        <td class="p-4">
                                            <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ strtoupper($auditeur->nom) }}
                                            </div>
                                        </td>

                                        <!-- Prénom -->
                                        <td class="p-4">
                                            <div class="font-medium text-gray-700">{{ ucwords($auditeur->prenom) }}</div>
                                        </td>

                                        <!-- Genre avec design amélioré -->
                                        <td class="p-4 text-center">
                                            @if(strtoupper($auditeur->genre) == 'MASCULIN' || strtoupper($auditeur->genre) == 'M')
                                                <span class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                                    </svg>
                                                    M
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 bg-gradient-to-r from-pink-100 to-pink-200 text-pink-700 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                                    </svg>
                                                    F
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Téléphone -->
                                        <td class="p-4 text-gray-700 font-medium">{{ $auditeur->telephone ?? 'N/A' }}</td>

                                        <!-- Date de naissance -->
                                        <td class="p-4 text-gray-700">{{ $auditeur->date_naissance ?? 'N/A' }}</td>
                                        
                                        <!-- Pays de naissance -->
                                        <td class="p-4 text-gray-700">{{ $auditeur->Pays_naiss ?? 'N/A' }}</td>

                                        <!-- Ville de naissance -->
                                        <td class="p-4 text-gray-700">{{ $auditeur->lieu_naissance ?? 'N/A' }}</td>

                                        <!-- Pays de résidence -->
                                        <td class="p-4 text-gray-700">{{ $auditeur->pays_residence ?? 'N/A' }}</td>

                                        <!-- Ville de résidence -->
                                        <td class="p-4 text-gray-700">{{ $auditeur->ville_residence ?? 'N/A' }}</td>

                                        <!-- Poste -->
                                        <td class="p-4 text-gray-700">{{ $auditeur->poste_occupe ?? 'N/A' }}</td>

                                        <!-- Employeur -->
                                        <td class="p-4 text-gray-700">{{ $auditeur->employeur ?? 'N/A' }}</td>

                                        <!-- Email -->
                                        <td class="p-4">
                                            <span class="text-gray-700 text-sm font-mono bg-gray-100 px-2 py-1 rounded">
                                                {{ $auditeur->mail_exact ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @elseif($selectedClasse)
                <div class="relative overflow-hidden bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-400 p-8 rounded-2xl shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 bg-yellow-400 p-4 rounded-xl">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl text-yellow-800 font-bold mb-1">
                                Aucun auditeur validé trouvé
                            </p>
                            <p class="text-yellow-700">
                                Pour la classe "{{ $selectedClasse->nom }}"
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 border-2 border-blue-200 p-12 rounded-2xl text-center shadow-xl">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-200 rounded-full opacity-20"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-purple-200 rounded-full opacity-20"></div>
                    <div class="relative">
                        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-2xl text-gray-800 font-black mb-2">
                            Sélectionnez une classe
                        </p>
                        <p class="text-gray-600">
                            Pour afficher les auditeurs validés
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>

</main>

<style>
@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-in {
    animation: slide-in 0.5s ease-out;
}
</style>

@endsection