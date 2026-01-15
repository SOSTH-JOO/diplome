@extends('Admin.layouts.app2')

@section('title', 'Export des Auditeurs')

@section('content')

<main class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-xl p-8">

        <!-- En-tête -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-700">📄 Export des Étudiants</h1>
            <a href="{{ route('admin.diplome') }}"
               class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                ← Retour
            </a>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Formulaire de sélection de classe -->
        <form method="GET" action="{{ route('admin.export') }}" class="mb-8">
            <div class="bg-indigo-50 p-6 rounded-lg shadow">
                <label class="block text-lg font-semibold text-indigo-700 mb-3">
                    🎓 Sélectionnez une classe :
                </label>
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <select name="classe_id"
                                class="w-full border-2 border-indigo-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                                required>
                            <option value="">-- Choisir une classe --</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                        {{ ($selectedClasse && $selectedClasse->id == $classe->id) ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg shadow font-semibold transition duration-200">
                        🔍 Afficher
                    </button>
                </div>
            </div>
        </form>

        <!-- Tableau des auditeurs -->
        @if($auditeurs->isNotEmpty())
            <div class="mb-6 flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-700">
                    📊 Total: <span class="text-indigo-600">{{ $auditeurs->count() }}</span> auditeur(s) validé(s)
                </div>

                <!-- Bouton Export -->
                <form method="POST" action="{{ route('admin.export.excel') }}">
                    @csrf
                    <input type="hidden" name="classe_id" value="{{ $selectedClasse->id }}">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-lg font-semibold transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exporter en Excel (avec photos)
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table class="w-full border-collapse bg-white">
                    <thead class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white">
                        <tr>
                            <th class="p-4 text-left">Photo</th>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Nom et Prénom</th>
                            <th class="p-4 text-center">Genre</th>
                            <th class="p-4 text-left">Téléphone</th>
                            <th class="p-4 text-left">Date de naissance</th>
                            <th class="p-4 text-left">Lieu de naissance</th>
                            <th class="p-4 text-left">Pays</th>
                            <th class="p-4 text-left">Ville</th>
                            <th class="p-4 text-left">Poste</th>
                            <th class="p-4 text-left">Employeur</th>
                            <th class="p-4 text-left">Filière</th>
                            <th class="p-4 text-left">Email</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($auditeurs as $index => $auditeur)
                            <tr class="hover:bg-gray-50 transition duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <!-- Photo -->
                                <td class="p-4">
                                    @if($auditeur->photo)
                                        <img src="{{ asset('storage/' . $auditeur->photo) }}"
                                             alt="Photo de {{ $auditeur->prenom }}"
                                             class="w-12 h-12 rounded-full object-cover border-2 border-indigo-300">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold border-2 border-gray-400">
                                            {{ strtoupper(substr($auditeur->prenom, 0, 1)) }}{{ strtoupper(substr($auditeur->nom, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>

                                <!-- ID -->
                                <td class="p-4 font-semibold text-indigo-600">{{ $auditeur->auditeur_id }}</td>

                                <!-- Nom et Prénom -->
                                <td class="p-4">
                                    <div class="font-semibold text-gray-800">{{ strtoupper($auditeur->nom) }}</div>
                                    <div class="text-sm text-gray-600">{{ ucwords($auditeur->prenom) }}</div>
                                </td>

                                <!-- Genre -->
                                <td class="p-4 text-center">
                                    @if(strtoupper($auditeur->genre) == 'MASCULIN' || strtoupper($auditeur->genre) == 'M')
                                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">M</span>
                                    @else
                                        <span class="inline-block bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-sm font-semibold">F</span>
                                    @endif
                                </td>

                                <!-- Téléphone -->
                                <td class="p-4 text-gray-700">{{ $auditeur->telephone ?? 'N/A' }}</td>

                                <!-- Date de naissance -->
                                <td class="p-4 text-gray-700">{{ $auditeur->date_naissance ?? 'N/A' }}</td>

                                <!-- Lieu de naissance -->
                                <td class="p-4 text-gray-700">{{ $auditeur->lieu_naissance ?? 'N/A' }}</td>

                                <!-- Pays -->
                                <td class="p-4 text-gray-700">{{ $auditeur->pays_residence ?? 'N/A' }}</td>

                                <!-- Ville -->
                                <td class="p-4 text-gray-700">{{ $auditeur->ville_residence ?? 'N/A' }}</td>

                                <!-- Poste -->
                                <td class="p-4 text-gray-700">{{ $auditeur->poste_occupe ?? 'N/A' }}</td>

                                <!-- Employeur -->
                                <td class="p-4 text-gray-700">{{ $auditeur->employeur ?? 'N/A' }}</td>

                                <!-- Filière -->
                                <td class="p-4">
                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">
                                        {{ $auditeur->filiere ?? 'N/A' }}
                                    </span>
                                </td>

                                <!-- Email -->
                                <td class="p-4 text-gray-700 text-sm">{{ $auditeur->mail_exact ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @elseif($selectedClasse)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-lg text-yellow-700 font-semibold">
                            Aucun auditeur validé trouvé pour la classe "{{ $selectedClasse->nom }}"
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg text-center">
                <svg class="mx-auto h-12 w-12 text-blue-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg text-blue-700 font-semibold">
                    Veuillez sélectionner une classe pour afficher les auditeurs validés
                </p>
            </div>
        @endif

    </div>

</main>

@endsection
