@extends('Admin.layouts.app2')

@section('title', 'Gestion des Classes')

@section('content')

<main class="min-h-screen p-6 md:p-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">

    <div class="max-w-7xl mx-auto">

        <!-- Header avec effet glassmorphism -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-6 mb-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2 border border-white/20 animate-[slideIn_0.6s_ease-out]">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-black bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 bg-clip-text text-transparent drop-shadow-lg">
                        📚 Gestion des Classes
                    </h1>
                    <p class="text-gray-600 mt-2 text-lg font-semibold">Gérez vos classes avec style et efficacité</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.diplome') }}"
                       class="relative overflow-hidden bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-2xl flex items-center gap-2 group">
                        <span class="text-xl group-hover:animate-bounce">←</span> 
                        <span class="relative z-10">Retour</span>
                    </a>
                    <button onclick="openAddModal()"
                            class="relative overflow-hidden bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-2xl flex items-center gap-2 group">
                        <span class="text-2xl group-hover:rotate-90 transition-transform duration-300">+</span> 
                        <span class="relative z-10">Nouvelle Classe</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages de succès/erreur avec animations -->
        @if(session('success'))
            <div class="bg-white/80 backdrop-blur-xl border-l-4 border-green-500 p-5 mb-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-[slideIn_0.5s_ease-out]">
                <div class="flex items-center gap-3">
                    <span class="text-3xl animate-bounce">✅</span>
                    <p class="font-bold text-green-700 text-lg">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-white/80 backdrop-blur-xl border-l-4 border-red-500 p-5 mb-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-[slideIn_0.5s_ease-out]">
                <div class="flex items-center gap-3">
                    <span class="text-3xl animate-pulse">⚠️</span>
                    <p class="font-bold text-red-700 text-lg">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Statistiques avec design moderne -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-l-4 border-orange-500 animate-[slideIn_0.7s_ease-out] group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-bold uppercase tracking-wide">Total Classes</p>
                        <p class="text-5xl font-black text-orange-600 mt-2 group-hover:scale-110 transition-transform duration-300">{{ $classes->count() }}</p>
                        <div class="mt-3 h-2 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full w-20 group-hover:w-full transition-all duration-500"></div>
                    </div>
                    <div class="text-6xl group-hover:animate-bounce">📚</div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-l-4 border-blue-500 animate-[slideIn_0.8s_ease-out] group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-bold uppercase tracking-wide">Total Auditeurs</p>
                        <p class="text-5xl font-black text-blue-600 mt-2 group-hover:scale-110 transition-transform duration-300">{{ $classes->sum('auditeurs_count') }}</p>
                        <div class="mt-3 h-2 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full w-20 group-hover:w-full transition-all duration-500"></div>
                    </div>
                    <div class="text-6xl group-hover:animate-bounce">👥</div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border-l-4 border-green-500 animate-[slideIn_0.9s_ease-out] group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-bold uppercase tracking-wide">Filières Actives</p>
                        <p class="text-5xl font-black text-green-600 mt-2 group-hover:scale-110 transition-transform duration-300">{{ $classes->unique('filiere')->count() }}</p>
                        <div class="mt-3 h-2 bg-gradient-to-r from-green-400 to-green-600 rounded-full w-20 group-hover:w-full transition-all duration-500"></div>
                    </div>
                    <div class="text-6xl group-hover:animate-bounce">🎯</div>
                </div>
            </div>
        </div>

        <!-- Tableau moderne avec glassmorphism -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl overflow-hidden animate-[slideIn_1s_ease-out] border border-white/20">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6">
                <h2 class="text-2xl font-black text-white flex items-center gap-3">
                    <span class="text-3xl">📋</span> Liste des Classes
                </h2>
            </div>

            <div class="p-6">
                @if($classes->isEmpty())
                    <div class="text-center py-16">
                        <div class="text-8xl mb-6 animate-bounce">📚</div>
                        <p class="text-gray-600 text-2xl font-bold mb-6">Aucune classe disponible</p>
                        <button onclick="openAddModal()"
                                class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-2xl text-lg hover:scale-105">
                            🚀 Créer la première classe
                        </button>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                                    <th class="py-5 px-6 text-left font-black text-sm uppercase tracking-wider">#</th>
                                    <th class="py-5 px-6 text-left font-black text-sm uppercase tracking-wider">Nom de la Classe</th>
                                    <th class="py-5 px-6 text-left font-black text-sm uppercase tracking-wider">Filière</th>
                                    <th class="py-5 px-6 text-center font-black text-sm uppercase tracking-wider">Auditeurs</th>
                                    <th class="py-5 px-6 text-center font-black text-sm uppercase tracking-wider">Date</th>
                                    <th class="py-5 px-6 text-center font-black text-sm uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($classes as $index => $classe)
                                    <tr class="transition-all duration-300 hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 hover:scale-[1.01] group">
                                        <td class="py-4 px-6">
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-orange-600 text-white font-black shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                {{ $index + 1 }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="text-gray-800 font-black text-lg group-hover:text-orange-600 transition-colors duration-300">{{ $classe->nom }}</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-block px-4 py-2 rounded-full font-bold text-sm shadow-md bg-gradient-to-r from-blue-400 to-blue-600 text-white group-hover:scale-105 transition-transform duration-300">
                                                🎓 {{ $classe->filiere }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full font-black text-sm shadow-md bg-gradient-to-r from-purple-400 to-purple-600 text-white group-hover:scale-105 transition-transform duration-300">
                                                {{ $classe->auditeurs_count }} 👥
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="text-gray-600 font-semibold">{{ $classe->created_at->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex justify-center gap-3">
                                                <button onclick="openEditModal({{ $classe->id }}, '{{ $classe->nom }}', '{{ $classe->filiere }}')"
                                                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-5 py-2 rounded-lg font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 flex items-center gap-2">
                                                    ✏️ Modifier
                                                </button>

                                                <form action="{{ route('admin.classes.destroy', $classe) }}" method="POST"
                                                      onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette classe ?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white px-5 py-2 rounded-lg font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 flex items-center gap-2">
                                                        🗑️ Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Modal Ajout - Ultra moderne -->
    <div id="addModal" class="fixed inset-0 bg-black/60 backdrop-blur-md hidden flex items-center justify-center z-50 p-4 transition-opacity duration-300">
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-lg transform scale-95 opacity-0 transition-all duration-500 ease-out border-4 border-orange-500" id="addModalBox">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-t-3xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-3xl font-black text-white flex items-center gap-3">
                        ➕ Nouvelle Classe
                    </h2>
                    <button onclick="closeAddModal()" class="text-white hover:text-orange-200 text-4xl font-bold transition-all duration-300 transform hover:rotate-90">&times;</button>
                </div>
            </div>

            <form action="{{ route('admin.classes.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">
                        Nom de la Classe <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="w-full border-2 border-gray-300 rounded-xl px-5 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-200 focus:outline-none transition-all duration-300 font-semibold hover:border-orange-300 @error('nom') border-red-500 @enderror"
                           placeholder="Ex: Data Analyst 2024" required>
                    @error('nom') <p class="text-red-500 text-sm mt-2 font-bold flex items-center gap-2"><span>⚠️</span>{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">
                        Filière <span class="text-red-500">*</span>
                    </label>
                    <select name="filiere"
                            class="w-full border-2 border-gray-300 rounded-xl px-5 py-3 focus:border-orange-500 focus:ring-4 focus:ring-orange-200 focus:outline-none transition-all duration-300 font-semibold hover:border-orange-300 @error('filiere') border-red-500 @enderror" required>
                        <option value="">🎯 Choisir une filière...</option>
                        <option value="Data" {{ old('filiere') == 'Data' ? 'selected' : '' }}>📊 Data</option>
                        <option value="Finance" {{ old('filiere') == 'Finance' ? 'selected' : '' }}>💰 Finance</option>
                        <option value="Logistique" {{ old('filiere') == 'Logistique' ? 'selected' : '' }}>🚚 Logistique</option>
                        <option value="Complexite" {{ old('filiere') == 'Complexite' ? 'selected' : '' }}>🧩 Complexité</option>
                        <option value="Psa" {{ old('filiere') == 'Psa' ? 'selected' : '' }}>🎓 PSA</option>
                    </select>
                    @error('filiere') <p class="text-red-500 text-sm mt-2 font-bold flex items-center gap-2"><span>⚠️</span>{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <button type="button" onclick="closeAddModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                        ✨ Créer la Classe
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Modification - Ultra moderne -->
    <div id="editModal" class="fixed inset-0 bg-black/60 backdrop-blur-md hidden flex items-center justify-center z-50 p-4 transition-opacity duration-300">
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-lg transform scale-95 opacity-0 transition-all duration-500 ease-out border-4 border-blue-500" id="editModalBox">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-t-3xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-3xl font-black text-white flex items-center gap-3">
                        ✏️ Modifier la Classe
                    </h2>
                    <button onclick="closeEditModal()" class="text-white hover:text-blue-200 text-4xl font-bold transition-all duration-300 transform hover:rotate-90">&times;</button>
                </div>
            </div>

            <form id="editForm" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">
                        Nom de la Classe <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="edit_nom" name="nom"
                           class="w-full border-2 border-gray-300 rounded-xl px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:outline-none transition-all duration-300 font-semibold hover:border-blue-300"
                           placeholder="Ex: Data Analyst 2024" required>
                </div>

                <div>
                    <label class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">
                        Filière <span class="text-red-500">*</span>
                    </label>
                    <select id="edit_filiere" name="filiere"
                            class="w-full border-2 border-gray-300 rounded-xl px-5 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:outline-none transition-all duration-300 font-semibold hover:border-blue-300" required>
                        <option value="">🎯 Choisir une filière...</option>
                        <option value="Data">📊 Data</option>
                        <option value="Finance">💰 Finance</option>
                        <option value="Logistique">🚚 Logistique</option>
                        <option value="Complexite">🧩 Complexité</option>
                        <option value="Psa">🎓 PSA</option>
                    </select>
                </div>

                <div class="flex justify-end gap-4 pt-6">
                    <button type="button" onclick="closeEditModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105">
                        💾 Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<script>
// Modal Ajout avec animations fluides
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
    setTimeout(() => { modal.classList.add('hidden'); }, 500);
}

// Modal Modification avec animations fluides
function openEditModal(id, nom, filiere) {
    const modal = document.getElementById('editModal');
    const box = document.getElementById('editModalBox');
    const form = document.getElementById('editForm');

    form.action = `/admin/classes/${id}`;
    document.getElementById('edit_nom').value = nom;
    document.getElementById('edit_filiere').value = filiere;

    modal.classList.remove('hidden');
    setTimeout(() => {
        box.classList.remove('scale-95','opacity-0');
        box.classList.add('scale-100','opacity-100');
    }, 10);
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    const box = document.getElementById('editModalBox');
    box.classList.remove('scale-100','opacity-100');
    box.classList.add('scale-95','opacity-0');
    setTimeout(() => { modal.classList.add('hidden'); }, 500);
}

// Fermer les modals en cliquant à l'extérieur
document.getElementById('addModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeAddModal();
});

document.getElementById('editModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// Réouvrir le modal si erreur de validation
@if($errors->any())
    openAddModal();
@endif
</script>

@endsection