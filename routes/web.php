<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\etudiantController;


/*
|--------------------------------------------------------------------------
| AUDITEUR
|--------------------------------------------------------------------------
*/
Route::get('/', [ProfilController::class, 'login'])->name('auditeur.login');
Route::post('/', [ProfilController::class, 'authenticateAuditeur'])->name('auditeur.login.post');

Route::middleware('auth:auditeur')->group(function () {
    Route::get('/auditeur', [ProfilController::class, 'index'])->name('auditeur.index');
    Route::put('/auditeur/update', [ProfilController::class, 'update'])
        ->name('auditeur.update');
    // Logout
    Route::post('/auditeur/logout', [ProfilController::class, 'logout'])->name('auditeur.logout');
});/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
// Formulaire de connexion

// Déconnexion
Route::prefix('admin')->name('admin.')->group(function () {

Route::get('/', [ProfilController::class, 'loginAdmin'])->name('login');

// Traitement du formulaire
Route::post('/login', [ProfilController::class, 'authenticate'])->name('login.post');



Route::middleware('auth')->group(function () {

    // Déconnexion
    Route::post('/logout', [ProfilController::class, 'logout'])->name('logout');

    // Export / Import

Route::get('/export', [ProfilController::class, 'export'])->name('export');
Route::post('/export-excel', [ProfilController::class, 'exportExcel'])->name('export.excel');
    Route::get('/import', [ProfilController::class, 'import'])->name('import.form');
    Route::post('/import/preview', [ProfilController::class, 'preview'])->name('import.preview');
    Route::post('/import/store', [ProfilController::class, 'store'])->name('import.store');
    Route::post('/import-etudiants/cancel', [ProfilController::class, 'cancelImport'])->name('import.cancel');

    // Diplômes (filtrage optionnel par promotion)
    Route::get('/diplome/{classe?}', [ProfilController::class, 'diplome'])->name('diplome');
Route::patch('auditeur/{id}/toggle-status', [ProfilController::class, 'toggleStatusauditeur'])
    ->name('auditeur.toggle-status');
    // Classes (AJAX)
    Route::get('/classes', [EtudiantController::class, 'index'])->name('classes.list');

    // Gestion des étudiants

    // Routes pour les auditeurs/étudiants
    Route::get('/etudiants/{auditeur}', [ProfilController::class, 'etudiants_show'])->name('etudiants.show');
    Route::put('/etudiants/{auditeur}/activate', [ProfilController::class, 'activate'])->name('etudiants.activate');
    Route::put('/etudiants/{auditeur}/reject', [ProfilController::class, 'reject'])->name('etudiants.reject');
    Route::delete('/etudiants/{auditeur}', [ProfilController::class, 'destroy'])->name('etudiants.destroy');
    // Gestion des utilisateurs
    Route::get('/utilisateurs', [ProfilController::class, 'indexuser'])->name('utilisateurs');
    Route::post('/utilisateurs', [ProfilController::class, 'storeuser'])->name('utilisateurs.store');
    Route::put('/utilisateurs/{id}', [ProfilController::class, 'updateuser'])->name('utilisateurs.update');
    Route::delete('/utilisateurs/{id}', [ProfilController::class, 'destroyuser'])->name('utilisateurs.destroy');
    Route::patch('/utilisateurs/{id}/toggle-status', [ProfilController::class, 'toggleStatus'])->name('utilisateurs.toggleStatus');
    Route::get('/utilisateurs/{id}', [ProfilController::class, 'show'])->name('utilisateurs.show');

    // Profil
    Route::get('/Monprofil', [ProfilController::class, 'Monprofil'])->name('Monprofil');

    // Gestion des classes
    Route::get('/classes', [ProfilController::class, 'classes'])->name('classes');
    Route::post('/classes', [ProfilController::class, 'storeclasses'])->name('classes.store');
    Route::put('/classes/{classe}', [ProfilController::class, 'updateclasses'])->name('classes.update');
    Route::delete('/classes/{classe}', [ProfilController::class, 'destroyclasses'])->name('classes.destroy');
});


});
