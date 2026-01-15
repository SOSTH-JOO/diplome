<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\classe;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Auditeur;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use ZipArchive;
use File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class ProfilController extends Controller
{
    /* ================= AUDITEUR ================= */

  public function login()
    {
        return view('Auditeur.pages.login');
    }

    // Authentification auditeur
  public function authenticateAuditeur(Request $request)
{
    $request->validate([
        'auditeur_id' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::guard('auditeur')->attempt([
        'auditeur_id' => $request->auditeur_id,
        'password' => $request->password,
    ])) {
        $request->session()->regenerate();
        return redirect()->route('auditeur.index');
    }

    return back()->withErrors([
        'auditeur_id' => 'Matricule ou mot de passe incorrect.',
    ]);
}



    // Dashboard auditeur
     public function index()
    {
        $auditeur = Auth::guard('auditeur')->user(); // auditeur connecté
        return view('Auditeur.pages.index', compact('auditeur'));
    }
// Mettre à jour le profil
// Mettre à jour le profil
public function update(Request $request)
{
    $auditeur = Auth::guard('auditeur')->user();

    $data = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'genre' => 'required|string|in:Masculin,Féminin',
        'telephone' => 'required|string|max:25',
        'date_naissance' => 'required|date',
        'lieu_naissance' => 'required|string|max:255',
        'pays_residence' => 'required|string|max:255',
        'ville_residence' => 'required|string|max:255',
        'poste_occupe' => 'required|string|max:255',
        'employeur' => 'required|string|max:255',
        'identifiant' => 'required|string|max:255',
        'filiere' => 'required|string|max:255',
        'mail_exact' => 'nullable|email|max:255',
        'photo' => 'nullable|image|max:2048', // max 2 Mo
    ]);

    $data['is_open'] = 1;

    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo si elle existe
        if ($auditeur->photo && Storage::disk('public')->exists($auditeur->photo)) {
            Storage::disk('public')->delete($auditeur->photo);
        }

        // Récupérer le fichier
        $file = $request->file('photo');

        // Créer le dossier correspondant à la classe si nécessaire
        $classeName = $auditeur->classe?->nom ?? 'sans_classe';
        $directory = 'auditeurs/' . $classeName;

        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Générer un nom unique
        $filename = $auditeur->auditeur_id . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Stocker le fichier dans le dossier spécifique
        $path = $file->storeAs($directory, $filename, 'public');

        // Sauvegarder le chemin dans les données
        $data['photo'] = $path;
    }

    $auditeur->update($data);

    return redirect()->route('auditeur.index')->with('success', 'Profil mis à jour avec succès.');
}



    // Logout
    public function logoutAuditeur(Request $request)
    {
        Auth::guard('auditeur')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auditeur.login');
    }












     public function loginAdmin()
    {
        return view('Admin.pages.login');
    }

    // Traitement de la connexion
    public function authenticate(Request $request)
    {
        // Validation du formulaire
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Vérifier si l'utilisateur est actif et admin
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !$user->is_active ) {
            return back()->withErrors([
                'email' => 'Identifiant ou mot de passe incorrect, ou compte inactif.',
            ])->withInput();
        }

        // Tentative d'authentification
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.diplome'); // Redirection après connexion réussie
        }

        return back()->withErrors([
            'password' => 'Le mot de passe est incorrect.',
        ])->withInput();
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }


    /* ================= ADMIN ================= */

    // Page principale diplômes
 public function diplome(Request $request, $classe = null)
{
    // Récupérer toutes les classes pour le filtre
    $classes = Classe::orderBy('nom')->get();

    // Récupérer les auditeurs avec leur classe
    $query = Auditeur::with('classe');

    // Filtrer par classe si spécifiée
    if ($classe && $classe !== 'tous') {
        $query->whereHas('classe', function($q) use ($classe) {
            $q->where('nom', $classe);
        });
    }

    $auditeurs = $query->orderBy('nom')->get();

    // Compter le nombre total d'auditeurs affichés
    $nombreAuditeurs = $auditeurs->count();

    return view('Admin.pages.diplome', compact('auditeurs', 'classes', 'classe', 'nombreAuditeurs'));
}

