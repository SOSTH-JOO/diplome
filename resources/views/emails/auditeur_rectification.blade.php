@extends('emails.layouts.app')

@section('title', 'Profil Auditeur')

@section('content')
<main class="bg-gray-100 font-sans">
    <div class="max-w-2xl mx-auto my-8 bg-white rounded-lg overflow-hidden shadow-xl">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-400 to-red-400 text-white py-8 px-6 text-center">
            <h1 class="text-3xl font-bold">⚠️ Action requise</h1>
        </div>

        <!-- Content -->
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                Bonjour {{ $auditeur->prenom }} {{ $auditeur->nom }},
            </h2>
            
            <!-- Alert Box -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 my-6">
                <p class="font-semibold text-gray-800 mb-2 flex items-center">
                    <span class="mr-2">⚠️</span> Informations incomplètes
                </p>
                <p class="text-gray-700">
                    Nous avons examiné votre dossier et constaté que certaines informations nécessitent d'être complétées ou rectifiées.
                </p>
            </div>
            
            <p class="text-gray-700 mb-6">
                <span class="font-semibold">Votre matricule :</span> 
                <span class="text-gray-900">{{ $auditeur->auditeur_id }}</span>
            </p>

            @if($messagePersonnalise)
            <div class="bg-blue-50 border-l-4 border-purple-500 p-4 my-6">
                <p class="font-semibold text-gray-800 mb-2">Message de l'administrateur :</p>
                <p class="text-gray-700">{{ $messagePersonnalise }}</p>
            </div>
            @endif
            
            <div class="mb-6">
                <p class="font-semibold text-gray-800 mb-3">Actions à réaliser :</p>
                <ol class="list-decimal list-inside space-y-2 text-gray-700 ml-2">
                    <li>Connectez-vous à votre compte</li>
                    <li>Complétez les informations manquantes</li>
                    <li>Vérifiez l'exactitude de vos données</li>
                    <li>Soumettez votre profil pour validation</li>
                </ol>
            </div>
            
            <div class="text-center my-8">
                <a href="{{ config('app.url') }}" 
                   class="inline-block bg-gradient-to-r from-pink-400 to-red-400 text-white font-semibold py-3 px-8 rounded-lg hover:from-pink-500 hover:to-red-500 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Compléter mon profil
                </a>
            </div>
            
            <p class="text-gray-700 mb-4">
                Une fois vos informations mises à jour, notre équipe procédera à la validation de votre compte.
            </p>
            
            <p class="text-gray-700 mb-4">
                Pour toute question, n'hésitez pas à nous contacter.
            </p>
            
            <p class="text-gray-700">
                Cordialement,<br>
                <span class="font-semibold">L'équipe administrative</span>
            </p>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 py-6 px-8 text-center">
            <p class="text-sm text-gray-600">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
            </p>
        </div>
    </div>
</main>
@endsection