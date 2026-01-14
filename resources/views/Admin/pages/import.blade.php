@extends('Admin.layouts.app2')

@section('title', 'Importation des Étudiants')

@section('content')

<main class="bg-gray-100 min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-xl p-4 md:p-8 overflow-hidden">

        {{-- Titre principal --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-indigo-700">
                    📄 Importation des étudiants
                </h1>
                <p class="text-gray-600 mt-1 text-sm md:text-base">
                    Importez vos étudiants depuis un fichier Excel vers une classe spécifique
                </p>

                <a href="{{ route('admin.diplome') }}"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg font-semibold transition duration-200 shadow-md">
                    👤 Retour
                </a>
            </div>

            @if(session('excelData'))
                <form action="{{ route('admin.import.cancel') }}" method="POST" class="w-full md:w-auto">
                    @csrf
                    @method('POST')
                    <button type="submit"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition duration-200 w-full md:w-auto">
                        ❌ Annuler l'import
                    </button>
                </form>
            @endif
        </div>

        {{-- Messages de session --}}
        <div class="space-y-4 mb-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow animate-fade-in">
                    <div class="flex items-center">
                        <span class="text-xl mr-2">✅</span>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow animate-fade-in">
                    <div class="flex items-center">
                        <span class="text-xl mr-2">❌</span>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded shadow animate-fade-in">
                    <div class="flex items-center">
                        <span class="text-xl mr-2">ℹ️</span>
                        <p class="font-medium">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            @if(session('import_errors'))
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow animate-fade-in">
                    <div class="flex items-center mb-2">
                        <span class="text-xl mr-2">⚠️</span>
                        <p class="font-medium">Erreurs rencontrées lors de l'importation :</p>
                    </div>
                    <ul class="list-disc pl-5 text-sm space-y-1">
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
            <div class="bg-gray-50 p-4 md:p-6 rounded-lg border mb-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4">📥 Étape 1 : Sélectionner la classe et le fichier</h2>

                <form action="{{ route('admin.import.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                    @csrf

                    {{-- Sélection de la classe --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Classe de destination <span class="text-red-500">*</span>
                        </label>
                        <select name="classe_id" required
                                class="w-full border-2 border-gray-300 rounded-lg px-3 md:px-4 py-2 md:py-3 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                            <option value="">Sélectionnez une classe...</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">
                            Les étudiants seront ajoutés à cette classe
                        </p>
                    </div>

                    {{-- Fichier Excel --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Fichier Excel <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="file"
                                   name="file"
                                   id="fileInput"
                                   accept=".xlsx,.xls,.csv"
                                   required
                                   class="border-2 border-gray-300 rounded-lg px-3 md:px-4 py-2 md:py-3 w-full focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                        </div>
                        @error('file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">
                            Format attendu : Colonnes [ID, Nom, Prénom, Email, Filière]
                        </p>
                    </div>

                    {{-- Bouton d'importation --}}
                    <div class="pt-2 md:pt-4">
                        <button type="submit" id="submitBtn"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 md:px-8 py-2 md:py-3 rounded-lg shadow-lg font-semibold transition duration-200 flex items-center justify-center gap-2 w-full md:w-auto">
                            <span>⬇️</span> Charger l'aperçu
                        </button>
                    </div>
                </form>
            </div>

            {{-- Instructions --}}
            <div class="bg-blue-50 p-4 md:p-6 rounded-lg border">
                <h3 class="text-base md:text-lg font-semibold text-blue-800 mb-3">📋 Instructions d'importation</h3>
                <ul class="list-disc pl-4 md:pl-5 space-y-1 md:space-y-2 text-gray-700 text-sm md:text-base">
                    <li>Sélectionnez d'abord la classe de destination</li>
                    <li>Téléchargez un fichier Excel (.xlsx, .xls) avec les colonnes dans cet ordre : ID, Nom, Prénom, Email, Filière</li>
                    <li>La première ligne doit contenir les en-têtes</li>
                    <li>Un aperçu vous permettra de vérifier les données avant l'importation définitive</li>
                    <li>Les étudiants seront marqués comme "actifs" par défaut</li>
                </ul>
            </div>

        @else
            {{-- APERÇU DES DONNÉES --}}
            <div class="bg-white rounded-lg border shadow-sm overflow-hidden">
                {{-- En-tête de l'aperçu --}}
                <div class="bg-indigo-50 p-4 md:p-6 border-b">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-indigo-700">👁️ Aperçu des données</h2>
                            <p class="text-gray-600 mt-1 text-sm md:text-base">
                                {{ session('total_rows', 0) }} étudiants à importer dans la classe :
                                <span class="font-semibold text-indigo-600">{{ session('classe_nom') }}</span>
                            </p>
                        </div>
                        <div class="bg-indigo-100 text-indigo-800 px-3 md:px-4 py-1 md:py-2 rounded-lg font-semibold text-sm md:text-base">
                            📊 {{ count(session('excelData')) }} lignes
                        </div>
                    </div>
                </div>

                {{-- Tableau d'aperçu --}}
                <form action="{{ route('admin.import.store') }}" method="POST" id="importForm">
                    @csrf

                    {{-- Champ caché pour la classe --}}
                    <input type="hidden" name="classe_id" value="{{ session('classe_id') }}">

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse min-w-[800px]">
                            <thead class="bg-indigo-600 text-white">
                                <tr>
                                    <th class="p-2 md:p-4 text-left font-semibold text-xs md:text-sm">ID</th>
                                    <th class="p-2 md:p-4 text-left font-semibold text-xs md:text-sm">Email</th>
                                    <th class="p-2 md:p-4 text-left font-semibold text-xs md:text-sm">Password</th>
                                    <th class="p-2 md:p-4 text-left font-semibold text-xs md:text-sm">Statut</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach(session('excelData') as $index => $row)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="p-2 md:p-3 border">
                                        <input type="hidden" name="rows[{{ $index }}][id]" value="{{ $row['id'] ?? '' }}">
                                        <span class="{{ empty($row['id']) ? 'text-gray-400 italic' : '' }}">
                                            {{ $row['id'] ?? '(vide)' }}
                                        </span>
                                    </td>
                                    <td class="p-2 md:p-3 border">
                                        <input type="hidden" name="rows[{{ $index }}][email]" value="{{ $row['email'] ?? '' }}">
                                        <span class="font-medium {{ empty($row['email']) ? 'text-gray-400 italic' : 'text-gray-800' }}">
                                            {{ $row['email'] ?? '(vide)' }}
                                        </span>
                                    </td>
                                <td class="p-2 md:p-3 border">
    <input type="hidden" name="rows[{{ $index }}][id]" value="{{ $row['id'] ?? '' }}">

    <div class="flex flex-col">
        <span class="{{ empty($row['id']) ? 'text-gray-400 italic' : '' }}">
            {{ $row['id'] ?? '(vide)' }}
        </span>

        @if(!empty($row['id']) && !empty($row['password_preview']))
            <small class="text-gray-500 text-xs">
                Mot de passe: {{ $row['password_preview'] }}
            </small>
        @endif
    </div>
</td>



                                    <td class="p-2 md:p-3 border">
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
                                            <span class="inline-block px-2 md:px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold whitespace-nowrap">
                                                ⚠️ Existe
                                            </span>
                                        @elseif(empty($email) && empty($id))
                                            <span class="inline-block px-2 md:px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold whitespace-nowrap">
                                                ❌ Invalide
                                            </span>
                                        @else
                                            <span class="inline-block px-2 md:px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold whitespace-nowrap">
                                                ✅ Nouveau
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Boutons d'action --}}
                    <div class="p-4 md:p-6 border-t bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="text-gray-600">
                            <p class="font-medium text-sm md:text-base">Classe sélectionnée :
                                <span class="text-indigo-600">{{ session('classe_nom') }}</span>
                            </p>
                            <p class="text-xs md:text-sm">Tous les étudiants seront ajoutés à cette classe</p>
                        </div>

                        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                            <form action="{{ route('admin.import.cancel') }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-semibold transition duration-200 w-full">
                                    ❌ Annuler
                                </button>
                            </form>

                            <button type="submit"
                                    id="finalImportBtn"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 md:px-8 py-2 md:py-3 rounded-lg font-semibold shadow-lg transition duration-200 flex items-center justify-center gap-2 w-full">
                                <span>✅</span> Importer {{ count(session('excelData')) }} étudiants
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Résumé --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
                <div class="bg-blue-50 p-4 md:p-6 rounded-lg border">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl md:text-3xl">📊</div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600">Total à importer</p>
                            <p class="text-xl md:text-2xl font-bold text-blue-700">{{ count(session('excelData')) }}</p>
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

                <div class="bg-green-50 p-4 md:p-6 rounded-lg border">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl md:text-3xl">✅</div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600">Nouveaux étudiants</p>
                            <p class="text-xl md:text-2xl font-bold text-green-700">{{ $newCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 p-4 md:p-6 rounded-lg border">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl md:text-3xl">🏫</div>
                        <div>
                            <p class="text-xs md:text-sm text-gray-600">Classe</p>
                            <p class="text-lg md:text-xl font-bold text-yellow-700 truncate">{{ session('classe_nom') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistiques additionnelles --}}
            @if($existCount > 0 || $invalidCount > 0)
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    @if($existCount > 0)
                        <div class="bg-yellow-50 p-4 rounded-lg border">
                            <div class="flex items-center gap-3">
                                <div class="text-xl md:text-2xl">⚠️</div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Déjà existants</p>
                                    <p class="text-lg md:text-xl font-bold text-yellow-700">{{ $existCount }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($invalidCount > 0)
                        <div class="bg-red-50 p-4 rounded-lg border">
                            <div class="flex items-center gap-3">
                                <div class="text-xl md:text-2xl">❌</div>
                                <div>
                                    <p class="text-xs md:text-sm text-gray-600">Lignes invalides</p>
                                    <p class="text-lg md:text-xl font-bold text-red-700">{{ $invalidCount }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        @endif
    </div>
</main>

{{-- Scripts améliorés --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des messages avec animation
    const messages = document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-blue-100, .bg-yellow-100');

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
        closeBtn.className = 'ml-auto text-lg font-bold hover:text-gray-800';
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
                // Vérifier l'extension du fichier
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

            // Désactiver le bouton pendant le chargement
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>⏳</span> Traitement en cours...';
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            }
        });
    }

    // Validation du formulaire final d'importation
    const importForm = document.getElementById('importForm');
    if (importForm) {
        const finalImportBtn = document.getElementById('finalImportBtn');

        importForm.addEventListener('submit', function(e) {
            // Compter les lignes invalides
            const invalidRows = document.querySelectorAll('.bg-red-100').length;

            if (invalidRows > 0) {
                const confirmImport = confirm(`⚠️ ${invalidRows} ligne(s) sont invalides (ID et Email manquants).\n\nVoulez-vous quand même procéder à l'importation ?\n\nLes lignes invalides seront ignorées.`);

                if (!confirmImport) {
                    e.preventDefault();
                    return false;
                }
            }

            // Désactiver le bouton pendant l'importation
            if (finalImportBtn) {
                finalImportBtn.disabled = true;
                finalImportBtn.innerHTML = '<span>⏳</span> Importation en cours...';
                finalImportBtn.classList.add('opacity-75', 'cursor-not-allowed');

                // Ajouter un indicateur de chargement
                const loadingOverlay = document.createElement('div');
                loadingOverlay.id = 'loadingOverlay';
                loadingOverlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255, 255, 255, 0.8);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 9999;
                `;
                loadingOverlay.innerHTML = `
                    <div class="bg-white p-6 rounded-lg shadow-xl text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                        <p class="text-gray-700 font-semibold">Importation en cours...</p>
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
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };

        toast.className = `${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg fixed top-4 right-4 z-50 transform transition-all duration-300`;
        toast.style.transform = 'translateX(100%)';
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <span class="text-xl">${type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️'}</span>
                <span>${message}</span>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    &times;
                </button>
            </div>
        `;

        document.body.appendChild(toast);

        // Animation d'entrée
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 10);

        // Suppression automatique après 5 secondes
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 5000);
    }

    // Ajouter un style pour l'animation fade-in
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    `;
    document.head.appendChild(style);
});
</script>

@endsection
