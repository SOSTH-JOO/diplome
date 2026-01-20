@extends('emails.layouts.app')

@section('title', 'Profil Auditeur')

@section('content')
<main class="bg-gray-100 font-sans">
    <div class="max-w-2xl mx-auto my-8 bg-white rounded-lg overflow-hidden shadow-xl">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-8 px-6 text-center">
            <h1 class="text-3xl font-bold">🎉 Félicitations !</h1>
        </div>

        <!-- Content -->
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                Bonjour {{ $auditeur->prenom }} {{ $auditeur->nom }},
            </h2>
            
            <p class="text-gray-700 mb-4">
                Nous avons le plaisir de vous informer que votre compte auditeur a été validé avec succès !
            </p>
            
            <div class="mb-6">
                <p class="font-semibold text-gray-800 mb-2">Vos informations :</p>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex">
                        <span class="font-semibold min-w-[100px]">Matricule :</span>
                        <span>{{ $auditeur->auditeur_id }}</span>
                    </li>
                    <li class="flex">
                        <span class="font-semibold min-w-[100px]">Email :</span>
                        <span>{{ $auditeur->mail_exact }}</span>
                    </li>
                    @if($auditeur->classe)
                    <li class="flex">
                        <span class="font-semibold min-w-[100px]">Classe :</span>
                        <span>{{ $auditeur->classe->nom }}</span>
                    </li>
                    @endif
                </ul>
            </div>

            @if($messagePersonnalise)
            <div class="bg-blue-50 border-l-4 border-purple-500 p-4 my-6">
                <p class="font-semibold text-gray-800 mb-2">Message de l'administrateur :</p>
                <p class="text-gray-700">{{ $messagePersonnalise }}</p>
            </div>
            @endif
            
            <p class="text-gray-700 mb-6">
                Vous pouvez maintenant accéder à votre espace personnel et profiter de tous nos services.
            </p>
            
            <div class="text-center my-8">
                <a href="{{ config('app.url') }}" 
                   class="inline-block bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold py-3 px-8 rounded-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                    Accéder à mon compte
                </a>
            </div>
            
            <p class="text-gray-700 mb-4">
                Si vous avez des questions, n'hésitez pas à nous contacter.
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