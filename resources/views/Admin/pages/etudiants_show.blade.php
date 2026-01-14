@extends('Admin.layouts.app2')

@section('title', 'Détails de l\'auditeur')

@section('content')

<main class="bg-gradient-to-br from-indigo-600 to-purple-700 min-h-screen p-8">

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl p-8">

        {{-- Messages de notification --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-700">
                👨‍🎓 Détails de l'auditeur
            </h1>

            {{-- Badge de statut --}}
            <div class="px-4 py-2 rounded-full font-semibold
                {{ $auditeur->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $auditeur->is_active ? 'Actif' : 'Inactif' }}
            </div>
        </div>

        {{-- Photo de profil --}}
        <div class="flex justify-center mb-8">
            <div class="relative">
                @if($auditeur->photo)
                    <img src="{{ asset('storage/' . $auditeur->photo) . '?v=' . time() }}"
                         alt="Photo de {{ $auditeur->nom }}"
                         class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                    <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center border-4 border-white shadow-lg">
                        <span class="text-4xl text-gray-500">
                            {{ strtoupper(substr($auditeur->nom, 0, 1)) }}{{ strtoupper(substr($auditeur->prenom, 0, 1)) }}
                        </span>
                    </div>
                @endif

                {{-- Badge statut sur la photo --}}
                <div class="absolute bottom-2 right-2">
                    <div class="w-6 h-6 rounded-full border-2 border-white
                        {{ $auditeur->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Informations principales --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="font-semibold text-gray-600 text-sm uppercase tracking-wide">Matricule</p>
                <p class="text-lg font-bold text-indigo-700">{{ $auditeur->auditeur_id }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="font-semibold text-gray-600 text-sm uppercase tracking-wide">Statut du profil</p>
                <p class="text-lg">
                    @if($auditeur->is_open)
                        <span class="text-green-600 font-semibold">✓ Profil complété</span>
                    @else
                        <span class="text-yellow-600 font-semibold">⏳ Profil incomplet</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Informations détaillées --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Informations personnelles</h3>

                <div>
                    <p class="font-semibold text-gray-600">Nom complet</p>
                    <p class="text-lg">{{ $auditeur->nom }} {{ $auditeur->prenom }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Genre</p>
                    <p class="text-lg">{{ $auditeur->genre ?? 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Date de naissance</p>
                    <p class="text-lg">{{ $auditeur->date_naissance ? $auditeur->date_naissance->format('d/m/Y') : 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Lieu de naissance</p>
                    <p class="text-lg">{{ $auditeur->lieu_naissance ?? 'Non spécifié' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Coordonnées</h3>

                <div>
                    <p class="font-semibold text-gray-600">Email principal</p>
                    <p class="text-lg">{{ $auditeur->mail_exact ?? 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Email d'ajout</p>
                    <p class="text-lg">{{ $auditeur->mail_ajout }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Téléphone</p>
                    <p class="text-lg">{{ $auditeur->telephone ?? 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Résidence</p>
                    <p class="text-lg">{{ $auditeur->ville_residence ?? 'Non spécifié' }}, {{ $auditeur->pays_residence ?? 'Non spécifié' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Situation professionnelle</h3>

                <div>
                    <p class="font-semibold text-gray-600">Poste occupé</p>
                    <p class="text-lg">{{ $auditeur->poste_occupe ?? 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Employeur</p>
                    <p class="text-lg">{{ $auditeur->employeur ?? 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Filière</p>
                    <p class="text-lg">{{ $auditeur->filiere ?? 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Identifiant</p>
                    <p class="text-lg">{{ $auditeur->identifiant ?? 'Non spécifié' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">Informations académiques</h3>

                @if($auditeur->classe)
                <div>
                    <p class="font-semibold text-gray-600">Classe</p>
                    <p class="text-lg">{{ $auditeur->classe->nom }}</p>
                </div>
                @endif

                <div>
                    <p class="font-semibold text-gray-600">Date d'inscription</p>
                    <p class="text-lg">{{ $auditeur->created_at ? $auditeur->created_at->format('d/m/Y H:i') : 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Dernière mise à jour</p>
                    <p class="text-lg">{{ $auditeur->updated_at ? $auditeur->updated_at->format('d/m/Y H:i') : 'Non spécifié' }}</p>
                </div>

                <div>
                    <p class="font-semibold text-gray-600">Profil complété</p>
                    <p class="text-lg">
                        @if($auditeur->is_open)
                            <span class="text-green-600">Oui</span>
                        @else
                            <span class="text-yellow-600">Non</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div class="mt-10 pt-6 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                {{-- Bouton Retour --}}
                <a href="{{ route('admin.diplome') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold flex items-center transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à la liste
                </a>

                {{-- Boutons Activer/Rejeter --}}
                <div class="flex space-x-4">
                    @if(!$auditeur->is_active)
                        {{-- Bouton Activer --}}
                        <form action="{{ route('admin.etudiants.activate', $auditeur->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold flex items-center transition duration-200"
                                    onclick="return confirm('Êtes-vous sûr de vouloir activer cet auditeur ?')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Activer l'auditeur
                            </button>
                        </form>
                    @else
                        {{-- Bouton Désactiver/Rejeter --}}
                        <form action="{{ route('admin.etudiants.reject', $auditeur->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold flex items-center transition duration-200"
                                    onclick="return confirm('Êtes-vous sûr de vouloir désactiver cet auditeur ?')">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Désactiver l'auditeur
                            </button>
                        </form>
                    @endif

                    {{-- Bouton Supprimer (optionnel) --}}
                    <form action="{{ route('admin.etudiants.destroy', $auditeur->id) }}" method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet auditeur ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold flex items-center transition duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</main>

@endsection
