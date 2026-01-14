<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auditeur;
use Illuminate\Http\Request;

class etudiantController extends Controller
{
    public function show($id)
    {
        $auditeur = Auditeur::with('classe')->findOrFail($id);

        return view('Admin.pages.etudiant-show', compact('auditeur'));
    }
}
