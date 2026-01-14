@extends('Admin.layouts.app2')

@section('title', 'Gestion des Classes')

@section('content')

<main class="bg-gray-50 min-h-screen p-8">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <span class="text-orange-500">📚</span> Gestion des Classes
                </h1>
                <p class="text-gray-600 mt-1">Gérez les classes et leurs filières</p>
            </div>
            <a href="{{ route('admin.diplome') }}"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                    👤 Retour
                </a>
            <button onclick="openAddModal()"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 shadow-lg flex items-center">
                <span class="mr-2 text-xl">+</span> Ajouter une Classe
            </button>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border-l-4 border-orange-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Classes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $classes->count() }}</p>
                    </div>
                    <div class="text-4xl">📚</div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-blue-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Auditeurs</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $classes->sum('auditeurs_count') }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-green-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Filières Actives</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $classes->unique('filiere')->count() }}</p>
                    </div>
                    <div class="text-4xl">🎯</div>
                </div>
            </div>
        </div>

        <!-- Tableau des classes -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-orange-500 overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="text-orange-500 mr-2">📋</span> Liste des Classes
                </h2>

                @if($classes->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📚</div>
                        <p class="text-gray-500 text-lg">Aucune classe disponible</p>
                        <button onclick="openAddModal()"
                                class="mt-4 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                            Créer la première classe
                        </button>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-orange-500 text-white">
                                <tr>
                                    <th class="py-4 px-4 text-left font-bold">#</th>
                                    <th class="py-4 px-4 text-left font-bold">Nom de la Classe</th>
                                    <th class="py-4 px-4 text-left font-bold">Filière</th>
                                    <th class="py-4 px-4 text-center font-bold">Nombre d'Auditeurs</th>
                                    <th class="py-4 px-4 text-center font-bold">Date de Création</th>
                                    <th class="py-4 px-4 text-center font-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($classes as $index => $classe)
                                    <tr class="hover:bg-orange-50 transition">
                                        <td class="py-3 px-4 text-gray-700 font-medium">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 text-gray-800 font-semibold">{{ $classe->nom }}</td>
                                        <td class="py-3 px-4">
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $classe->filiere }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                {{ $classe->auditeurs_count }} 👥
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center text-gray-600 text-sm">
                                            {{ $classe->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <button onclick="openEditModal({{ $classe->id }}, '{{ $classe->nom }}', '{{ $classe->filiere }}')"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-md">
                                                    ✏️ Modifier
                                                </button>

                                                <form action="{{ route('admin.classes.destroy', $classe) }}" method="POST"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-md">
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

    <!-- Modal Ajout -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white border-4 border-orange-500 rounded-xl shadow-2xl w-full max-w-md p-6 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="addModalBox">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-orange-500">➕ Ajouter une Classe</h2>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-orange-500 text-3xl font-bold transition duration-200">&times;</button>
            </div>

            <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la Classe <span class="text-red-500">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:outline-none @error('nom') border-red-500 @enderror"
                           placeholder="Ex: Data Analyst 2024" required>
                    @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filière <span class="text-red-500">*</span></label>
                    <select name="filiere"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:outline-none @error('filiere') border-red-500 @enderror" required>
                        <option value="">Choisir une filière...</option>
                        <option value="Data" {{ old('filiere') == 'Data' ? 'selected' : '' }}>Data</option>
                        <option value="Finance" {{ old('filiere') == 'Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Logistique" {{ old('filiere') == 'Logistique' ? 'selected' : '' }}>Logistique</option>
                    </select>
                    @error('filiere') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeAddModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition duration-200">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Modification -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white border-4 border-blue-500 rounded-xl shadow-2xl w-full max-w-md p-6 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="editModalBox">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-blue-500">✏️ Modifier la Classe</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-blue-500 text-3xl font-bold transition duration-200">&times;</button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la Classe <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nom" name="nom"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none"
                           placeholder="Ex: Data Analyst 2024" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filière <span class="text-red-500">*</span></label>
                    <select id="edit_filiere" name="filiere"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none" required>
                        <option value="">Choisir une filière...</option>
                        <option value="Data">Data</option>
                        <option value="Finance">Finance</option>
                        <option value="Logistique">Logistique</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeEditModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition duration-200">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<script>
// Modal Ajout
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
    setTimeout(() => { modal.classList.add('hidden'); }, 300);
}

// Modal Modification
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
    setTimeout(() => { modal.classList.add('hidden'); }, 300);
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
