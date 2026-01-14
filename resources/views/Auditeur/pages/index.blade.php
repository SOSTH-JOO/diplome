@extends('Auditeur.layouts.app')

@section('title', 'Profil Auditeur')

@section('content')

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<main class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12 px-4">
    {{-- Messages de notification --}}
    @if(session('success'))
        <div class="max-w-6xl mx-auto mb-6 animate-fade-in">
            <div class="bg-gradient-to-r from-emerald-500 to-green-500 text-white p-5 rounded-2xl shadow-2xl transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center">
                    <div class="bg-white/20 p-2 rounded-full mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-lg">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-6xl mx-auto mb-6 animate-fade-in">
            <div class="bg-gradient-to-r from-red-500 to-rose-500 text-white p-5 rounded-2xl shadow-2xl">
                <div class="flex items-start">
                    <div class="bg-white/20 p-2 rounded-full mr-4 mt-1">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold text-lg block mb-2">Veuillez corriger les erreurs suivantes :</span>
                        <ul class="space-y-1 ml-2">
                            @foreach($errors->all() as $error)
                                <li class="text-sm flex items-center">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full mr-2"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto">
        {{-- En-tête --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Mon Profil
                </h1>
                <p class="text-gray-600 mt-2">Gérez vos informations personnelles et professionnelles</p>
            </div>
            <form method="POST" action="{{ route('auditeur.logout') }}">
                @csrf
                <button type="submit" class="group bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Se déconnecter
                </button>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold">Compléter mon Profil</h2>
                        <p class="text-blue-100 mt-1">Remplissez toutes vos informations pour finaliser votre inscription</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('auditeur.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                @csrf
                @method('PUT')

                {{-- Informations Personnelles --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-2xl border-2 border-blue-200 shadow-lg">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-400/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl mr-4 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Informations Personnelles</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Matricule</label>
                                <input type="text" value="{{ $auditeur->auditeur_id }}" class="block w-full bg-white/50 border-2 border-gray-200 rounded-xl p-3 text-gray-600 cursor-not-allowed" disabled>
                                <input type="hidden" name="auditeur_id" value="{{ $auditeur->auditeur_id }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email d'ajout</label>
                                <input type="email" value="{{ $auditeur->mail_ajout }}" class="block w-full bg-white/50 border-2 border-gray-200 rounded-xl p-3 text-gray-600 cursor-not-allowed" disabled>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nom <span class="text-red-500">*</span></label>
                                <input type="text" name="nom" value="{{ old('nom', $auditeur->nom) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all @error('nom') border-red-400 @enderror" required>
                                @error('nom')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Prénom <span class="text-red-500">*</span></label>
                                <input type="text" name="prenom" value="{{ old('prenom', $auditeur->prenom) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all @error('prenom') border-red-400 @enderror" required>
                                @error('prenom')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Genre <span class="text-red-500">*</span></label>
                                <select name="genre" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all @error('genre') border-red-400 @enderror" required>
                                    <option value="">Choisir...</option>
                                    <option value="Masculin" {{ old('genre', $auditeur->genre) == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                    <option value="Féminin" {{ old('genre', $auditeur->genre) == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('genre')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone <span class="text-red-500">*</span></label>
                                <input type="text" name="telephone" value="{{ old('telephone', $auditeur->telephone) }}" placeholder="+225..." class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all @error('telephone') border-red-400 @enderror" required>
                                @error('telephone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Origine et Résidence --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-2xl border-2 border-purple-200 shadow-lg">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-xl mr-4 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Origine et Naissance</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date de naissance <span class="text-red-500">*</span></label>
                                <input type="date" name="date_naissance" value="{{ old('date_naissance', $auditeur->date_naissance?->format('Y-m-d')) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all @error('date_naissance') border-red-400 @enderror" required>
                                @error('date_naissance')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Lieu de naissance <span class="text-red-500">*</span></label>
                                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $auditeur->lieu_naissance) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition-all @error('lieu_naissance') border-red-400 @enderror" required>
                                @error('lieu_naissance')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-8 rounded-2xl border-2 border-emerald-200 shadow-lg">
                        <div class="flex items-center mb-6">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl mr-4 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Résidence Actuelle</h3>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pays de résidence <span class="text-red-500">*</span></label>
                                <input type="text" name="pays_residence" value="{{ old('pays_residence', $auditeur->pays_residence) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition-all @error('pays_residence') border-red-400 @enderror" required>
                                @error('pays_residence')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ville de résidence <span class="text-red-500">*</span></label>
                                <input type="text" name="ville_residence" value="{{ old('ville_residence', $auditeur->ville_residence) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition-all @error('ville_residence') border-red-400 @enderror" required>
                                @error('ville_residence')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Situation Professionnelle --}}
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-8 rounded-2xl border-2 border-amber-200 shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-xl mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Situation Professionnelle</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Poste occupé <span class="text-red-500">*</span></label>
                            <input type="text" name="poste_occupe" value="{{ old('poste_occupe', $auditeur->poste_occupe) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-amber-200 focus:border-amber-500 transition-all @error('poste_occupe') border-red-400 @enderror" required>
                            @error('poste_occupe')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Employeur <span class="text-red-500">*</span></label>
                            <input type="text" name="employeur" value="{{ old('employeur', $auditeur->employeur) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-amber-200 focus:border-amber-500 transition-all @error('employeur') border-red-400 @enderror" required>
                            @error('employeur')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Filière <span class="text-red-500">*</span></label>
                            <input type="text" name="filiere" value="{{ old('filiere', $auditeur->filiere) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-amber-200 focus:border-amber-500 transition-all @error('filiere') border-red-400 @enderror" required>
                            @error('filiere')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Classe</label>
                            <input type="text" value="{{ old('classe_id', $auditeur->classe?->nom ?? 'Non assigné') }}" class="block w-full bg-white/50 border-2 border-gray-200 rounded-xl p-3 text-gray-600 cursor-not-allowed" disabled>
                        </div>
                    </div>
                </div>

                {{-- Informations Complémentaires --}}
                <div class="bg-gradient-to-br from-cyan-50 to-sky-50 p-8 rounded-2xl border-2 border-cyan-200 shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-cyan-500 to-sky-600 p-3 rounded-xl mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Informations Complémentaires</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email exact</label>
                            <input type="email" name="mail_exact" value="{{ old('mail_exact', $auditeur->mail_exact) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-cyan-200 focus:border-cyan-500 transition-all @error('mail_exact') border-red-400 @enderror">
                            @error('mail_exact')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Identifiant <span class="text-red-500">*</span></label>
                            <input type="text" name="identifiant" value="{{ old('identifiant', $auditeur->identifiant) }}" class="block w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-4 focus:ring-cyan-200 focus:border-cyan-500 transition-all @error('identifiant') border-red-400 @enderror" required>
                            @error('identifiant')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Photo --}}
                <div class="bg-gradient-to-br from-rose-50 to-pink-50 p-8 rounded-2xl border-2 border-rose-200 shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-rose-500 to-pink-600 p-3 rounded-xl mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Photo de profil</h3>
                    </div>
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <div class="flex-1">
                            <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-rose-500 file:to-pink-600 file:text-white hover:file:from-rose-600 hover:file:to-pink-700 file:transition-all file:duration-300 file:shadow-lg hover:file:shadow-xl">
                            @error('photo')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-500 mt-3 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Taille maximale : 2 Mo. Formats acceptés : JPG, PNG, GIF
                            </p>
                        </div>
                        @if($auditeur->photo)
                            <div class="text-center">
                                <p class="text-sm font-semibold text-gray-600 mb-3">Photo actuelle</p>
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-r from-rose-400 to-pink-500 rounded-full blur-lg opacity-50"></div>
                                    <img src="{{ asset('storage/' . $auditeur->photo) }}" alt="Photo de profil" class="relative w-32 h-32 object-cover rounded-full border-4 border-white shadow-2xl">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bouton --}}
                <div class="flex justify-end pt-6">
                    <button type="submit" class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-4 px-10 rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center">
                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-lg">Enregistrer mon Profil</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection