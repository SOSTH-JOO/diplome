@extends('Admin.layouts.app2')

@section('title', 'Accueil Admin')

@section('content')

<main class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b-4 border-orange-500 shadow-lg px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-3xl">🎓</span>
                <h1 class="text-2xl font-bold text-gray-800">Administration <span class="text-orange-500">Diplômes</span></h1>
            </div>

            <div class="flex items-center space-x-4">
                <span class="text-gray-600 text-sm">Connecté en tant qu'<span class="text-orange-500 font-semibold">Admin</span></span>

                <button onclick="openModal()"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                    📊 Données
                </button>

                <a href="{{ route('admin.Monprofil') }}"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                    👤 Mon Profil
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
    @csrf
    <button type="submit" class="text-red-600 hover:underline">Se déconnecter</button>
</form>

            </div>
        </div>
    </nav>

    <!-- Modal -->
    <div id="dataModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 transition-opacity duration-300">
        <div id="modalBox" class="bg-white border-4 border-orange-500 rounded-xl shadow-2xl w-96 p-6 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-orange-500">Gestion des données</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-orange-500 text-3xl font-bold transition duration-200">&times;</button>
            </div>
            <div class="space-y-3">
                <a href="{{ route('admin.export') }}"
                   class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-semibold transition duration-200 shadow-md">
                    📤 Exporter les étudiants
                </a>
                <a href="{{ route('admin.import.form') }}"
                   class="block w-full text-center bg-gray-800 hover:bg-gray-900 text-white py-3 rounded-lg font-semibold transition duration-200 shadow-md">
                    📥 Importer les étudiants
                </a>
                <a href="{{ route('admin.utilisateurs') }}"
                   class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg font-semibold transition duration-200">
                    👥 Tous les utilisateurs
                </a>
                <a href="{{ route('admin.classes') }}"
                   class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg font-semibold transition duration-200">
                    👥 Toutes les classes
                </a>
            </div>
        </div>
    </div>

    <!-- Contenu Principal -->
    <div class="max-w-7xl mx-auto mt-8 px-4">

        <!-- Barre de recherche et compteur -->
        <div class="mb-6 flex justify-between items-center">
            <div class="w-1/3">
                <input type="text" id="searchInput" placeholder="Rechercher un auditeur..."
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition duration-200">
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-gray-700">
                    <span class="font-semibold text-orange-500 text-lg">{{ $nombreAuditeurs }}</span>
                    <span class="text-gray-600"> auditeur(s) affiché(s)</span>
                </div>
            </div>
        </div>

        <!-- Section Liste -->
      <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-orange-500">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <span class="text-orange-500 mr-2">📄</span> Liste des auditeurs
        </h2>

        <!-- Filtres par classe -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.diplome', ['classe' => 'tous']) }}"
               class="px-4 py-2 rounded-lg {{ $classe == 'tous' || !$classe ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800' }} font-semibold transition duration-200 shadow-md">
                Tous
            </a>

            @foreach($classes as $class)
                <a href="{{ route('admin.diplome', ['classe' => $class->nom]) }}"
                   class="px-4 py-2 rounded-lg {{ $classe == $class->nom ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-800' }} font-semibold transition duration-200 shadow-md">
                    {{ $class->nom }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold">Photo</th>
                    <th class="py-3 px-4 text-left font-semibold">ID</th>
                    <th class="py-3 px-4 text-left font-semibold">Nom </th>
                                        <th class="py-3 px-4 text-left font-semibold">Prénom</th>

                    <th class="py-3 px-4 text-left font-semibold">Genre</th>
                    <th class="py-3 px-4 text-left font-semibold">Téléphone</th>
                    <th class="py-3 px-4 text-left font-semibold">Date de naissance</th>
                    <th class="py-3 px-4 text-left font-semibold">Lieu de naissance</th>
                    <th class="py-3 px-4 text-left font-semibold">Ville de résidence</th>
                    <th class="py-3 px-4 text-left font-semibold">Poste occupé</th>
                    <th class="py-3 px-4 text-left font-semibold">Employeur</th>
                    <th class="py-3 px-4 text-left font-semibold">Identifiant</th>
                    <th class="py-3 px-4 text-left font-semibold">Filière</th>
                    <th class="py-3 px-4 text-left font-semibold">Email 1</th>
                    <th class="py-3 px-4 text-left font-semibold">Email 2</th>
                    <th class="py-3 px-4 text-left font-semibold">Classe</th>
                    <th class="py-3 px-4 text-center font-semibold">Statut</th>
                    <th class="py-3 px-4 text-center font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody id="auditeursTable" class="divide-y divide-gray-200">
                @foreach($auditeurs as $auditeur)
                <tr class="hover:bg-orange-50 transition duration-150 student-row"
                    data-classe="{{ $auditeur->classe->nom ?? 'Sans classe' }}">
                    <!-- Photo -->
                    <td class="py-3 px-4">
                        @if($auditeur->photo)
                            <img src="{{ asset('storage/' . $auditeur->photo) }}"
                                 alt="{{ $auditeur->nom }} {{ $auditeur->prenom }}"
                                 class="w-10 h-10 rounded-full object-cover mx-auto">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto">
                                <span class="text-gray-500 font-medium text-sm">
                                    {{ substr($auditeur->nom, 0, 1) }}{{ substr($auditeur->prenom, 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </td>

                    <!-- ID -->
                    <td class="py-3 px-4 font-medium text-gray-900">
                        {{ $auditeur->auditeur_id }}
                    </td>

                    <!-- Nom et Prénom -->
                    <td class="py-3 px-4 font-medium text-gray-900">
                        {{ $auditeur->nom }}
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->prenom ?? 'N/A' }}
                    </td>
                    <!-- Genre -->
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->genre ?? 'N/A' }}
                    </td>

                    <!-- Téléphone -->
                    <td class="py-3 px-4 text-gray-700 font-mono">
                        {{ $auditeur->telephone ?? 'N/A' }}
                    </td>

                    <!-- Date de naissance -->
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->date_naissance ? $auditeur->date_naissance->format('d/m/Y') : 'N/A' }}
                    </td>

                    <!-- Lieu de naissance -->
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->lieu_naissance ?? 'N/A' }}
                    </td>

                    <!-- Ville de résidence -->
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->ville_residence ?? 'N/A' }}
                    </td>

                    <!-- Poste occupé -->
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->poste_occupe ?? 'N/A' }}
                    </td>

                    <!-- Employeur -->
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->employeur ?? 'N/A' }}
                    </td>

                    <!-- Identifiant -->
                    <td class="py-3 px-4 text-gray-700 font-mono">
                        {{ $auditeur->identifiant ?? 'N/A' }}
                    </td>

                    <!-- Filière -->
                    <td class="py-3 px-4 text-gray-700">
                        {{ $auditeur->filiere ?? 'N/A' }}
                    </td>

                    <!-- Email 1 -->
                    <td class="py-3 px-4 text-gray-800">
                        {{ $auditeur->mail_ajout }}
                    </td>

                    <!-- Email 2 -->
                    <td class="py-3 px-4 text-gray-800">
                        {{ $auditeur->mail_exact ?? 'N/A' }}
                    </td>

                    <!-- Classe -->
                    <td class="py-3 px-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    bg-orange-100 text-orange-800 border border-orange-200">
                            {{ $auditeur->classe->nom ?? 'N/A' }}
                        </span>
                    </td>

                    <!-- Statut -->
                    <td class="py-3 px-4 text-center">
                        @if($auditeur->is_active == 1)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        bg-green-100 text-green-800 border border-green-300">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Actif
                            </span>
                        @elseif($auditeur->is_active === 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        bg-yellow-100 text-yellow-800 border border-yellow-300">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                En attente
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        bg-gray-100 text-gray-800 border border-gray-300">
                                <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                Non défini
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('admin.etudiants.show', $auditeur->id) }}"
                           class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white
                                  px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 shadow-md
                                  hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <td colspan="17" class="py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-lg font-medium text-gray-400">Aucun auditeur trouvé</p>
                            <p class="text-sm text-gray-400 mt-1">Essayez de modifier vos critères de recherche</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

    </div>

    <!-- Footer -->
    <footer class="text-center text-gray-500 mt-12 pb-6">
        <p class="text-sm">© 2026 Système de Diplômes – <span class="text-orange-500 font-semibold">Administration</span></p>
    </footer>

</main>

<!-- Scripts -->
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

// Recherche en temps réel
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#auditeursTable tr.student-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.classList.remove('hidden');
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }
    });

    // Mettre à jour le compteur
    updateCounter(visibleCount);
});

// Fonction pour mettre à jour le compteur (à adapter selon votre structure)
function updateCounter(count) {
    // Si vous voulez mettre à jour le compteur dynamiquement
    const counterElement = document.querySelector('.text-orange-500.text-lg');
    if (counterElement) {
        counterElement.textContent = count;
    }
}
</script>

@endsection
