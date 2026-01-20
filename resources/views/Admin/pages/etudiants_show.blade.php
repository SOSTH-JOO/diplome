@extends('Admin.layouts.app2')

@section('title', 'Détails de l\'auditeur')

@section('content')

<main class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 min-h-screen p-8 relative overflow-hidden">
    <!-- Éléments décoratifs de fond -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
    
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl p-0 backdrop-blur-sm relative overflow-hidden">
        <!-- Bande décorative en haut -->
        <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        
        <div class="p-8">

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

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent flex items-center">
                    <span class="text-5xl mr-3">👨‍🎓</span>
                    Détails de l'auditeur
                </h1>
                <p class="text-gray-500 mt-2 ml-16">Profil complet et informations détaillées</p>
            </div>

            {{-- Badge de statut --}}
            <div class="px-6 py-3 rounded-full font-bold text-sm shadow-lg transform transition-all duration-200 hover:scale-105
                {{ $auditeur->is_active ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white' : 'bg-gradient-to-r from-red-400 to-rose-500 text-white' }}">
                <span class="flex items-center">
                    @if($auditeur->is_active)
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Actif
                    @else
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Inactif
                    @endif
                </span>
            </div>
        </div>

        {{-- Photo de profil --}}
        <div class="flex justify-center mb-10">
            <div class="relative group">
                @if($auditeur->photo)
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition duration-300"></div>
                    <img src="{{ asset('storage/' . $auditeur->photo) . '?v=' . time() }}"
                         alt="Photo de {{ $auditeur->nom }}"
                         class="relative w-48 h-48 rounded-full object-cover border-4 border-white shadow-2xl ring-4 ring-indigo-100 transform transition duration-300 group-hover:scale-105">
                @else
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition duration-300"></div>
                    <div class="relative w-48 h-48 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center border-4 border-white shadow-2xl ring-4 ring-indigo-100 transform transition duration-300 group-hover:scale-105">
                        <span class="text-5xl font-bold text-indigo-600">
                            {{ strtoupper(substr($auditeur->nom, 0, 1)) }}{{ strtoupper(substr($auditeur->prenom, 0, 1)) }}
                        </span>
                    </div>
                @endif

                {{-- Badge statut sur la photo --}}
                <div class="absolute bottom-3 right-3 transform transition duration-300 group-hover:scale-110">
                    <div class="w-8 h-8 rounded-full border-4 border-white shadow-lg
                        {{ $auditeur->is_active ? 'bg-gradient-to-r from-green-400 to-emerald-500' : 'bg-gradient-to-r from-red-400 to-rose-500' }}
                        animate-pulse">
                    </div>
                </div>
            </div>
        </div>

        {{-- Informations principales --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-2xl border border-indigo-100 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <div class="bg-indigo-500 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <p class="font-bold text-indigo-700 text-sm uppercase tracking-wide">Matricule</p>
                </div>
                <p class="text-2xl font-bold text-indigo-900 ml-12">{{ $auditeur->auditeur_id }}</p>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border border-purple-100 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center mb-2">
                    <div class="bg-purple-500 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="font-bold text-purple-700 text-sm uppercase tracking-wide">Statut du profil</p>
                </div>
                <p class="text-xl font-bold ml-12">
                    @if($auditeur->is_open)
                        <span class="text-green-600 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Profil complété
                        </span>
                    @else
                        <span class="text-yellow-600 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Profil incomplet
                        </span>
                    @endif
                </p>
            </div>
        </div>

        {{-- Informations détaillées --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="flex items-center mb-4">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-3 rounded-xl mr-3 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Informations personnelles</h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Nom complet</p>
                    <p class="text-lg font-bold text-gray-800">{{ $auditeur->nom }} {{ $auditeur->prenom }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Genre</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->genre ?? 'Non spécifié' }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-pink-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Date de naissance</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->date_naissance ? $auditeur->date_naissance->format('d/m/Y') : 'Non spécifié' }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Ville de naissance</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->lieu_naissance ?? 'Non spécifié' }}</p>
                </div>
                
                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Pays de naissance</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->Pays_naiss ?? 'Non spécifié' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center mb-4">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-3 rounded-xl mr-3 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Coordonnées</h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Email principal</p>
                    <p class="text-lg text-gray-700 break-all">{{ $auditeur->mail_exact ?? 'Non spécifié' }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Email d'ajout</p>
                    <p class="text-lg text-gray-700 break-all">{{ $auditeur->mail_ajout }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-pink-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Téléphone</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->telephone ?? 'Non spécifié' }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Résidence</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->ville_residence ?? 'Non spécifié' }}, {{ $auditeur->pays_residence ?? 'Non spécifié' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center mb-4">
                    <div class="bg-gradient-to-r from-indigo-500 to-blue-500 p-3 rounded-xl mr-3 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Situation professionnelle</h3>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Poste occupé</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->poste_occupe ?? 'Non spécifié' }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Employeur</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->employeur ?? 'Non spécifié' }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center mb-4">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-3 rounded-xl mr-3 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Informations académiques</h3>
                </div>

                @if($auditeur->classe)
                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Classe</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->classe->nom }}</p>
                </div>
                @endif

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Date d'inscription</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->created_at ? $auditeur->created_at->format('d/m/Y H:i') : 'Non spécifié' }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-pink-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Dernière mise à jour</p>
                    <p class="text-lg text-gray-700">{{ $auditeur->updated_at ? $auditeur->updated_at->format('d/m/Y H:i') : 'Non spécifié' }}</p>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border-l-4 border-indigo-500 hover:shadow-md transition-shadow duration-200">
                    <p class="font-semibold text-gray-500 text-xs uppercase tracking-wide mb-1">Profil complété</p>
                    <p class="text-lg">
                        @if($auditeur->is_open)
                            <span class="text-green-600 font-bold">Oui</span>
                        @else
                            <span class="text-yellow-600 font-bold">Non</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div class="mt-12 pt-8 border-t-2 border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 gap-4">
                {{-- Bouton Retour --}}
                <a href="{{ route('admin.diplome') }}"
                   class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-8 py-4 rounded-xl font-bold flex items-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à la liste
                </a>

                {{-- Boutons Activer/Rejeter --}}
                <div class="flex flex-wrap gap-4">
                    @if(!$auditeur->is_active)
                        {{-- Bouton Activer avec popup --}}
                        <button type="button"
                                onclick="openActivationModal()"
                                class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-4 rounded-xl font-bold flex items-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Activer l'auditeur
                        </button>
                    @else
                        {{-- Bouton Désactiver/Rejeter --}}
                        <form action="{{ route('admin.etudiants.reject', $auditeur->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-8 py-4 rounded-xl font-bold flex items-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                                    onclick="return confirm('Êtes-vous sûr de vouloir désactiver cet auditeur ?')">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                class="bg-gradient-to-r from-gray-700 to-gray-800 hover:from-gray-800 hover:to-gray-900 text-white px-8 py-4 rounded-xl font-bold flex items-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>

</main>

{{-- Modal de validation --}}
<div id="activationModal" class="hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn">
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-2xl max-w-lg w-full p-0 transform transition-all scale-95 modal-content">
        <!-- Header avec gradient -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-3xl p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>
            
            <div class="flex justify-between items-center relative z-10">
                <div class="flex items-center space-x-3">
                    <div class="bg-white bg-opacity-20 p-3 rounded-xl backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Validation de l'auditeur</h2>
                        <p class="text-indigo-100 text-sm">Vérification des informations</p>
                    </div>
                </div>
                <button onclick="closeActivationModal()" class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="activationForm" action="{{ route('admin.etudiants.activate', $auditeur->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="mb-8">
                <label class="block text-gray-800 font-bold mb-4 text-lg">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Les informations sont-elles complètes ?
                    </span>
                </label>
                
                <div class="space-y-4">
                    <label class="relative flex items-start p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 hover:shadow-lg transition-all duration-200 group">
                        <input type="radio" name="info_complete" value="oui" class="w-5 h-5 text-green-600 mt-1" required>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-green-600 text-lg flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Oui, tout est complet
                                </span>
                                <div class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Validation</div>
                            </div>
                            <p class="text-gray-600 mt-2 text-sm">Envoyer un email de confirmation et d'activation</p>
                        </div>
                        <div class="absolute inset-0 bg-green-50 opacity-0 group-hover:opacity-100 rounded-xl transition-opacity duration-200 -z-10"></div>
                    </label>

                    <label class="relative flex items-start p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-orange-400 hover:shadow-lg transition-all duration-200 group">
                        <input type="radio" name="info_complete" value="non" class="w-5 h-5 text-orange-600 mt-1" required>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-orange-600 text-lg flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Non, informations incomplètes
                                </span>
                                <div class="bg-orange-100 text-orange-800 text-xs font-semibold px-3 py-1 rounded-full">Rectification</div>
                            </div>
                            <p class="text-gray-600 mt-2 text-sm">Demander à l'auditeur de compléter son profil</p>
                        </div>
                        <div class="absolute inset-0 bg-orange-50 opacity-0 group-hover:opacity-100 rounded-xl transition-opacity duration-200 -z-10"></div>
                    </label>
                </div>
            </div>

            <div id="messageSection" class="mb-8 hidden opacity-0 transition-all duration-300">
                <label for="message" class="block text-gray-800 font-bold mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                    </svg>
                    Message personnalisé
                    <span class="text-gray-500 text-sm font-normal ml-2">(optionnel)</span>
                </label>
                <div class="relative">
                    <textarea name="message" id="message" rows="4" 
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 resize-none"
                              placeholder="Ajoutez un message personnalisé pour l'auditeur..."></textarea>
                    <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                        <span id="charCount">0</span>/500
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="button" 
                        onclick="closeActivationModal()"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-4 rounded-xl font-bold transition-all duration-200 hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </button>
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-4 rounded-xl font-bold transition-all duration-200 hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

.modal-content {
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        transform: scale(0.95) translateY(-20px);
        opacity: 0;
    }
    to {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
}

#messageSection.show {
    opacity: 1;
}
</style>

<script>
function openActivationModal() {
    const modal = document.getElementById('activationModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('.modal-content').style.transform = 'scale(1)';
    }, 10);
}

function closeActivationModal() {
    const modal = document.getElementById('activationModal');
    const modalContent = modal.querySelector('.modal-content');
    modalContent.style.transform = 'scale(0.95)';
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('activationForm').reset();
        const messageSection = document.getElementById('messageSection');
        messageSection.classList.add('hidden');
        messageSection.classList.remove('show');
    }, 200);
}

// Afficher le champ de message avec animation
document.querySelectorAll('input[name="info_complete"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const messageSection = document.getElementById('messageSection');
        messageSection.classList.remove('hidden');
        setTimeout(() => {
            messageSection.classList.add('show');
        }, 10);
    });
});

// Compteur de caractères pour le textarea
const messageTextarea = document.getElementById('message');
if (messageTextarea) {
    messageTextarea.addEventListener('input', function() {
        const charCount = this.value.length;
        document.getElementById('charCount').textContent = charCount;
        
        // Limiter à 500 caractères
        if (charCount > 500) {
            this.value = this.value.substring(0, 500);
            document.getElementById('charCount').textContent = '500';
        }
    });
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('activationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeActivationModal();
    }
});

// Fermer le modal avec la touche Échap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('activationModal');
        if (!modal.classList.contains('hidden')) {
            closeActivationModal();
        }
    }
});
</script>

@endsection