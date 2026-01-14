<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vider la table d'abord (optionnel)
        DB::table('users')->truncate();

        // 1. Créer un superadmin
        DB::table('users')->insert([
            'name' => 'Super Administrateur',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('superadmin123'), // Mot de passe
            'role' => 'Superuser',
            'is_active' => true,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Créer un utilisateur standard
        DB::table('users')->insert([
            'name' => 'Utilisateur Standard',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => true,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
