<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', // exemple
        'description',
        // autres champs
    ];

    // Relation avec Auditeur
    public function auditeurs()
    {
        return $this->hasMany(Auditeur::class, 'classe_id');
        // 'classe_id' = nom de la colonne dans la table auditeurs qui référence la classe
    }
}
