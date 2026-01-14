<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Modifier user_id pour accepter les valeurs alphanumériques
            $table->string('user_id', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Revenir à int si besoin
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }
};
