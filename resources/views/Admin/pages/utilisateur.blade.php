@extends('Admin.layouts.app2')

@section('title', 'Gestion des Utilisateurs')

@section('content')

<main class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Header Premium -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-700 rounded-3xl shadow-2xl p-6 sm:p-8 mb-8 border-b-4 border-orange-500 transform hover:scale-[1.02] transition-all duration-300">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="flex items-center gap-4">
                    <span class="text-5xl sm:text-6xl animate-bounce">👥</span>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-pink-400 to-purple-400">
                            Gestion des Utilisateurs
                        </h1>
                        <p class="text-gray-300 text-sm sm:text-base mt-1">Gérez les comptes avec style et efficacité</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.diplome') }}"
                       class="relative overflow-hidden bg-white text-gray-800 px-5 py-3 rounded-xl font-bold shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2 group">
                        <span class="absolute inset-0 bg-gradient-to-r from-gray-100 to-gray-200 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        <span class="relative text-xl">←</span>
                        <span class="relative">Retour</span>
                    </a>
                    <button onclick="openAddModal()"
                            class="relative overflow-hidden bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2 group">
                        <span class="absolute inset-0 bg-gradient-to-r from-orange-600 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        <span class="relative text-xl">✨</span>
                        <span class="relative">Nouvel Utilisateur</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="bg-white border-l-4 border-green-500 rounded-xl shadow-xl p-6 mb-8 transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="text-4xl animate-bounce">✅</div>
                    <div>
                        <p class="font-bold text-green-800 text-lg">Succès !</p>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-white border-l-4 border-red-500 rounded-xl shadow-xl p-6 mb-8 transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="text-4xl animate-bounce">❌</div>
                    <div>
                        <p class="font-bold text-red-800 text-lg">Erreur !</p>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistiques Premium -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <!-- Total Utilisateurs -->
            <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 sm:p-8 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-rotate-1 transition-all duration-300">
                <div class="absolute top-0 right-0 text-8xl sm:text-9xl opacity-10 -mr-4 -mt-4">👥</div>
                <div class="relative z-10">
                    <p class="text-orange-100 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">Total</p>
                    <p class="text-4xl sm:text-5xl font-black mb-1">{{ $utilisateurs->count() }}</p>
                    <p class="text-orange-100 text-sm">Utilisateurs</p>
                </div>
            </div>

            <!-- Superusers -->
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 sm:p-8 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 hover:rotate-1 transition-all duration-300">
                <div class="absolute top-0 right-0 text-8xl sm:text-9xl opacity-10 -mr-4 -mt-4">👑</div>
                <div class="relative z-10">
                    <p class="text-purple-100 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">Premium</p>
                    <p class="text-4xl sm:text-5xl font-black mb-1">{{ $utilisateurs->where('role', 'Superuser')->count() }}</p>
                    <p class="text-purple-100 text-sm">Superusers</p>
                </div>
            </div>

            <!-- Utilisateurs Standard -->
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 sm:p-8 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-rotate-1 transition-all duration-300">
                <div class="absolute top-0 right-0 text-8xl sm:text-9xl opacity-10 -mr-4 -mt-4">👤</div>
                <div class="relative z-10">
                    <p class="text-blue-100 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">Standard</p>
                    <p class="text-4xl sm:text-5xl font-black mb-1">{{ $utilisateurs->where('role', 'user')->count() }}</p>
                    <p class="text-blue-100 text-sm">Utilisateurs</p>
                </div>
            </div>

            <!-- Actifs -->
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 sm:p-8 text-white shadow-xl hover:shadow-2xl transform hover:scale-105 hover:rotate-1 transition-all duration-300">
                <div class="absolute top-0 right-0 text-8xl sm:text-9xl opacity-10 -mr-4 -mt-4">✓</div>
                <div class="relative z-10">
                    <p class="text-green-100 text-xs sm:text-sm font-bold uppercase tracking-wider mb-2">Actifs</p>
                    <p class="text-4xl sm:text-5xl font-black mb-1">{{ $utilisateurs->where('is_active', true)->count() }}</p>
                    <p class="text-green-100 text-sm">En ligne</p>
                </div>
            </div>
        </div>

        <!-- Tableau Premium -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-t-4 border-orange-500 transform hover:shadow-3xl transition-all duration-300">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6">
                <h2 class="text-xl sm:text-2xl font-black text-white flex items-center gap-3">
                    <span class="text-3xl sm:text-4xl">📋</span>
                    Liste des Utilisateurs
                </h2>
            </div>

            <div class="p-4 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-orange-500">
                                <th class="py-4 px-4 text-left font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">#</th>
                                <th class="py-4 px-4 text-left font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">Nom</th>
                                <th class="py-4 px-4 text-left font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">Email</th>
                                <th class="py-4 px-4 text-center font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">Rôle</th>
                                <th class="py-4 px-4 text-center font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">Profil</th>
                                <th class="py-4 px-4 text-center font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">Statut</th>
                                <th class="py-4 px-4 text-center font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">Inscription</th>
                                <th class="py-4 px-4 text-center font-black text-gray-700 uppercase tracking-wider text-xs sm:text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($utilisateurs as $index => $user)
                                <tr class="hover:bg-gradient-to-r hover:from-orange-50 hover:to-pink-50 transition-all duration-300 hover:shadow-lg">
                                    <td class="py-5 px-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-pink-500 flex items-center justify-center text-white font-black shadow-lg">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="py-5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center text-white text-xl font-bold shadow-lg ring-4 ring-orange-100">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800 text-base sm:text-lg">{{ $user->name }}</p>
                                                @if($user->id === auth()->id())
                                                    <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full font-semibold">
                                                        ⭐ Vous
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 px-4">
                                        <p class="text-gray-600 font-medium text-sm sm:text-base">{{ $user->email }}</p>
                                    </td>
                                    <td class="py-5 px-4 text-center">
                                        @if($user->role === 'Superuser')
                                            <span class="inline-block bg-gradient-to-r from-purple-500 to-purple-600 text-white px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg">
                                                👑 Superuser
                                            </span>
                                        @else
                                            <span class="inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg">
                                                👤 Utilisateur
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-4 text-center">
                                        @if($user->auditeur_count > 0)
                                            <span class="inline-block bg-green-100 text-green-800 px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold">
                                                ✓ Complété
                                            </span>
                                        @else
                                            <span class="inline-block bg-gray-100 text-gray-500 px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm">
                                                − Non complété
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-4 text-center">
                                        @if($user->is_active)
                                            <span class="inline-block bg-green-500 text-white px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg animate-pulse">
                                                ● Actif
                                            </span>
                                        @else
                                            <span class="inline-block bg-red-500 text-white px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg">
                                                ● Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-4 text-center">
                                        <p class="text-gray-600 font-semibold text-sm">{{ $user->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="py-5 px-4">
                                        <div class="flex justify-center gap-2">
                                            <button onclick="openEditModal({{ $user->id }})"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg font-bold shadow-lg transform hover:scale-110 transition-all duration-300">
                                                ✏️
                                            </button>

                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.utilisateurs.toggleStatus', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="{{ $user->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-3 sm:px-4 py-2 rounded-lg font-bold shadow-lg transform hover:scale-110 transition-all duration-300"
                                                            title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                                        {{ $user->is_active ? '🚫' : '✅' }}
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.utilisateurs.destroy', $user->id) }}" method="POST"
                                                      onsubmit="return confirmDelete(event)" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-3 sm:px-4 py-2 rounded-lg font-bold shadow-lg transform hover:scale-110 transition-all duration-300"
                                                            title="Supprimer">
                                                        🗑️
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-20">
                                        <div class="text-8xl sm:text-9xl mb-6 animate-bounce">👥</div>
                                        <p class="text-gray-400 text-xl sm:text-2xl font-bold">Aucun utilisateur trouvé</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Ajout Premium -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 sm:p-8 transform scale-95 opacity-0 transition-all duration-500 border-4 border-orange-500 shadow-2xl" id="addModalBox">
            <div class="flex justify-between items-center mb-6 sm:mb-8">
                <h2 class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500 flex items-center gap-2 sm:gap-3">
                    <span class="text-3xl sm:text-4xl">✨</span>
                    Nouvel Utilisateur
                </h2>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-orange-500 text-3xl sm:text-4xl font-bold transition-all transform hover:rotate-90 duration-300">×</button>
            </div>

            <form action="{{ route('admin.utilisateurs.store') }}" method="POST" class="space-y-4 sm:space-y-5" id="addForm">
                @csrf

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Nom complet <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-orange-500 focus:ring-4 focus:ring-orange-100 focus:outline-none transition-all duration-300 @error('name') border-red-500 @enderror"
                           placeholder="Ex: Jean Kouamé" required>
                    @error('name')
                        <p class="text-red-500 text-xs sm:text-sm mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-orange-500 focus:ring-4 focus:ring-orange-100 focus:outline-none transition-all duration-300 @error('email') border-red-500 @enderror"
                           placeholder="exemple@email.com" required>
                    @error('email')
                        <p class="text-red-500 text-xs sm:text-sm mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Rôle <span class="text-red-500">*</span>
                    </label>
                    <select name="role" class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-orange-500 focus:ring-4 focus:ring-orange-100 focus:outline-none transition-all duration-300 @error('role') border-red-500 @enderror" required>
                        <option value="">Choisir un rôle...</option>
                        <option value="Superuser" {{ old('role') == 'Superuser' ? 'selected' : '' }}>👑 Superuser</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>👤 Utilisateur standard</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs sm:text-sm mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Mot de passe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="addPassword"
                               class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-orange-500 focus:ring-4 focus:ring-orange-100 focus:outline-none transition-all duration-300 @error('password') border-red-500 @enderror"
                               placeholder="Min. 8 caractères" required>
                        <button type="button" onclick="togglePasswordVisibility('addPassword', 'addEyeIcon')"
                                class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-xl sm:text-2xl hover:scale-125 transition-transform duration-300">
                            <span id="addEyeIcon">👁️</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs sm:text-sm mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Confirmer le mot de passe <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="addPasswordConfirmation"
                               class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-orange-500 focus:ring-4 focus:ring-orange-100 focus:outline-none transition-all duration-300"
                               placeholder="Répéter le mot de passe" required>
                        <button type="button" onclick="togglePasswordVisibility('addPasswordConfirmation', 'addConfirmEyeIcon')"
                                class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-xl sm:text-2xl hover:scale-125 transition-transform duration-300">
                            <span id="addConfirmEyeIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 pt-4 sm:pt-6">
                    <button type="button" onclick="closeAddModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-bold shadow-lg transform hover:scale-105 transition-all duration-300">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-pink-600 text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-bold shadow-lg transform hover:scale-105 transition-all duration-300">
                        Créer ✨
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Modification Premium -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 sm:p-8 transform scale-95 opacity-0 transition-all duration-500 border-4 border-blue-500 shadow-2xl" id="editModalBox">
            <div class="flex justify-between items-center mb-6 sm:mb-8">
                <h2 class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500 flex items-center gap-2 sm:gap-3">
                    <span class="text-3xl sm:text-4xl">✏️</span>
                    Modifier l'Utilisateur
                </h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-blue-500 text-3xl sm:text-4xl font-bold transition-all transform hover:rotate-90 duration-300">×</button>
            </div>

            <form id="editForm" method="POST" class="space-y-4 sm:space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Nom complet <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="edit_name" name="name"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300" required>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="edit_email" name="email"
                           class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300" required>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Rôle <span class="text-red-500">*</span>
                    </label>
                    <select id="edit_role" name="role" class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300" required>
                        <option value="Superuser">👑 Superuser</option>
                        <option value="user">👤 Utilisateur standard</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Nouveau mot de passe (optionnel)
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="editPassword"
                               class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300"
                               placeholder="Laisser vide pour ne pas changer">
                        <button type="button" onclick="togglePasswordVisibility('editPassword', 'editEyeIcon')"
                                class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-xl sm:text-2xl hover:scale-125 transition-transform duration-300">
                            <span id="editEyeIcon">👁️</span>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Laisser vide si vous ne voulez pas changer le mot de passe</p>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="editPasswordConfirmation"
                               class="w-full border-2 border-gray-300 rounded-xl px-4 sm:px-5 py-2 sm:py-3 font-medium focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300"
                               placeholder="Si changement de mot de passe">
                        <button type="button" onclick="togglePasswordVisibility('editPasswordConfirmation', 'editConfirmEyeIcon')"
                                class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-xl sm:text-2xl hover:scale-125 transition-transform duration-300">
                            <span id="editConfirmEyeIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 pt-4 sm:pt-6">
                    <button type="button" onclick="closeEditModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-bold shadow-lg transform hover:scale-105 transition-all duration-300">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-purple-600 text-white px-6 sm:px-8 py-2 sm:py-3 rounded-xl font-bold shadow-lg transform hover:scale-105 transition-all duration-300">
                        Enregistrer ✨
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<script>
// Variables globales
let currentEditUserId = null;

// Fonctions pour les modals
function openAddModal() {
    const modal = document.getElementById('addModal');
    const box = document.getElementById('addModalBox');
    modal.classList.remove('hidden');
    setTimeout(() => {
        box.classList.remove('scale-95','opacity-0');
        box.classList.add('scale-100','opacity-100');
    }, 10);
}

function closeAddModal() {
    const modal = document.getElementById('addModal');
    const box = document.getElementById('addModalBox');
    box.classList.remove('scale-100','opacity-100');
    box.classList.add('scale-95','opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('addForm').reset();
    }, 300);
}

async function openEditModal(id) {
    currentEditUserId = id;

    try {
        const response = await fetch(`/admin/utilisateurs/${id}`);
        const user = await response.json();

        const modal = document.getElementById('editModal');
        const box = document.getElementById('editModalBox');
        const form = document.getElementById('editForm');

        form.action = `/admin/utilisateurs/${id}`;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;

        document.getElementById('editPassword').value = '';
        document.getElementById('editPasswordConfirmation').value = '';

        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95','opacity-0');
            box.classList.add('scale-100','opacity-100');
        }, 10);

    } catch (error) {
        console.error('Erreur lors du chargement des données:', error);
        alert('Impossible de charger les données de l\'utilisateur');
    }
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    const box = document.getElementById('editModalBox');
    box.classList.remove('scale-100','opacity-100');
    box.classList.add('scale-95','opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        currentEditUserId = null;
    }, 300);
}

function togglePasswordVisibility(passwordFieldId, eyeIconId) {
    const passwordField = document.getElementById(passwordFieldId);
    const eyeIcon = document.getElementById(eyeIconId);

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.textContent = '🙈';
    } else {
        passwordField.type = 'password';
        eyeIcon.textContent = '👁️';
    }
}

function confirmDelete(event) {
    event.preventDefault();

    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });

    return false;
}

// Gestion des clics en dehors des modals
document.getElementById('addModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAddModal();
});

document.getElementById('editModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// Ouvrir le modal d'ajout en cas d'erreurs
@if($errors->any() && !session('_old_input._method') && !$errors->has('password'))
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            openAddModal();
        }, 500);
    });
@endif

// Ouvrir le modal d'édition en cas d'erreurs sur l'édition
@if($errors->any() && session('_old_input._method') === 'PUT')
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            if ({{ old('id') ?? 'null' }}) {
                openEditModal({{ old('id') }});
            }
        }, 500);
    });
@endif
</script>

@endsection