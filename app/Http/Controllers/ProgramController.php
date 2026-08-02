<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramFormRequest;
use App\Models\Program;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::orderBy('created_at', 'desc')->paginate(5);
        return view('programs/index', ['programs' => $programs]);
    }

    public function show($id): View
    {
        $program = Program::findOrFail($id);

        return view('programs/show', ['program' => $program]);
    }
    public function create(): View
    {
        return view('programs/create');
    }

    public function edit($id): View
    {
        $program = Program::findOrFail($id);
        return view('programs/edit', ['program' => $program]);
    }

    public function store(ProgramFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['code'] = Program::generateCode();

        $program = Program::create($data);
        return redirect()->route('admin.program.show', ['id' => $program->id]);
    }

    public function update(Program $program, ProgramFormRequest $req)
    {
        $data = $req->validated();



        $program->update($data);

        return redirect()->route('admin.program.show', ['id' => $program->id]);
    }

    public function updateSpeed(Program $program, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $program->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Program $program)
    {

        $program->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function indexProgram(): View
    {
        $programs = Program::where('organization_id', auth()->user()->organization_id)->paginate(12);
        return view('ownpage.programViews.index', ['programs' => $programs]);
    }
    public function showProgram($id): View
    {
        $program = Program::findOrFail($id);

        return view('ownpage.programViews.show', ['program' => $program]);
    }
    public function editProgram($id): View
    {
        $program = Program::findOrFail($id);
        return view('ownpage.programViews.edit', ['program' => $program]);
    }
    public function createProgram(): View
    {
        return view('ownpage.programViews.create');
    }
    public function storeProgram(ProgramFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['code'] = Program::generateCode();

        $program = Program::create($data);
        return redirect()->route('showProgram', ['id' => $program->id]);
    }

    public function updateProgram(Program $program, ProgramFormRequest $req)
    {
        $data = $req->validated();



        $program->update($data);

        return redirect()->route('showProgram', ['id' => $program->id]);
    }



    public function deleteProgram(Program $program): JsonResponse
    {
        try {
            // Suppression du programme
            $program->delete();

            return response()->json([
                'isSuccess' => true,
                'message'   => 'Le programme a été supprimé avec succès.'
            ], 200);
        } catch (Throwable $e) {
            // Journalisation de l'erreur pour le débogage (ex: contrainte de clé étrangère SQL)
            Log::error('Erreur lors de la suppression du programme #' . $program->id . ': ' . $e->getMessage());

            return response()->json([
                'isSuccess' => false,
                'message'   => 'Impossible de supprimer ce programme car il est lié à d\'autres données.'
            ], 400);
        }
    }
}
