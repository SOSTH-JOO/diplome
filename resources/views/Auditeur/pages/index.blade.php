@extends('Auditeur.layouts.app')

@section('title', 'Profil Auditeur')

@section('content')

<main class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100">
    {{-- Messages de notification --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto mb-8 animate-pulse">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white p-6 rounded-2xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center flex-shrink-0 animate-bounce">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-xl">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto mb-8 animate-pulse">
            <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white p-6 rounded-2xl shadow-2xl">
                <div class="flex items-start space-x-4">
                    <div class="w-14 h-14 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center flex-shrink-0 animate-bounce">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-xl mb-4">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="space-y-3">
                            @foreach($errors->all() as $error)
                                <li class="flex items-start text-sm bg-white/20 backdrop-blur-sm p-3 rounded-lg">
                                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        {{-- Header avec déconnexion --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 space-y-6 md:space-y-0">
            <div class="text-center md:text-left">
                <h1 class="text-5xl md:text-6xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-3 animate-pulse">
                    Mon Profil Auditeur
                </h1>
                <p class="text-gray-600 text-lg font-medium">Gérez vos informations personnelles et professionnelles avec style</p>
            </div>
            <form method="POST" action="{{ route('auditeur.logout') }}">
                @csrf
                <button type="submit" class="group relative bg-gradient-to-r from-red-500 via-pink-500 to-purple-500 text-white font-bold py-4 px-8 rounded-2xl shadow-2xl hover:shadow-pink-500/50 transform hover:scale-110 hover:-rotate-2 transition-all duration-300 flex items-center space-x-3">
                    <svg class="w-6 h-6 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="text-lg">Se déconnecter</span>
                </button>
            </form>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border-2 border-white/50 hover:shadow-indigo-500/20 transform hover:-translate-y-2 transition-all duration-500">
            <form action="{{ route('auditeur.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')

                {{-- Informations Personnelles --}}
                <div class="relative bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-10 rounded-3xl border-2 border-indigo-200 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-blue-400/20 to-indigo-400/20 rounded-full blur-2xl"></div>
                    
                    <h3 class="relative text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-8 flex items-center">
                        <div class="w-2 h-12 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full mr-4"></div>
                        Informations Personnelles
                    </h3>
                    
                    <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Champs non modifiables --}}
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Identifiant</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-indigo-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                </div>
                                <input type="text" value="{{ $auditeur->auditeur_id }}"
                                       class="block w-full pl-14 pr-4 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-300 rounded-xl text-gray-600 font-semibold cursor-not-allowed shadow-inner"
                                       disabled>
                                <input type="hidden" name="auditeur_id" value="{{ $auditeur->auditeur_id }}">
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-indigo-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" value="{{ $auditeur->mail_ajout }}"
                                       class="block w-full pl-14 pr-4 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-2 border-gray-300 rounded-xl text-gray-600 font-semibold cursor-not-allowed shadow-inner"
                                       disabled>
                            </div>
                        </div>

                        {{-- Champs modifiables --}}
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                Nom de famille <span class="text-red-500 text-lg">*</span>
                            </label>
                            <input type="text" name="nom" value="{{ old('nom', $auditeur->nom) }}"
                                   class="block w-full px-5 py-4 border-2 border-indigo-200 rounded-xl font-semibold focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 hover:border-indigo-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('nom') border-red-500 @enderror"
                                   required>
                            @error('nom')
                                <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                Prénoms <span class="text-red-500 text-lg">*</span>
                            </label>
                            <input type="text" name="prenom" value="{{ old('prenom', $auditeur->prenom) }}"
                                   class="block w-full px-5 py-4 border-2 border-indigo-200 rounded-xl font-semibold focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 hover:border-indigo-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('prenom') border-red-500 @enderror"
                                   required>
                            @error('prenom')
                                <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                Genre <span class="text-red-500 text-lg">*</span>
                            </label>
                            <select name="genre"
                                    class="block w-full px-5 py-4 border-2 border-indigo-200 rounded-xl font-semibold focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 hover:border-indigo-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('genre') border-red-500 @enderror"
                                    required>
                                <option value="">Choisir...</option>
                                <option value="Masculin" {{ old('genre', $auditeur->genre) == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                <option value="Féminin" {{ old('genre', $auditeur->genre) == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('genre')
                                <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                Téléphone <span class="text-red-500 text-lg">*</span>
                            </label>
                            <input type="text" name="telephone" value="{{ old('telephone', $auditeur->telephone) }}"
                                   placeholder="+225..."
                                   class="block w-full px-5 py-4 border-2 border-indigo-200 rounded-xl font-semibold focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 hover:border-indigo-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('telephone') border-red-500 @enderror"
                                   required>
                            @error('telephone')
                                <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Origine et Naissance / Résidence --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    {{-- Origine et Naissance --}}
                    <div class="relative bg-gradient-to-br from-purple-50 via-pink-50 to-rose-50 p-10 rounded-3xl border-2 border-purple-200 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 hover:rotate-1 transition-all duration-300 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-2xl"></div>
                        
                        <h3 class="relative text-2xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-8 flex items-center">
                            <div class="w-2 h-10 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full mr-4"></div>
                            Origine et Naissance
                        </h3>
                        
                        <div class="relative space-y-6">
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                    Date de naissance <span class="text-red-500 text-lg">*</span>
                                </label>
                                <input type="date" name="date_naissance" value="{{ old('date_naissance', $auditeur->date_naissance?->format('Y-m-d')) }}"
                                       class="block w-full px-5 py-4 border-2 border-purple-200 rounded-xl font-semibold focus:ring-4 focus:ring-purple-300 focus:border-purple-500 hover:border-purple-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('date_naissance') border-red-500 @enderror"
                                       required>
                                @error('date_naissance')
                                    <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                    Pays de naissance <span class="text-red-500 text-lg">*</span>
                                </label>
                                <input type="text" name="pays_naiss" value="{{ old('pays_naiss', $auditeur->lieu_naissance) }}"
                                       class="block w-full px-5 py-4 border-2 border-purple-200 rounded-xl font-semibold focus:ring-4 focus:ring-purple-300 focus:border-purple-500 hover:border-purple-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('pays_naiss') border-red-500 @enderror"
                                       required>
                                @error('pays_naiss')
                                    <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                    Ville de naissance <span class="text-red-500 text-lg">*</span>
                                </label>
                                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $auditeur->lieu_naissance) }}"
                                       class="block w-full px-5 py-4 border-2 border-purple-200 rounded-xl font-semibold focus:ring-4 focus:ring-purple-300 focus:border-purple-500 hover:border-purple-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('lieu_naissance') border-red-500 @enderror"
                                       required>
                                @error('lieu_naissance')
                                    <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Résidence Actuelle --}}
                    <div class="relative bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 p-10 rounded-3xl border-2 border-emerald-200 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 hover:-rotate-1 transition-all duration-300 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/20 to-teal-400/20 rounded-full blur-2xl"></div>
                        
                        <h3 class="relative text-2xl font-extrabold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-8 flex items-center">
                            <div class="w-2 h-10 bg-gradient-to-b from-emerald-600 to-teal-600 rounded-full mr-4"></div>
                            Résidence Actuelle
                        </h3>
                        
                        <div class="relative space-y-6">
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                    Pays de résidence <span class="text-red-500 text-lg">*</span>
                                </label>
                                <input type="text" name="pays_residence" value="{{ old('pays_residence', $auditeur->pays_residence) }}"
                                       class="block w-full px-5 py-4 border-2 border-emerald-200 rounded-xl font-semibold focus:ring-4 focus:ring-emerald-300 focus:border-emerald-500 hover:border-emerald-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('pays_residence') border-red-500 @enderror"
                                       required>
                                @error('pays_residence')
                                    <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                    Ville de résidence <span class="text-red-500 text-lg">*</span>
                                </label>
                                <input type="text" name="ville_residence" value="{{ old('ville_residence', $auditeur->ville_residence) }}"
                                       class="block w-full px-5 py-4 border-2 border-emerald-200 rounded-xl font-semibold focus:ring-4 focus:ring-emerald-300 focus:border-emerald-500 hover:border-emerald-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('ville_residence') border-red-500 @enderror"
                                       required>
                                @error('ville_residence')
                                    <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Situation Professionnelle --}}
                <div class="relative bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 p-10 rounded-3xl border-2 border-orange-200 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-orange-400/20 to-amber-400/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-yellow-400/20 to-orange-400/20 rounded-full blur-2xl"></div>
                    
                    <h3 class="relative text-3xl font-extrabold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent mb-8 flex items-center">
                        <div class="w-2 h-12 bg-gradient-to-b from-orange-600 to-amber-600 rounded-full mr-4"></div>
                        Situation Professionnelle
                    </h3>
                    
                    <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                Poste occupé <span class="text-red-500 text-lg">*</span>
                            </label>
                            <input type="text" name="poste_occupe" value="{{ old('poste_occupe', $auditeur->poste_occupe) }}"
                                   class="block w-full px-5 py-4 border-2 border-orange-200 rounded-xl font-semibold focus:ring-4 focus:ring-orange-300 focus:border-orange-500 hover:border-orange-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('poste_occupe') border-red-500 @enderror"
                                   required>
                            @error('poste_occupe')
                                <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">
                                Employeur <span class="text-red-500 text-lg">*</span>
                            </label>
                            <input type="text" name="employeur" value="{{ old('employeur', $auditeur->employeur) }}"
                                   class="block w-full px-5 py-4 border-2 border-orange-200 rounded-xl font-semibold focus:ring-4 focus:ring-orange-300 focus:border-orange-500 hover:border-orange-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('employeur') border-red-500 @enderror"
                                   required>
                            @error('employeur')
                                <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Informations Complémentaires --}}
                <div class="relative bg-gradient-to-br from-cyan-50 via-blue-50 to-indigo-50 p-10 rounded-3xl border-2 border-cyan-200 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-400/20 to-blue-400/20 rounded-full blur-2xl"></div>
                    
                    <h3 class="relative text-3xl font-extrabold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent mb-8 flex items-center">
                        <div class="w-2 h-12 bg-gradient-to-b from-cyan-600 to-blue-600 rounded-full mr-4"></div>
                        Informations Complémentaires
                    </h3>
                    
                    <div class="relative grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider">Email exact</label>
                            <input type="email" name="mail_exact" value="{{ old('mail_exact', $auditeur->mail_exact) }}"
                                   class="block w-full px-5 py-4 border-2 border-cyan-200 rounded-xl font-semibold focus:ring-4 focus:ring-cyan-300 focus:border-cyan-500 hover:border-cyan-400 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-xl @error('mail_exact') border-red-500 @enderror">
                            @error('mail_exact')
                                <p class="mt-3 text-sm text-red-600 flex items-center bg-red-50 p-2 rounded-lg">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Photo --}}
                <div class="relative bg-gradient-to-br from-rose-50 via-pink-50 to-fuchsia-50 p-10 rounded-3xl border-4 border-dashed border-rose-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 hover:scale-105 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-rose-400/20 to-pink-400/20 rounded-full blur-3xl"></div>
                    
                    <h3 class="relative text-3xl font-extrabold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent mb-8 flex items-center">
                        <svg class="w-8 h-8 mr-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Photo de profil
                    </h3>
                    
                    <div class="relative flex flex-col lg:flex-row items-center lg:items-start gap-10">
                        <div class="flex-1 w-full">
                            <label class="group flex flex-col items-center justify-center w-full h-64 border-4 border-rose-300 border-dashed rounded-3xl cursor-pointer bg-gradient-to-br from-white to-rose-50/50 hover:from-rose-50 hover:to-pink-100 transform hover:scale-105 transition-all duration-500 shadow-lg hover:shadow-2xl">
                                <div class="flex flex-col items-center justify-center pt-7 pb-8">
                                    <svg class="w-16 h-16 mb-5 text-rose-500 group-hover:text-pink-600 group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-3 text-base font-bold text-gray-700 group-hover:text-rose-700">
                                        <span class="text-rose-600">Cliquez pour télécharger</span> ou glissez-déposez
                                    </p>
                                    <p class="text-sm font-semibold text-gray-500">PNG, JPG, GIF (MAX. 2MB)</p>
                                </div>
                                <input type="file" name="photo" accept="image/*" class="hidden">
                            </label>
                            @error('photo')
                                <p class="mt-4 text-sm text-red-600 flex items-center bg-red-50 p-3 rounded-lg font-semibold">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        @if($auditeur->photo)
                            <div class="text-center transform hover:scale-110 transition-all duration-300">
                                <p class="text-sm font-bold text-gray-700 mb-5 uppercase tracking-wider bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">
                                    Photo actuelle
                                </p>
                                <div class="relative inline-block group">
                                    <div class="absolute -inset-1 bg-gradient-to-r from-rose-500 to-pink-500 rounded-3xl blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                                    <img src="{{ asset('storage/' . $auditeur->photo) }}" alt="Photo de profil" 
                                         class="relative w-48 h-48 object-cover rounded-3xl border-4 border-white shadow-2xl group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute -bottom-3 -right-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-full p-3 shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bouton de soumission --}}
                <div class="flex justify-center pt-10">
                    <button type="submit" class="group relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white font-black py-6 px-16 rounded-3xl shadow-2xl hover:shadow-indigo-500/50 transform hover:scale-110 hover:rotate-1 transition-all duration-500 flex items-center text-xl overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <svg class="relative w-8 h-8 mr-4 group-hover:rotate-180 transition-transform duration-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="relative">Enregistrer mon Profil</span>
                        <svg class="relative w-7 h-7 ml-4 group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Footer décoratif --}}
        <div class="mt-16 text-center">
            <div class="inline-flex items-center space-x-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white px-8 py-4 rounded-full shadow-2xl transform hover:scale-105 transition-all duration-300">
                <svg class="w-6 h-6 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                <span class="font-bold text-lg">Profil Auditeur</span>
                <svg class="w-6 h-6 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>
    </div>
</main>

@endsection