@extends('Auditeur.layouts.app')

@section('title', 'Profil Auditeur')

@section('content')

<main class="bg-gray-100 min-h-screen py-10">
    {{-- Messages de notification --}}
    @if(session('success'))
        <div class="max-w-5xl mx-auto mb-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-5xl mx-auto mb-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Veuillez corriger les erreurs suivantes :</span>
                </div>
                <ul class="list-disc list-inside ml-2">
                    @foreach($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto">
        {{-- Déconnexion --}}
        <div class="flex justify-end mb-6">
            <form method="POST" action="{{ route('auditeur.logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Se déconnecter
                </button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="border-b pb-4 mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Compléter mon Profil d'Auditeur</h2>
                <p class="text-gray-600 text-sm">Veuillez remplir ou mettre à jour toutes vos informations.</p>
            </div>

            <form action="{{ route('auditeur.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Informations Personnelles --}}
                <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-500">
                    <h3 class="text-lg font-semibold text-blue-700 mb-4 italic">1. Informations Personnelles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Champs non modifiables --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Matricule</label>
                            <input type="text" value="{{ $auditeur->auditeur_id }}"
                                   class="block w-full bg-gray-100 border-gray-300 rounded-md p-2 text-gray-600 cursor-not-allowed"
                                   disabled>
                            <input type="hidden" name="auditeur_id" value="{{ $auditeur->auditeur_id }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email d'ajout</label>
                            <input type="email" value="{{ $auditeur->mail_ajout }}"
                                   class="block w-full bg-gray-100 border-gray-300 rounded-md p-2 text-gray-600 cursor-not-allowed"
                                   disabled>
                        </div>

                        {{-- Champs modifiables --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                            <input type="text" name="nom" value="{{ old('nom', $auditeur->nom) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('nom') border-red-500 @enderror"
                                   required>
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                            <input type="text" name="prenom" value="{{ old('prenom', $auditeur->prenom) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('prenom') border-red-500 @enderror"
                                   required>
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Genre *</label>
                            <select name="genre"
                                    class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('genre') border-red-500 @enderror"
                                    required>
                                <option value="">Choisir...</option>
                                <option value="Masculin" {{ old('genre', $auditeur->genre) == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                <option value="Féminin" {{ old('genre', $auditeur->genre) == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('genre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                            <input type="text" name="telephone" value="{{ old('telephone', $auditeur->telephone) }}"
                                   placeholder="+225..."
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('telephone') border-red-500 @enderror"
                                   required>
                            @error('telephone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Origine et Naissance --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold border-b pb-2">Origine et Naissance</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance *</label>
                            <input type="date" name="date_naissance" value="{{ old('date_naissance', $auditeur->date_naissance?->format('Y-m-d')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('date_naissance') border-red-500 @enderror"
                                   required>
                            @error('date_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lieu de naissance *</label>
                            <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $auditeur->lieu_naissance) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('lieu_naissance') border-red-500 @enderror"
                                   required>
                            @error('lieu_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Résidence Actuelle --}}
                    <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-semibold border-b pb-2">Résidence Actuelle</h3>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pays de résidence *</label>
                            <input type="text" name="pays_residence" value="{{ old('pays_residence', $auditeur->pays_residence) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('pays_residence') border-red-500 @enderror"
                                   required>
                            @error('pays_residence')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ville de résidence *</label>
                            <input type="text" name="ville_residence" value="{{ old('ville_residence', $auditeur->ville_residence) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('ville_residence') border-red-500 @enderror"
                                   required>
                            @error('ville_residence')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Situation Professionnelle --}}
                <div class="bg-gray-50 p-6 rounded-lg border">
                    <h3 class="text-lg font-semibold mb-4">Situation Professionnelle</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poste occupé *</label>
                            <input type="text" name="poste_occupe" value="{{ old('poste_occupe', $auditeur->poste_occupe) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('poste_occupe') border-red-500 @enderror"
                                   required>
                            @error('poste_occupe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Employeur *</label>
                            <input type="text" name="employeur" value="{{ old('employeur', $auditeur->employeur) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('employeur') border-red-500 @enderror"
                                   required>
                            @error('employeur')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Filière *</label>
                            <input type="text" name="filiere" value="{{ old('filiere', $auditeur->filiere) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('filiere') border-red-500 @enderror"
                                   required>
                            @error('filiere')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Champs non modifiable --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                            <input type="text" value="{{ old('classe_id', $auditeur->classe?->nom ?? 'Non assigné') }}"
                                   class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md p-2 text-gray-600 cursor-not-allowed"
                                   disabled>
                        </div>
                    </div>
                </div>

                {{-- Informations Complémentaires --}}
                <div class="bg-gray-50 p-6 rounded-lg border">
                    <h3 class="text-lg font-semibold mb-4">Informations Complémentaires</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email exact</label>
                            <input type="email" name="mail_exact" value="{{ old('mail_exact', $auditeur->mail_exact) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('mail_exact') border-red-500 @enderror">
                            @error('mail_exact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Champ identifiant --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Identifiant *</label>
                            <input type="text" name="identifiant" value="{{ old('identifiant', $auditeur->identifiant) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500 @error('identifiant') border-red-500 @enderror"
                                   required>
                            @error('identifiant')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Photo --}}
                <div class="p-6 border-2 border-dashed border-gray-300 rounded-md">
                    <h3 class="text-md font-semibold mb-4">Photo de profil</h3>
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div class="flex-1">
                            <input type="file" name="photo" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">Taille maximale : 2 Mo. Formats acceptés : JPG, PNG, GIF</p>
                        </div>
                        @if($auditeur->photo)
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-2">Photo actuelle :</p>
                                <img src="{{ asset('storage/' . $auditeur->photo) }}" alt="Photo de profil" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-md">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bouton --}}
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enregistrer mon Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection
