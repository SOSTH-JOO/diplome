<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Auditeur extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'auditeur_id',
        'nom',
        'prenom',
        'genre',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'pays_residence',
        'ville_residence',
        'poste_occupe',
        'employeur',
        'identifiant',
        'filiere',
        'photo',
        'password',
        'classe_id',
        'mail_ajout',
        'mail_exact',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    // Login par auditeur_id
    public function getAuthIdentifierName()
    {
        return 'auditeur_id';
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }
}
