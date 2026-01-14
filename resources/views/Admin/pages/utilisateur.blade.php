@extends('Admin.layouts.app2')

@section('title', 'Gestion des Utilisateurs')

@section('content')

<main class="bg-gray-50 min-h-screen p-8">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <span class="text-orange-500">👥</span> Gestion des Utilisateurs
                </h1>
                <p class="text-gray-600 mt-1">Gérez les comptes utilisateurs et leurs accès</p>
            </div>
            <a href="{{ route('admin.diplome') }}"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                    👤 Retour
                </a>
            <button onclick="openAddModal()"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 shadow-lg flex items-center">
                <span class="mr-2 text-xl">+</span> Nouvel Utilisateur
            </button>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow animate-slide-in">
                <p class="font-medium">✓ {{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow animate-slide-in">
                <p class="font-medium">✗ {{ session('error') }}</p>
            </div>
        @endif

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white border-l-4 border-orange-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Utilisateurs</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $utilisateurs->count() }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-purple-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Superusers</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $utilisateurs->where('role', 'Superuser')->count() }}</p>
                    </div>
                    <div class="text-4xl">👑</div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-blue-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Utilisateurs standards</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $utilisateurs->where('role', 'user')->count() }}</p>
                    </div>
                    <div class="text-4xl">👤</div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-green-500 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Actifs</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $utilisateurs->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="text-4xl">✓</div>
                </div>
            </div>
        </div>

        <!-- Tableau -->
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-orange-500 overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="text-orange-500 mr-2">📋</span> Liste des Utilisateurs
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-orange-500 text-white">
                            <tr>
                                <th class="py-4 px-4 text-left font-bold">#</th>
                                <th class="py-4 px-4 text-left font-bold">Nom</th>
                                <th class="py-4 px-4 text-left font-bold">Email</th>
                                <th class="py-4 px-4 text-center font-bold">Rôle</th>
                                <th class="py-4 px-4 text-center font-bold">Profil Auditeur</th>
                                <th class="py-4 px-4 text-center font-bold">Statut</th>
                                <th class="py-4 px-4 text-center font-bold">Date d'inscription</th>
                                <th class="py-4 px-4 text-center font-bold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($utilisateurs as $index => $user)
                                <tr class="hover:bg-orange-50 transition">
                                    <td class="py-3 px-4 text-gray-700 font-medium">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 text-gray-800 font-semibold">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="text-orange-500 text-xs">(Vous)</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="py-3 px-4 text-center">
                                        @if($user->role === 'Superuser')
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                👑 Superuser
                                            </span>
                                        @else
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                👤 Utilisateur
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($user->auditeur_count > 0)
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                ✓ Complété
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm">
                                                - Non complété
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($user->is_active)
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                ● Actif
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                ● Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center text-gray-600 text-sm">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex justify-center space-x-2">
                                            <!-- Bouton Modifier -->
                                            <button onclick="openEditModal({{ $user->id }})"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-md">
                                                ✏️
                                            </button>

                                            <!-- Bouton Activer/Désactiver -->
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.utilisateurs.toggleStatus', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="{{ $user->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-3 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-md"
                                                            title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                                        {{ $user->is_active ? '🚫' : '✅' }}
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Bouton Supprimer -->
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.utilisateurs.destroy', $user->id) }}" method="POST"
                                                      onsubmit="return confirmDelete(event)" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-md"
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
                                    <td colspan="8" class="text-center py-12">
                                        <div class="text-6xl mb-4">👥</div>
                                        <p class="text-gray-500 text-lg">Aucun utilisateur trouvé</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Ajout -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white border-4 border-orange-500 rounded-xl shadow-2xl w-full max-w-md p-6 transform scale-95 opacity-0 transition-all duration-300" id="addModalBox">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-orange-500">➕ Nouvel Utilisateur</h2>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-orange-500 text-3xl font-bold">&times;</button>
            </div>

            <form action="{{ route('admin.utilisateurs.store') }}" method="POST" class="space-y-4" id="addForm">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:outline-none @error('name') border-red-500 @enderror"
                           placeholder="Ex: Jean Kouamé" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:outline-none @error('email') border-red-500 @enderror"
                           placeholder="exemple@email.com" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rôle <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:outline-none @error('role') border-red-500 @enderror" required>
                        <option value="">Choisir un rôle...</option>
                        <option value="Superuser" {{ old('role') == 'Superuser' ? 'selected' : '' }}>👑 Superuser</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>👤 Utilisateur standard</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="addPassword"
                               class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:outline-none @error('password') border-red-500 @enderror"
                               placeholder="Min. 8 caractères" required>
                        <button type="button" onclick="togglePasswordVisibility('addPassword', 'addEyeIcon')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-orange-500">
                            <span id="addEyeIcon">👁️</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="addPasswordConfirmation"
                               class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:outline-none"
                               placeholder="Répéter le mot de passe" required>
                        <button type="button" onclick="togglePasswordVisibility('addPasswordConfirmation', 'addConfirmEyeIcon')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-orange-500">
                            <span id="addConfirmEyeIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeAddModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg font-semibold transition duration-200">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Modification -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white border-4 border-blue-500 rounded-xl shadow-2xl w-full max-w-md p-6 transform scale-95 opacity-0 transition-all duration-300" id="editModalBox">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-blue-500">✏️ Modifier l'Utilisateur</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-blue-500 text-3xl font-bold">&times;</button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_name" name="name"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="edit_email" name="email"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rôle <span class="text-red-500">*</span></label>
                    <select id="edit_role" name="role" class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none @error('role') border-red-500 @enderror" required>
                        <option value="Superuser">👑 Superuser</option>
                        <option value="user">👤 Utilisateur standard</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe (optionnel)</label>
                    <div class="relative">
                        <input type="password" name="password" id="editPassword"
                               class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none"
                               placeholder="Laisser vide pour ne pas changer">
                        <button type="button" onclick="togglePasswordVisibility('editPassword', 'editEyeIcon')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-500">
                            <span id="editEyeIcon">👁️</span>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Laisser vide si vous ne voulez pas changer le mot de passe</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="editPasswordConfirmation"
                               class="w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:outline-none"
                               placeholder="Si changement de mot de passe">
                        <button type="button" onclick="togglePasswordVisibility('editPasswordConfirmation', 'editConfirmEyeIcon')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-500">
                            <span id="editConfirmEyeIcon">👁️</span>
                        </button>
                    </div>
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
        // Récupérer les données de l'utilisateur
        const response = await fetch(`/admin/utilisateurs/${id}`);
        const user = await response.json();

        const modal = document.getElementById('editModal');
        const box = document.getElementById('editModalBox');
        const form = document.getElementById('editForm');

        // Mettre à jour le formulaire
        form.action = `/admin/utilisateurs/${id}`;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;

        // Réinitialiser les champs mot de passe
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

// Fonction pour afficher/masquer le mot de passe
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

// Fonction de confirmation de suppression
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

// Animation pour les messages
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>

@endsection