// Nouvelle méthode pour toggle le statut is_active
public function toggleStatusauditeur($id)
{
    $auditeur = Auditeur::findOrFail($id);

    // Inverser le statut
    $auditeur->is_active = $auditeur->is_active == 1 ? 0 : 1;
    $auditeur->save();

    $message = $auditeur->is_active == 1 ? 'Auditeur validé avec succès !' : 'Auditeur mis en attente !';

    return redirect()->back()->with('success', $message);
}

    // Page export
     public function export(Request $request)
    {
        $classes = Classe::orderBy('nom')->get();
        $auditeurs = collect();
        $selectedClasse = null;

        if ($request->has('classe_id') && $request->classe_id != '') {
            $selectedClasse = Classe::find($request->classe_id);

            $auditeurs = Auditeur::where('classe_id', $request->classe_id)
                ->where('is_active', 1)
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get();
        }

        return view('Admin.pages.export', compact('classes', 'auditeurs', 'selectedClasse'));
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id'
        ]);

        $classe = Classe::findOrFail($request->classe_id);
        $auditeurs = Auditeur::where('classe_id', $request->classe_id)
            ->where('is_active', 1)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        if ($auditeurs->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun auditeur validé dans cette classe.');
        }

        // Créer le dossier temporaire
        $tempDir = storage_path('app/temp_export_' . time());
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        // Créer le dossier photos
        $photosDir = $tempDir . '/Photos_' . str_replace(' ', '_', $classe->nom);
        if (!File::exists($photosDir)) {
            File::makeDirectory($photosDir, 0755, true);
        }

        // Copier les photos
        foreach ($auditeurs as $auditeur) {
            if ($auditeur->photo) {
                $sourcePath = storage_path('app/public/' . $auditeur->photo);
                if (File::exists($sourcePath)) {
                    $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                    $newFileName = $auditeur->auditeur_id . '.' . $extension;
                    $destPath = $photosDir . '/' . $newFileName;
                    File::copy($sourcePath, $destPath);
                }
            }
        }

        // Créer le fichier Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Nom de la feuille
        $sheet->setTitle($classe->nom);

        // En-têtes (ligne 1)
        $headers = [
            'A1' => 'ID Auditeur',
            'B1' => 'Nom et Prénom',
            'C1' => 'Genre',
            'D1' => 'Téléphone',
            'E1' => 'Date de naissance',
            'F1' => 'Lieu de naissance',
            'G1' => 'Pays de résidence',
            'H1' => 'Ville de résidence',
            'I1' => 'Poste occupé',
            'J1' => 'Employeur',
            'K1' => 'Filière',
            'L1' => 'Email',
            'M1' => 'Photo'
        ];

        // Appliquer les en-têtes
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style des en-têtes
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $sheet->getStyle('A1:M1')->applyFromArray($headerStyle);

        // Ajuster la hauteur de la ligne d'en-tête
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Remplir les données
        $row = 2;
        $photosFolder = 'Photos_' . str_replace(' ', '_', $classe->nom);

        foreach ($auditeurs as $auditeur) {
            // ID Auditeur
            $sheet->setCellValue('A' . $row, $auditeur->auditeur_id);

            // Nom et Prénom
            $sheet->setCellValue('B' . $row, strtoupper($auditeur->nom) . ' ' . ucwords($auditeur->prenom));

            // Genre
            $genre = strtoupper($auditeur->genre) == 'MASCULIN' || strtoupper($auditeur->genre) == 'M' ? 'M' : 'F';
            $sheet->setCellValue('C' . $row, $genre);

            // Téléphone
            $sheet->setCellValue('D' . $row, $auditeur->telephone);

            // Date de naissance
            $sheet->setCellValue('E' . $row, $auditeur->date_naissance);

            // Lieu de naissance
            $sheet->setCellValue('F' . $row, $auditeur->lieu_naissance);

            // Pays de résidence
            $sheet->setCellValue('G' . $row, $auditeur->pays_residence);

            // Ville de résidence
            $sheet->setCellValue('H' . $row, $auditeur->ville_residence);

            // Poste occupé
            $sheet->setCellValue('I' . $row, $auditeur->poste_occupe);

            // Employeur
            $sheet->setCellValue('J' . $row, $auditeur->employeur);

            // Filière
            $sheet->setCellValue('K' . $row, $auditeur->filiere);

            // Email
            $sheet->setCellValue('L' . $row, $auditeur->mail_exact);

            // Photo - Créer un lien hypertexte
            if ($auditeur->photo) {
                $extension = pathinfo($auditeur->photo, PATHINFO_EXTENSION);
                $photoFileName = $auditeur->auditeur_id . '.' . $extension;
                $photoPath = $photosFolder . '/' . $photoFileName;

                $sheet->setCellValue('M' . $row, 'Voir photo');
                $sheet->getCell('M' . $row)->getHyperlink()->setUrl($photoPath);

                // Style du lien
                $sheet->getStyle('M' . $row)->getFont()->setUnderline(true);
                $sheet->getStyle('M' . $row)->getFont()->getColor()->setRGB('0000FF');
            } else {
                $sheet->setCellValue('M' . $row, 'Pas de photo');
            }

            // Style de la ligne
            $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER
                ]
            ]);

            // Hauteur de ligne
            $sheet->getRowDimension($row)->setRowHeight(20);

            $row++;
        }

        // Ajuster la largeur des colonnes
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(18);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(15);

        // Sauvegarder le fichier Excel
        $excelFileName = 'Liste_' . str_replace(' ', '_', $classe->nom) . '_' . date('Y-m-d') . '.xlsx';
        $excelPath = $tempDir . '/' . $excelFileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($excelPath);

        // Créer le fichier ZIP
        $zipFileName = 'Export_' . str_replace(' ', '_', $classe->nom) . '_' . date('Y-m-d') . '.zip';
        $zipPath = $tempDir . '/' . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Ajouter le fichier Excel
            $zip->addFile($excelPath, $excelFileName);

            // Ajouter le dossier photos
            $files = File::allFiles($photosDir);
            foreach ($files as $file) {
                $relativePath = $photosFolder . '/' . $file->getFilename();
                $zip->addFile($file->getRealPath(), $relativePath);
            }

            $zip->close();
        }

        // Télécharger le ZIP
        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    // Page import
   public function import()
    {
        $classes = Classe::orderBy('nom')->get();
        return view('Admin.pages.import', compact('classes'));
    }

    /**
     * Afficher l'aperçu des données Excel avec sélection de classe
     */
