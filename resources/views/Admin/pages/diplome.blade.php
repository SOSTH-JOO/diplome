@extends('Admin.layouts.app2')

@section('title', 'Accueil Admin')

@section('content')

<main class="bg-gradient-to-br from-gray-50 via-orange-50 to-gray-100 min-h-screen">

    <!-- Navbar avec effet glassmorphism -->
    <nav class="bg-white/80 backdrop-blur-lg border-b-4 border-orange-500 shadow-2xl px-8 py-4 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3 group">
                <span class="text-3xl transform group-hover:scale-110 transition-transform duration-300">🎓</span>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-orange-600 bg-clip-text text-transparent">
                    Administration <span class="text-orange-500">Diplômes</span>
                </h1>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-gray-600 text-sm bg-orange-50 px-4 py-2 rounded-full border border-orange-200">
                    Connecté en tant qu'<span class="text-orange-600 font-bold">Admin</span>
                </span>

                <button onclick="openModal()"
                        class="relative bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 overflow-hidden group">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <span class="relative">📊 Données</span>
                </button>

                <a href="{{ route('admin.Monprofil') }}"
                   class="relative bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white px-6 py-2.5 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 overflow-hidden group">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <span class="relative">👤 Mon Profil</span>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold px-4 py-2 rounded-lg hover:bg-red-50 transition-all duration-200">
                        ⚡ Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Modal avec animation améliorée -->
    <div id="dataModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center z-50 transition-all duration-300">
        <div id="modalBox" class="bg-white border-4 border-orange-500 rounded-2xl shadow-2xl w-96 p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent flex items-center gap-2">
                    <span class="text-2xl">⚙️</span> Gestion des données
                </h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-orange-500 text-3xl font-bold transition-all duration-200 hover:rotate-90 transform">&times;</button>
            </div>
            <div class="space-y-3">
                <a href="{{ route('admin.export') }}"
                   class="block w-full text-center bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    📤 Exporter les étudiants
                </a>
                <a href="{{ route('admin.import.form') }}"
                   class="block w-full text-center bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    📥 Importer les étudiants
                </a>
                <a href="{{ route('admin.utilisateurs') }}"
                   class="block w-full text-center bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    👥 Tous les utilisateurs
                </a>
                <a href="{{ route('admin.classes') }}"
                   class="block w-full text-center bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    🎯 Toutes les classes
                </a>
            </div>
        </div>
    </div>

    <!-- Contenu Principal -->
    <div class="max-w-7xl mx-auto mt-8 px-4">

        <!-- Barre de recherche et compteur avec effet -->
        <div class="mb-6 flex justify-between items-center gap-4">
            <div class="w-1/3 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Rechercher un auditeur..."
                       class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-200 transition-all duration-300 shadow-sm hover:shadow-md bg-white">
            </div>

            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl shadow-lg">
                    <span class="font-bold text-2xl">{{ $nombreAuditeurs }}</span>
                    <span class="text-orange-100 ml-2">auditeur(s)</span>
                </div>
            </div>
        </div>

        <!-- Section Liste avec design moderne -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border-t-4 border-orange-500 hover:shadow-3xl transition-shadow duration-300">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="text-orange-500 bg-orange-100 p-3 rounded-xl">📄</span> 
                    <span class="bg-gradient-to-r from-gray-800 to-orange-600 bg-clip-text text-transparent">Liste des auditeurs</span>
                </h2>

                <!-- Filtres par classe avec style amélioré -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.diplome', ['classe' => 'tous']) }}"
                       class="px-5 py-2.5 rounded-xl {{ $classe == 'tous' || !$classe ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg' : 'bg-gray-100 hover:bg-gray-200 text-gray-800' }} font-semibold transition-all duration-300 transform hover:scale-105">
                        ✨ Tous
                    </a>

                    @foreach($classes as $class)
                        <a href="{{ route('admin.diplome', ['classe' => $class->nom]) }}"
                           class="px-5 py-2.5 rounded-xl {{ $classe == $class->nom ? 'bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg' : 'bg-gray-100 hover:bg-gray-200 text-gray-800' }} font-semibold transition-all duration-300 transform hover:scale-105">
                            {{ $class->nom }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border-2 border-gray-200 shadow-inner">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                        <tr>
                            <th class="py-4 px-4 text-left font-bold">Photo</th>
                            <th class="py-4 px-4 text-left font-bold">ID</th>
                            <th class="py-4 px-4 text-left font-bold">Nom</th>
                            <th class="py-4 px-4 text-left font-bold">Prénom</th>
                            <th class="py-4 px-4 text-left font-bold">Genre</th>
                            <th class="py-4 px-4 text-left font-bold">Téléphone</th>
                            <th class="py-4 px-4 text-left font-bold">Date de naissance</th>
                            <th class="py-4 px-4 text-left font-bold">Pays de naissance</th>
                            <th class="py-4 px-4 text-left font-bold">Ville de résidence</th>
                            <th class="py-4 px-4 text-left font-bold">Poste occupé</th>
                            <th class="py-4 px-4 text-left font-bold">Employeur</th>
                            <th class="py-4 px-4 text-left font-bold">Email Ajout</th>
                            <th class="py-4 px-4 text-left font-bold">Email Exact</th>
                            <th class="py-4 px-4 text-left font-bold">Classe</th>
                            <th class="py-4 px-4 text-center font-bold">Statut</th>
                            <th class="py-4 px-4 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="auditeursTable" class="divide-y divide-gray-200">
                        @foreach($auditeurs as $auditeur)
                        <tr class="hover:bg-gradient-to-r hover:from-orange-50 hover:to-transparent transition-all duration-200 student-row group"
                            data-classe="{{ $auditeur->classe->nom ?? 'Sans classe' }}">
                            <!-- Photo -->
                            <td class="py-4 px-4">
                                @if($auditeur->photo)
                                    <img src="{{ asset('storage/' . $auditeur->photo) }}"
                                         alt="{{ $auditeur->nom }} {{ $auditeur->prenom }}"
                                         class="w-12 h-12 rounded-full object-cover mx-auto border-2 border-orange-200 shadow-md group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-200 to-orange-300 flex items-center justify-center mx-auto shadow-md group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-orange-700 font-bold text-sm">
                                            {{ substr($auditeur->nom, 0, 1) }}{{ substr($auditeur->prenom, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </td>

                            <!-- ID -->
                            <td class="py-4 px-4 font-bold text-gray-900">
                                {{ $auditeur->auditeur_id }}
                            </td>

                            <!-- Nom et Prénom -->
                            <td class="py-4 px-4 font-semibold text-gray-900">
                                {{ $auditeur->nom }}
                            </td>
                            <td class="py-4 px-4 text-gray-700">
                                {{ $auditeur->prenom ?? 'N/A' }}
                            </td>

                            <!-- Genre -->
                            <td class="py-4 px-4 text-gray-700">
                                {{ $auditeur->genre ?? 'N/A' }}
                            </td>

                            <!-- Téléphone -->
                            <td class="py-4 px-4 text-gray-700 font-mono">
                                {{ $auditeur->telephone ?? 'N/A' }}
                            </td>

                            <!-- Date de naissance -->
                            <td class="py-4 px-4 text-gray-700">
                                {{ $auditeur->date_naissance ? $auditeur->date_naissance->format('d/m/Y') : 'N/A' }}
                            </td>

                            <!-- Pays de naissance -->
                            <td class="py-4 px-4 text-gray-700">
                                {{ $auditeur->pays_naissance ?? 'N/A' }}
                            </td>

                            <!-- Ville de résidence -->
                            <td class="py-4 px-4 text-gray-700">
                                {{ $auditeur->ville_residence ?? 'N/A' }}
                            </td>

                            <!-- Poste occupé -->
                            <td class="py-4 px-4 text-gray-700">
                                {{ $auditeur->poste_occupe ?? 'N/A' }}
                            </td>

                            <!-- Employeur -->
                            <td class="py-4 px-4 text-gray-700">
                                {{ $auditeur->employeur ?? 'N/A' }}
                            </td>

                            <!-- Email 1 -->
                            <td class="py-4 px-4 text-gray-800">
                                {{ $auditeur->mail_ajout ?? 'N/A' }}
                            </td>

                            <!-- Email 2 -->
                            <td class="py-4 px-4 text-gray-800">
                                {{ $auditeur->mail_exact ?? 'N/A' }}
                            </td>

                            <!-- Classe -->
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold
                                            bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border-2 border-orange-300 shadow-sm">
                                    {{ $auditeur->classe->nom ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Statut -->
                            <td class="py-4 px-4 text-center">
                                @if($auditeur->is_active == 1)
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold
                                                bg-gradient-to-r from-green-100 to-green-200 text-green-800 border-2 border-green-300 shadow-sm">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                        Actif
                                    </span>
                                @elseif($auditeur->is_active === 0)
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold
                                                bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border-2 border-yellow-300 shadow-sm">
                                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                                        En attente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold
                                                bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border-2 border-gray-300 shadow-sm">
                                        <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                        Non défini
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-center">
                                <a href="{{ route('admin.etudiants.show', $auditeur->id) }}"
                                   class="inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white
                                          px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 shadow-lg
                                          hover:shadow-xl transform hover:-translate-y-1 group">
                                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($auditeurs->isEmpty())
                        <tr>
                            <td colspan="17" class="py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-300 mb-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-xl font-bold text-gray-400">Aucun auditeur trouvé</p>
                                    <p class="text-sm text-gray-400 mt-2">Essayez de modifier vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Footer avec effet -->
    <footer class="text-center text-gray-500 mt-16 pb-8">
        <div class="bg-gradient-to-r from-transparent via-orange-200 to-transparent h-px w-64 mx-auto mb-4"></div>
        <p class="text-sm font-medium">© 2026 Système de Diplômes – <span class="text-orange-600 font-bold">Administration</span></p>
    </footer>

</main>

<!-- Scripts avec animations améliorées -->
<script>
function openModal() {
    const modal = document.getElementById('dataModal');
    const box = document.getElementById('modalBox');
    modal.classList.remove('hidden');
    setTimeout(() => {
        box.classList.remove('scale-95','opacity-0');
        box.classList.add('scale-100','opacity-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('dataModal');
    const box = document.getElementById('modalBox');
    box.classList.remove('scale-100','opacity-100');
    box.classList.add('scale-95','opacity-0');
    setTimeout(() => { modal.classList.add('hidden'); }, 300);
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('dataModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Recherche en temps réel avec animation
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#auditeursTable tr.student-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.classList.remove('hidden');
            row.style.animation = 'fadeIn 0.3s ease-in';
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }
    });

    updateCounter(visibleCount);
});

function updateCounter(count) {
    const counterElement = document.querySelector('.text-2xl');
    if (counterElement) {
        counterElement.style.transition = 'transform 0.3s ease';
        counterElement.style.transform = 'scale(1.2)';
        counterElement.textContent = count;
        setTimeout(() => {
            counterElement.style.transform = 'scale(1)';
        }, 300);
    }
}

// Animation CSS pour fadeIn
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>

@endsection