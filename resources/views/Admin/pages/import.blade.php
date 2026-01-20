@extends('Admin.layouts.app2')

@section('title', 'Importation des Étudiants')

@section('content')

<main class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        
        {{-- Conteneur principal avec effet glassmorphism --}}
        <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 p-6 md:p-10 overflow-hidden relative">
            
            {{-- Gradient décoratif en arrière-plan --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl -z-10"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-blue-400/20 to-cyan-400/20 rounded-full blur-3xl -z-10"></div>

            {{-- Titre principal avec animation --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-25"></div>
                    <div class="relative">
                        <h1 class="text-3xl md:text-4xl font-black bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                            📄 Importation des étudiants
                        </h1>
                        <p class="text-gray-600 mt-2 text-sm md:text-base font-medium">
                            Importez vos étudiants depuis un fichier Excel vers une classe spécifique
                        </p>
                    </div>

                    <a href="{{ route('admin.diplome') }}"
                       class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour
                    </a>
                </div>

                @if(session('excelData'))
                    <form action="{{ route('admin.import.cancel') }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        @method('POST')
                        <button type="submit"
                                class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-xl shadow-lg font-bold transition-all duration-300 hover:shadow-xl transform hover:-translate-y-0.5 w-full md:w-auto">
                            ❌ Annuler l'import
                        </button>
                    </form>
                @endif
            </div>

            {{-- Messages de session avec animations --}}
            <div class="space-y-4 mb-8">
                @if(session('success'))
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 border-l-4 border-emerald-500 text-emerald-800 p-5 rounded-xl shadow-lg animate-slide-in-right">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center mr-4">
                                <span class="text-xl text-white">✓</span>
                            </div>
                            <p class="font-semibold text-lg">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl shadow-lg animate-slide-in-right">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-full flex items-center justify-center mr-4">
                                <span class="text-xl text-white">✕</span>
                            </div>
                            <p class="font-semibold text-lg">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 text-blue-800 p-5 rounded-xl shadow-lg animate-slide-in-right">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                <span class="text-xl text-white">i</span>
                            </div>
                            <p class="font-semibold text-lg">{{ session('info') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('import_errors'))
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 text-amber-800 p-5 rounded-xl shadow-lg animate-slide-in-right">
                        <div class="flex items-center mb-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center mr-4">
                                <span class="text-xl text-white">⚠</span>
                            </div>
                            <p class="font-semibold text-lg">Erreurs rencontrées lors de l'importation :</p>
                        </div>
                        <ul class="list-disc pl-14 space-y-2 text-sm font-medium">
                            @foreach(session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- CONTENU PRINCIPAL --}}
            @if(!session('excelData'))
                {{-- FORMULAIRE D'IMPORTATION --}}
                <div class="bg-gradient-to-br from-white to-gray-50 p-6 md:p-8 rounded-2xl border-2 border-gray-200 mb-8 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-400/10 to-purple-400/10 rounded-full blur-2xl"></div>
                    
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <span class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white text-xl">📥</span>
                        Étape 1 : Sélectionner la classe et le fichier
                    </h2>

                    <form action="{{ route('admin.import.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Sélection de la classe --}}
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <span class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xs">1</span>
                                Classe de destination <span class="text-red-500">*</span>
                            </label>
                            <select name="classe_id" required
                                    class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all duration-300 bg-white shadow-sm hover:shadow-md font-medium">
                                <option value="">✨ Sélectionnez une classe...</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                        🏫 {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <p class="text-red-500 text-sm mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Les étudiants seront ajoutés à cette classe
                            </p>
                        </div>

                        {{-- Fichier Excel --}}
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <span class="w-6 h-6 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xs">2</span>
                                Fichier Excel <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file"
                                       name="file"
                                       id="fileInput"
                                       accept=".xlsx,.xls,.csv"
                                       required
                                       class="w-full border-2 border-dashed border-gray-300 rounded-xl px-5 py-6 focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all duration-300 bg-white shadow-sm hover:shadow-md hover:border-indigo-400 cursor-pointer">
                            </div>
                            @error('file')
                                <p class="text-red-500 text-sm mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                            <div class="mt-3 bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                                <p class="text-sm text-indigo-800 font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    Format attendu : Colonnes [ID, Nom, Prénom, Email, Filière]
                                </p>
                            </div>
                        </div>

                        {{-- Bouton d'importation --}}
                        <div class="pt-4">
                            <button type="submit" id="submitBtn"
                                    class="w-full md:w-auto bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500 hover:from-emerald-600 hover:via-green-600 hover:to-teal-600 text-white px-10 py-4 rounded-xl shadow-xl font-bold transition-all duration-300 flex items-center justify-center gap-3 hover:shadow-2xl transform hover:-translate-y-1 hover:scale-105">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"/>
                                </svg>
                                Charger l'aperçu
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Instructions avec design moderne --}}
                <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-6 md:p-8 rounded-2xl border-2 border-blue-200 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-40 h-40 bg-gradient-to-br from-blue-400/10 to-purple-400/10 rounded-full blur-2xl"></div>
                    
                    <h3 class="text-xl md:text-2xl font-bold text-blue-800 mb-5 flex items-center gap-3">
                        <span class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center text-white text-xl">📋</span>
                        Instructions d'importation
                    </h3>
                    <ul class="space-y-4 text-gray-700">
                        <li class="flex items-start gap-4 bg-white/60 backdrop-blur-sm p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                            <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">1</span>
                            <span class="font-medium pt-1">Sélectionnez d'abord la classe de destination</span>
                        </li>
                        <li class="flex items-start gap-4 bg-white/60 backdrop-blur-sm p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                            <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">2</span>
                            <span class="font-medium pt-1">Téléchargez un fichier Excel (.xlsx, .xls) avec les colonnes dans cet ordre : ID, Nom, Prénom, Email, Filière</span>
                        </li>
                        <li class="flex items-start gap-4 bg-white/60 backdrop-blur-sm p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                            <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">3</span>
                            <span class="font-medium pt-1">La première ligne doit contenir les en-têtes</span>
                        </li>
                        <li class="flex items-start gap-4 bg-white/60 backdrop-blur-sm p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                            <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">4</span>
                            <span class="font-medium pt-1">Un aperçu vous permettra de vérifier les données avant l'importation définitive</span>
                        </li>
                        <li class="flex items-start gap-4 bg-white/60 backdrop-blur-sm p-4 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                            <span class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">5</span>
                            <span class="font-medium pt-1">Les étudiants seront marqués comme "actifs" par défaut</span>
                        </li>
                    </ul>
                </div>

            @else
                {{-- APERÇU DES DONNÉES --}}
                <div class="bg-white rounded-2xl border-2 border-gray-200 shadow-2xl overflow-hidden">
                    {{-- En-tête de l'aperçu --}}
                    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 md:p-8 text-white">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <h2 class="text-2xl md:text-3xl font-black mb-2 flex items-center gap-3">
                                    <span class="text-3xl">👁️</span>
                                    Aperçu des données
                                </h2>
                                <p class="text-indigo-100 text-base md:text-lg font-medium">
                                    {{ session('total_rows', 0) }} étudiants à importer dans la classe :
                                    <span class="font-bold text-white bg-white/20 px-3 py-1 rounded-lg">{{ session('classe_nom') }}</span>
                                </p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm text-white px-5 py-3 rounded-xl font-bold text-lg shadow-lg border border-white/30">
                                📊 {{ count(session('excelData')) }} lignes
                            </div>
                        </div>
                    </div>

                    {{-- Tableau d'aperçu --}}
                    <form action="{{ route('admin.import.store') }}" method="POST" id="importForm">
                        @csrf
                        <input type="hidden" name="classe_id" value="{{ session('classe_id') }}">

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse min-w-[800px]">
                                <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                                    <tr>
                                        <th class="p-4 md:p-5 text-left font-bold text-sm md:text-base">ID</th>
                                        <th class="p-4 md:p-5 text-left font-bold text-sm md:text-base">Email</th>
                                        <th class="p-4 md:p-5 text-left font-bold text-sm md:text-base">Password</th>
                                        <th class="p-4 md:p-5 text-left font-bold text-sm md:text-base">Statut</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @foreach(session('excelData') as $index => $row)
                                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-200">
                                        <td class="p-4 border-r border-gray-200">
                                            <input type="hidden" name="rows[{{ $index }}][id]" value="{{ $row['id'] ?? '' }}">
                                            <span class="font-mono font-semibold {{ empty($row['id']) ? 'text-gray-400 italic' : 'text-gray-800' }}">
                                                {{ $row['id'] ?? '(vide)' }}
                                            </span>
                                        </td>
                                        <td class="p-4 border-r border-gray-200">
                                            <input type="hidden" name="rows[{{ $index }}][email]" value="{{ $row['email'] ?? '' }}">
                                            <span class="font-medium {{ empty($row['email']) ? 'text-gray-400 italic' : 'text-gray-800' }}">
                                                {{ $row['email'] ?? '(vide)' }}
                                            </span>
                                        </td>
                                        <td class="p-4 border-r border-gray-200">
                                            <input type="hidden" name="rows[{{ $index }}][id]" value="{{ $row['id'] ?? '' }}">
                                            <div class="flex flex-col">
                                                <span class="{{ empty($row['id']) ? 'text-gray-400 italic' : 'font-mono text-gray-800' }}">
                                                    {{ $row['id'] ?? '(vide)' }}
                                                </span>
                                                @if(!empty($row['id']) && !empty($row['password_preview']))
                                                    <small class="text-indigo-600 text-xs font-semibold mt-1 bg-indigo-50 px-2 py-1 rounded">
                                                        🔑 {{ $row['password_preview'] }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            @php
                                                $email = $row['email'] ?? '';
                                                $id = $row['id'] ?? '';
                                                $exists = false;

                                                if (!empty($email) || !empty($id)) {
                                                    $exists = App\Models\Auditeur::where(function($query) use ($email, $id) {
                                                        if (!empty($email)) {
                                                            $query->orWhere('mail_ajout', $email);
                                                        }
                                                        if (!empty($id)) {
                                                            $query->orWhere('auditeur_id', $id);
                                                        }
                                                    })->exists();
                                                }
                                            @endphp
                                            @if($exists)
                                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 rounded-xl text-xs font-bold shadow-sm border border-amber-200">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Existe
                                                </span>
                                            @elseif(empty($email) && empty($id))
                                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-100 to-rose-100 text-red-800 rounded-xl text-xs font-bold shadow-sm border border-red-200">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Invalide
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 rounded-xl text-xs font-bold shadow-sm border border-emerald-200">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Nouveau
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="p-6 md:p-8 border-t-2 bg-gradient-to-r from-gray-50 to-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="text-gray-700">
                                <p class="font-bold text-lg flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    </svg>
                                    Classe sélectionnée :
                                    <span class="text-indigo-600">{{ session('classe_nom') }}</span>
                                </p>
                                <p class="text-sm text-gray-600 mt-1">Tous les étudiants seront ajoutés à cette classe</p>
                            </div>

                            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                                <form action="{{ route('admin.import.cancel') }}" method="POST" class="w-full md:w-auto">
                                    @csrf
                                    @method('POST')
                                    <button type="submit"
                                            class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 w-full">
                                        ❌ Annuler
                                    </button>
                                </form>

                                <button type="submit"
                                        id="finalImportBtn"
                                        class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white px-8 py-3 rounded-xl font-bold shadow-xl transition-all duration-300 flex items-center justify-center gap-2 hover:shadow-2xl transform hover:-translate-y-0.5 hover:scale-105 w-full">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Importer {{ count(session('excelData')) }} étudiants
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Résumé avec cartes statistiques --}}
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border-2 border-blue-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                📊
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Total à importer</p>
                                <p class="text-3xl font-black text-blue-700">{{ count(session('excelData')) }}</p>
                            </div>
                        </div>
                    </div>

                    @php
                        $newCount = 0;
                        $existCount = 0;
                        $invalidCount = 0;

                        foreach(session('excelData') as $row) {
                            $email = $row['email'] ?? '';
                            $id = $row['id'] ?? '';

                            if (empty($email) && empty($id)) {
                                $invalidCount++;
                            } else {
                                $exists = App\Models\Auditeur::where('mail_ajout', $email)
                                    ->orWhere('auditeur_id', $id)
                                    ->exists();
                                if($exists) {
                                    $existCount++;
                                } else {
                                    $newCount++;
                                }
                            }
                        }
                    @endphp

                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-6 rounded-2xl border-2 border-emerald-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                ✅
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Nouveaux étudiants</p>
                                <p class="text-3xl font-black text-emerald-700">{{ $newCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl border-2 border-purple-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                🏫
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Classe</p>
                                <p class="text-2xl font-black text-purple-700 truncate">{{ session('classe_nom') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Statistiques additionnelles --}}
                @if($existCount > 0 || $invalidCount > 0)
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        @if($existCount > 0)
                            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 p-6 rounded-2xl border-2 border-amber-200 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                        ⚠️
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Déjà existants</p>
                                        <p class="text-3xl font-black text-amber-700">{{ $existCount }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($invalidCount > 0)
                            <div class="bg-gradient-to-br from-red-50 to-rose-50 p-6 rounded-2xl border-2 border-red-200 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-rose-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                        ❌
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium">Lignes invalides</p>
                                        <p class="text-3xl font-black text-red-700">{{ $invalidCount }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>
</main>

{{-- Styles et Scripts --}}
<style>
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des messages avec animation et fermeture
    const messages = document.querySelectorAll('.bg-gradient-to-r.from-emerald-50, .bg-gradient-to-r.from-red-50, .bg-gradient-to-r.from-blue-50, .bg-gradient-to-r.from-amber-50');

    messages.forEach(message => {
        // Fermer automatiquement après 8 secondes
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                if (message.parentNode) {
                    message.remove();
                }
            }, 500);
        }, 8000);

        // Bouton de fermeture manuelle
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.className = 'ml-auto text-2xl font-bold hover:text-gray-800 transition-colors';
        closeBtn.style.cssText = 'background: transparent; border: none; cursor: pointer;';

        const flexContainer = message.querySelector('.flex');
        if (flexContainer) {
            flexContainer.appendChild(closeBtn);

            closeBtn.addEventListener('click', function() {
                message.style.opacity = '0';
                setTimeout(() => {
                    if (message.parentNode) {
                        message.remove();
                    }
                }, 500);
            });
        }
    });

    // Validation du formulaire de prévisualisation
    const previewForm = document.querySelector('form[action*="preview"]');
    if (previewForm) {
        const submitBtn = document.getElementById('submitBtn');
        const fileInput = document.getElementById('fileInput');
        const classeSelect = previewForm.querySelector('select[name="classe_id"]');

        previewForm.addEventListener('submit', function(e) {
            let isValid = true;

            if (!classeSelect.value) {
                isValid = false;
                showToast('Veuillez sélectionner une classe', 'error');
                classeSelect.focus();
            } else if (!fileInput.value) {
                isValid = false;
                showToast('Veuillez sélectionner un fichier Excel', 'error');
                fileInput.focus();
            } else {
                const fileName = fileInput.value;
                const validExtensions = ['.xlsx', '.xls', '.csv'];
                const hasValidExtension = validExtensions.some(ext =>
                    fileName.toLowerCase().endsWith(ext)
                );

                if (!hasValidExtension) {
                    isValid = false;
                    showToast('Veuillez sélectionner un fichier Excel (.xlsx, .xls, .csv)', 'error');
                    fileInput.focus();
                }
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Traitement en cours...</span>
                `;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            }
        });
    }

    // Validation du formulaire final d'importation
    const importForm = document.getElementById('importForm');
    if (importForm) {
        const finalImportBtn = document.getElementById('finalImportBtn');

        importForm.addEventListener('submit', function(e) {
            const invalidRows = document.querySelectorAll('.from-red-100').length;

            if (invalidRows > 0) {
                const confirmImport = confirm(`⚠️ ${invalidRows} ligne(s) sont invalides (ID et Email manquants).\n\nVoulez-vous quand même procéder à l'importation ?\n\nLes lignes invalides seront ignorées.`);

                if (!confirmImport) {
                    e.preventDefault();
                    return false;
                }
            }

            if (finalImportBtn) {
                finalImportBtn.disabled = true;
                finalImportBtn.innerHTML = `
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Importation en cours...</span>
                `;
                finalImportBtn.classList.add('opacity-75', 'cursor-not-allowed');

                const loadingOverlay = document.createElement('div');
                loadingOverlay.id = 'loadingOverlay';
                loadingOverlay.className = 'fixed inset-0 bg-white/80 backdrop-blur-sm flex justify-center items-center z-50';
                loadingOverlay.innerHTML = `
                    <div class="bg-white p-8 rounded-2xl shadow-2xl text-center border-2 border-indigo-200">
                        <div class="w-16 h-16 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-gray-700 font-bold text-lg">Importation en cours...</p>
                        <p class="text-gray-500 text-sm mt-2">Veuillez patienter</p>
                    </div>
                `;
                document.body.appendChild(loadingOverlay);
            }
        });
    }

    // Fonction pour afficher des messages toast
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const colors = {
            success: 'from-emerald-500 to-green-500',
            error: 'from-red-500 to-rose-500',
            warning: 'from-amber-500 to-yellow-500',
            info: 'from-blue-500 to-cyan-500'
        };

        toast.className = `bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-xl shadow-2xl fixed top-4 right-4 z-50 transform transition-all duration-300 flex items-center gap-3`;
        toast.style.transform = 'translateX(100%)';
        toast.innerHTML = `
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                ${type === 'success' ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>' : 
                type === 'error' ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>' :
                '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'}
            </svg>
            <span class="font-semibold">${message}</span>
            <button class="ml-4 text-white hover:text-gray-200 transition-colors font-bold text-xl" onclick="this.parentElement.remove()">
                &times;
            </button>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 10);

        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 5000);
    }
});
</script>

@endsection