public function preview(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
        'classe_id' => 'required|exists:classes,id'
    ]);

    // Récupérer la classe sélectionnée
    $classe = Classe::find($request->classe_id);

    $spreadsheet = IOFactory::load($request->file('file')->getPathname());
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    $data = [];

    // Déterminer les indices de colonnes dynamiquement
    $headers = $rows[0] ?? [];

    foreach (array_slice($rows, 1) as $index => $row) {
        $id = $row[0] ?? '';
        $email = $row[6] ?? '';

        // Générer le mot de passe qui serait enregistré
        $password_preview = !empty($id) ? strtolower($id) : Str::random(8);

        $data[] = [
            'row_index' => $index + 2, // +2 car ligne 1 = headers et index commence à 0
            'id' => $id,
            'email' => $email,
            'password_preview' => $password_preview, // mot de passe en clair pour aperçu
        ];
    }

    // Stocker en session avec la classe_id
    session([
        'excelData' => $data,
        'classe_id' => $request->classe_id,
        'classe_nom' => $classe->nom,
        'total_rows' => count($data)
    ]);

    return redirect()->route('admin.import.form')
        ->with('info', 'Aperçu des données chargées. Veuillez vérifier avant enregistrement.');
}


    /**
     * Enregistrer les données dans la base
     */
public function store(Request $request)
{
    // Récupérer les données de session
    $excelData = session('excelData', []);
    $classe_id = session('classe_id');

    if (empty($excelData) || !$classe_id) {
        return redirect()->route('admin.import.form')
            ->with('error', 'Aucune donnée à importer. Veuillez recharger le fichier.');
    }

    $importedCount = 0;
    $errors = [];

    foreach ($excelData as $row) {
        try {
            $rowNumber = $row['row_index'] ?? 'N/A';

            // Vérifier que l'email ou l'ID existe
            if (empty($row['email']) && empty($row['id'])) {
                $errors[] = "Ligne $rowNumber: Email et ID manquants - ligne ignorée";
                continue;
            }

            // Vérifier si l'auditeur existe déjà par email ou ID
            $existing = Auditeur::where(function ($query) use ($row) {
                if (!empty($row['email'])) {
                    $query->orWhere('mail_ajout', $row['email']);
                }
                if (!empty($row['id'])) {
                    $query->orWhere('auditeur_id', $row['id']);
                }
            })->first();

            if ($existing) {
                $errors[] = "Ligne $rowNumber: L'étudiant existe déjà (Email: {$row['email']}, ID: {$row['id']})";
                continue;
            }

            // Générer un mot de passe à partir de l'ID en minuscules
            $password = !empty($row['id']) ? strtolower($row['id']) : Str::random(8); // fallback aléatoire

            // Préparer les données avec valeurs par défaut
            $auditeurData = [
                'auditeur_id' => $row['id'] ?? null,
                'mail_ajout'  => $row['email'] ?? '',
                'classe_id'   => $classe_id,
                'is_active'   => false,
                'password'    => Hash::make($password), // hash du mot de passe
            ];

            // Créer l'auditeur
            Auditeur::create($auditeurData);
            $importedCount++;

        } catch (\Exception $e) {
            $errors[] = "Ligne $rowNumber: Erreur - " . $e->getMessage();
        }
    }

    // Nettoyer la session
    session()->forget(['excelData', 'classe_id', 'classe_nom', 'total_rows']);

    $message = "Importation terminée : $importedCount étudiants importés avec succès.";

    if (!empty($errors)) {
        session()->flash('import_errors', $errors);
        $message .= " " . count($errors) . " erreur(s) rencontrée(s).";
    }

    return redirect()->route('admin.import.form')
        ->with('success', $message);
}


    /**
     * Annuler l'importation en cours
     */
    public function cancelImport()
    {
        session()->forget(['excelData', 'classe_id', 'classe_nom', 'total_rows']);

        return redirect()->route('admin.import.form')
            ->with('info', 'Importation annulée.');
    }

    // Voir un auditeur (page fixe)
