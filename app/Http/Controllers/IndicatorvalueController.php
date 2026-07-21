<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndicatorvalueFormRequest;
use App\Models\Indicator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class IndicatorvalueController extends Controller
{
    public function index(): View
    {
        $indicators = Indicator::with('project', 'organization')->where('organization_id', auth()->user()->organization_id)->get();
        $indicatorvalues = Indicatorvalue::orderBy('created_at', 'desc')->paginate(5);
        return view('indicatorvalues/index', ['indicatorvalues' => $indicatorvalues, 'indicators' => $indicators]);
    }

    public function show($id): View
    {
        $indicatorvalue = Indicatorvalue::findOrFail($id);

        return view('indicatorvalues/show', ['indicatorvalue' => $indicatorvalue]);
    }
    public function create(): View
    {
        $indicators = Indicator::with(['project', 'organization'])->where('organization_id', auth()->user()->organization_id)->get();
        return view('indicatorvalues/create', ['indicators' => $indicators]);
    }

    public function edit($id): View
    {
        $indicatorvalue = Indicatorvalue::findOrFail($id);
        return view('indicatorvalues/edit', ['indicatorvalue' => $indicatorvalue]);
    }

    public function store(IndicatorvalueFormRequest $req): RedirectResponse
    {
        $data = $req->validated();

        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['validated'] = false;

        $indicatorvalue = Indicatorvalue::create($data);
        return redirect()->route('admin.indicatorvalue.show', ['id' => $indicatorvalue->id]);
    }

    public function update(Indicatorvalue $indicatorvalue, IndicatorvalueFormRequest $req)
    {
        $data = $req->validated();



        $indicatorvalue->update($data);

        return redirect()->route('admin.indicatorvalue.show', ['id' => $indicatorvalue->id]);
    }

    public function updateSpeed(Indicatorvalue $indicatorvalue, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $indicatorvalue->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Indicatorvalue $indicatorvalue)
    {

        $indicatorvalue->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function createIndicatorValue($id): View
    {
        $indicator = Indicator::findOrFail($id);

        $indicators = Indicator::with(['project', 'organization'])->where('organization_id', auth()->user()->organization_id)->get();
        return view('ownpage.indicatorValuesViews/create', ['indicators' => $indicators, 'indicator' => $indicator]);
    }

    public function showIndicatorValue($id): View
    {
        $indicatorValue = IndicatorValue::findOrFail($id);
        // Charge l'indicateur avec tous ses fichiers rattachés
        $indicatorValue->load('indicatorvaluefiles');
        return view('ownpage.indicatorValuesViews.show', ['indicatorValue' => $indicatorValue]);
    }

    public function editIndicatorValue($id): View
    {
        $indicatorvalue = Indicatorvalue::findOrFail($id);
        $indicator = $indicatorvalue->indicator;
        return view('ownpage.indicatorValuesViews.edit', ['indicatorvalue' => $indicatorvalue, 'indicator' => $indicator]);
    }

    public function storeIndicatorValue(IndicatorvalueFormRequest $req): RedirectResponse
    {
        $data = $req->validated();

        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['validated'] = false;

        $indicatorvalue = Indicatorvalue::create($data);
        return redirect()->route('showIndicatorValue', ['id' => $indicatorvalue->id]);
    }

    public function updateIndicatorValue(Indicatorvalue $indicatorvalue, IndicatorvalueFormRequest $req)
    {
        $data = $req->validated();



        $indicatorvalue->update($data);

        return redirect()->route('showIndicatorValue', ['id' => $indicatorvalue->id]);
    }
}
