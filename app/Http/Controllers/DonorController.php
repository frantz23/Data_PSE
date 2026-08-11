<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonorFormRequest;
use App\Models\Donor;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DonorController extends Controller
{
    public function index(): View
    {
        $donors = Donor::orderBy('created_at', 'desc')->paginate(5);
        return view('donors/index', ['donors' => $donors]);
    }

    public function show($id): View
    {
        $donor = Donor::findOrFail($id);

        return view('donors/show', ['donor' => $donor]);
    }
    public function create(): View
    {
        return view('donors/create');
    }

    public function edit($id): View
    {
        $donor = Donor::findOrFail($id);
        return view('donors/edit', ['donor' => $donor]);
    }

    public function store(DonorFormRequest $req): RedirectResponse
    {
        $data = $req->validated();



        $donor = Donor::create($data);
        return redirect()->route('admin.donor.show', ['id' => $donor->id]);
    }

    public function update(Donor $donor, DonorFormRequest $req)
    {
        $data = $req->validated();



        $donor->update($data);

        return redirect()->route('admin.donor.show', ['id' => $donor->id]);
    }

    public function updateSpeed(Donor $donor, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $donor->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Donor $donor)
    {

        $donor->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function indexDonor(): View
    {
        $donors = Donor::orderBy('created_at', 'desc')->paginate(5);
        return view('ownpage.donorViews.index', ['donors' => $donors]);
    }

    public function createDonor(): View
    {
        return view('ownpage.donorViews.create');
    }

    public function editDonor($id): View
    {
        $donor = Donor::findOrFail($id);
        return view('ownpage.donorViews.edit', ['donor' => $donor]);
    }

    public function showDonor($id): View
    {
        $donor = Donor::findOrFail($id);

        return view('ownpage.donorViews.show', ['donor' => $donor]);
    }



    public function storeDonor(DonorFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['isActive'] = $req->boolean('isActive');

        // On retire provisoirement le logo pour éviter de le passer à l'insertion initiale
        unset($data['logo']);

        // 1. Transaction BDD (Création du User et du Donor)
        $donor = DB::transaction(function () use ($data) {
            // S'assurer que le rôle "donor" existe en BDD (sinon le créer automatiquement)
            Role::findOrCreate('donor');
            // Création du compte utilisateur lié
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('Password123!'), // Mot de passe par défaut
            ]);

            // Assignation du rôle via Spatie
            $user->assignRole('donor');

            $data['user_id'] = $user->id;

            // Création du bailleur
            return Donor::create($data);
        });

        // 2. Traitement et déplacement de l'image APRÈS le succès de la transaction
        if ($req->hasFile('logo')) {
            $file = $req->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Déplacement du fichier dans public/images/donors
            $file->move(public_path('images/donors'), $filename);

            // Mise à jour du chemin de l'image sur le bailleur créé
            $donor->update([
                'logo' => 'images/donors/' . $filename
            ]);
        }

        return redirect()->route('showDonor', ['id' => $donor->id])
            ->with('success', 'Bailleur et son compte utilisateur créés avec succès !');
    }

    public function updateDonor(DonorFormRequest $req, $id): RedirectResponse
    {
        $donor = Donor::findOrFail($id);
        $data = $req->validated();
        $data['isActive'] = $req->boolean('isActive');

        DB::transaction(function () use ($req, $donor, &$data) {
            // Mettre à jour l'utilisateur lié si le bailleur possède un compte
            if ($donor->user) {
                $donor->user->update([
                    'name'  => $data['name'],
                    'email' => $data['email'] ?? $donor->user->email,
                ]);
            }

            // Gestion du logo
            if ($req->hasFile('logo')) {
                if ($donor->logo && file_exists(public_path($donor->logo))) {
                    unlink(public_path($donor->logo));
                }
                $file = $req->file('logo');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/donors'), $filename);
                $data['logo'] = 'images/donors/' . $filename;
            } else {
                unset($data['logo']);
            }

            $donor->update($data);
        });

        return redirect()->route('showDonor', ['id' => $donor->id])
            ->with('success', 'Bailleur mis à jour avec succès !');
    }

    public function deleteDonor($id): RedirectResponse
    {
        $donor = Donor::findOrFail($id);

        // Supprimer le fichier image s'il existe
        if ($donor->logo && file_exists(public_path($donor->logo))) {
            unlink(public_path($donor->logo));
        }

        $donor->delete();

        return redirect()->route('indexDonor')
            ->with('success', 'Bailleur supprimé avec succès !');
    }

    public function Bailleur()
    {
        $user = auth()->user();

        // Si l'utilisateur est un bailleur, on le redirige vers son portail dédié
        if ($user->hasRole('donor')) {
            return redirect()->route('donor.DonorDashboard');
        }

        // Sinon, charger la vue admin / staff normale
        return view('admin.dashboard');
    }


    public function donorDashboard(): View
    {
        // 1. Récupérer le bailleur connecté via l'utilisateur
        $user = auth()->user();
        $donor = $user->donor;

        if (!$donor) {
            abort(403, "Aucun profil bailleur n'est associé à ce compte utilisateur.");
        }

        // 2. Charger les programmes co-financés par ce bailleur
        // (Si vous utilisez le financement direct, vous pouvez remplacer Dprograms par programs)
        $programs = $donor->programs()
            ->withCount('projects') // Ou 'kpis' selon le nom de votre relation sur Program
            ->latest()
            ->get();

        $globalProgress = $programs
            ->pluck('projects')->flatten()      // Récupère tous les projets à plat
            ->pluck('activities')->flatten()    // Récupère toutes les activités à plat
            ->avg('completion_rate');           // Calcule la moyenne de la colonne

        // Pour UN SEUL programme ($program) :
        // $programProgress = $programs->projects
        //     ->pluck('activities')
        //     ->flatten()
        //     ->avg('completion_rate');

        // Arrondir le résultat (et gérer le cas où il n'y a pas encore d'activités)
        // $programProgress = $programProgress ? round($programProgress, 1) : 0;
        // 3. Calcul des statistiques sur les programmes
        $stats = [
            'total_projects'     => $programs->count(),
            'active_projects'    => $programs->where('status', 'active')->count(),
            'completed_projects' => $programs->where('status', 'completed')->count(),
            'global_progress'    => $globalProgress ? round($globalProgress, 1) : 0,
        ];

        return view('ownpage.donorViews.donorDashboard', compact('donor', 'programs', 'stats'));
    }

    public function showProgram($id): View
    {
        // Charger le programme avec ses projets, les ONG exécutantes et les activités
        $program = Program::with([
            'donorprograms',                 //
            'Ddonors',               // Co-financeurs
            'projects.organization', // Projets et leurs ONG exécutantes
        ])->findOrFail($id);

        return view('ownpage.donorViews.programShow', compact('program'));
    }
}
