<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditeurs', function (Blueprint $table) {
            $table->id();

            // Identifiants (peuvent être null pour importation partielle)
            $table->string('auditeur_id')->unique()->nullable();
            $table->string('classe_id')->nullable();

            // Informations personnelles (nom et prénom restent requis)
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->enum('genre', ['Masculin', 'Féminin'])->nullable();
            $table->string('telephone')->nullable();

            // Origine et naissance
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('password')->nullable();
            $table->string('mail_ajout')->nullable();
            $table->string('mail_exact')->nullable();

            // Résidence actuelle
            $table->string('pays_residence')->nullable();
            $table->string('ville_residence')->nullable();

            // Situation professionnelle
            $table->string('poste_occupe')->nullable();
            $table->string('employeur')->nullable();
            $table->string('identifiant')->nullable();
            $table->string('filiere')->nullable();
            $table->boolean('is_active')->default(true);

            // Photo de profil
            $table->string('photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditeurs');
    }
};
