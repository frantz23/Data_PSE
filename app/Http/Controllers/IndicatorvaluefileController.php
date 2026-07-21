<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndicatorvaluefileFormRequest;
use App\Models\IndicatorValue;
use App\Models\IndicatorValueFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class IndicatorvaluefileController extends Controller
{
    public function index(): View
    {
        $indicatorvaluefiles = Indicatorvaluefile::orderBy('created_at', 'desc')->paginate(5);
        return view('indicatorvaluefiles/index', ['indicatorvaluefiles' => $indicatorvaluefiles]);
    }

    public function show($id): View
    {
        $indicatorvaluefile = Indicatorvaluefile::findOrFail($id);

        return view('indicatorvaluefiles/show', ['indicatorvaluefile' => $indicatorvaluefile]);
    }
    public function create(): View
    {
        return view('indicatorvaluefiles/create');
    }

    public function edit($id): View
    {
        $indicatorvaluefile = Indicatorvaluefile::findOrFail($id);
        return view('indicatorvaluefiles/edit', ['indicatorvaluefile' => $indicatorvaluefile]);
    }

    // public function store(IndicatorvaluefileFormRequest $req): RedirectResponse
    // {
    //     $data = $req->validated();



    //     $indicatorvaluefile = Indicatorvaluefile::create($data);
    //     return redirect()->route('admin.indicatorvaluefile.show', ['id' => $indicatorvaluefile->id]);
    // }


    public function storeIVFile(IndicatorvaluefileFormRequest $req): RedirectResponse
    {
        $validated = $req->validated();

        foreach ($req->file('files') as $file) {

            $path = $file->store(
                'organizations/' . auth()->user()->organization_id .
                    '/indicators/' . $validated['indicator_value_id'],
                'public'
            );
            // dd($req->file);

            IndicatorValueFile::create([
                'indicator_value_id' => $validated['indicator_value_id'],
                'file_name'          => $file->getClientOriginalName(),
                'file_path'          => $path,
                'mime_type'          => $file->getMimeType(),
                'file_size'          => $file->getSize(),
                'user_id'            => auth()->id(),
            ]);
        }

        return redirect()->route(
            'showIndicatorValue',
            $validated['indicator_value_id']
        )->with('success', 'Les pièces justificatives ont été ajoutées avec succès.');
    }

    public function update(Indicatorvaluefile $indicatorvaluefile, IndicatorvaluefileFormRequest $req)
    {
        $data = $req->validated();



        $indicatorvaluefile->update($data);

        return redirect()->route('admin.indicatorvaluefile.show', ['id' => $indicatorvaluefile->id]);
    }

    public function updateSpeed(Indicatorvaluefile $indicatorvaluefile, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $indicatorvaluefile->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Indicatorvaluefile $indicatorvaluefile)
    {

        $indicatorvaluefile->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function createIVFile(IndicatorValue $indicatorValue): View
    {
        return view('ownpage.ivfViews.create', compact('indicatorValue'));
    }
}