public function etudiants_show(Auditeur $auditeur)
{
    return view('Admin.pages.etudiants_show', compact('auditeur'));
}

public function activate(Auditeur $auditeur)
{
    $auditeur->update(['is_active' => true]);
    return back()->with('success', 'Auditeur activé avec succès.');
}

public function reject(Auditeur $auditeur)
{
    // Mettre is_active à false (0)
    $auditeur->update(['is_active' => false]);
    return back()->with('success', 'Auditeur désactivé avec succès.');
}

// Optionnel: Méthode pour supprimer définitivement
public function destroy(Auditeur $auditeur)
{
    // Supprimer la photo si elle existe
    if ($auditeur->photo && Storage::disk('public')->exists($auditeur->photo)) {
        Storage::disk('public')->delete($auditeur->photo);
    }

    $auditeur->delete();
    return redirect()->route('admin.diplome')
        ->with('success', 'Auditeur supprimé définitivement.');
}


    /**
     * Afficher la liste des utilisateurs
     */
/**
 * Liste des utilisateurs
 */
  public function indexuser()
{
    $utilisateurs = User::orderBy('created_at', 'desc')->get();

    return view('Admin.pages.utilisateur', compact('utilisateurs'));
}


    /**
     * Créer un nouvel utilisateur
     */
    public function storeuser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:Superuser,user',
        ], [
            'name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email existe déjà',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'role.required' => 'Le rôle est obligatoire',
            'role.in' => 'Le rôle doit être soit Superuser soit user',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true; // Par défaut, l'utilisateur est actif

        User::create($validated);

        return redirect()->route('admin.utilisateurs')
            ->with('success', 'Utilisateur créé avec succès !');
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function updateuser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:Superuser,user',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email existe déjà',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'role.required' => 'Le rôle est obligatoire',
            'role.in' => 'Le rôle doit être soit Superuser soit user',
        ]);

        // Si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.utilisateurs')
            ->with('success', 'Utilisateur modifié avec succès !');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroyuser($id)
    {
        $user = User::findOrFail($id);

        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.utilisateurs')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte !');
        }

        $user->delete();

        return redirect()->route('admin.utilisateurs')
            ->with('success', 'Utilisateur supprimé avec succès !');
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Empêcher la désactivation de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.utilisateurs')
                ->with('error', 'Vous ne pouvez pas désactiver votre propre compte !');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'activé' : 'désactivé';

        return redirect()->route('admin.utilisateurs')
            ->with('success', "Utilisateur $status avec succès !");
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function show($id)
{
    $user = User::findOrFail($id);
    return response()->json($user);
}


    public function Monprofil()
    {
        return view('Admin.pages.Monprofil');
    }

     public function classes()
    {
        $classes = Classe::withCount('auditeurs')->orderBy('created_at', 'desc')->get();

        return view('Admin.pages.classes', compact('classes'));
    }

    public function storeclasses(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:classes,nom',
            'filiere' => 'required|string|max:255',
        ], [
            'nom.required' => 'Le nom de la classe est obligatoire',
            'nom.unique' => 'Cette classe existe déjà',
            'filiere.required' => 'La filière est obligatoire',
        ]);

        Classe::create($validated);

        return redirect()->route('admin.classes')
            ->with('success', 'Classe ajoutée avec succès !');
    }

    public function updateclasses(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:classes,nom,' . $classe->id,
            'filiere' => 'required|string|max:255',
        ], [
            'nom.required' => 'Le nom de la classe est obligatoire',
            'nom.unique' => 'Cette classe existe déjà',
            'filiere.required' => 'La filière est obligatoire',
        ]);

        $classe->update($validated);

        return redirect()->route('admin.classes')
            ->with('success', 'Classe modifiée avec succès !');
    }

    public function destroyclasses($id)
    {
        $classe = Classe::findOrFail($id);

        // Vérifier si la classe a des auditeurs assignés
        if ($classe->auditeurs()->count() > 0) {
            return redirect()->route('admin.classes')
                ->with('error', 'Impossible de supprimer cette classe car elle contient des auditeurs.');
        }

        $classe->delete();

        return redirect()->route('admin.classes')
            ->with('success', 'Classe supprimée avec succès !');
    }
}
