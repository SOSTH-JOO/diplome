<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auditeurs', function (Blueprint $table) {
            $table->string('piece_identite_recto')->nullable()->after('photo');
            $table->string('piece_identite_verso')->nullable()->after('piece_identite_recto');
        });
    }

    public function down(): void
    {
        Schema::table('auditeurs', function (Blueprint $table) {
            $table->dropColumn(['piece_identite_recto', 'piece_identite_verso']);
        });
    }
};