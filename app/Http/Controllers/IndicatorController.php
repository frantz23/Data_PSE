<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\IndicatorFormRequest;
use App\Models\IndicatorValue;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class IndicatorController extends Controller
{
    public function index(): View
    {
        $indicators = Indicator::orderBy('created_at', 'desc')->paginate(5);
        $projects = Project::where('organization_id', auth()->user()->organization_id)->get();
        return view('indicators/index', ['indicators' => $indicators, 'projects' => $projects]);
    }

    public function show($id): View
    {
        $indicator = Indicator::findOrFail($id);

        return view('indicators/show',['indicator' => $indicator]);
    }
    public function create(): View
    {
        $projects = Project::where('organization_id', auth()->user()->organization_id)->get();
        return view('indicators/create',['projects' => $projects]);
    }

    public function edit($id): View
    {
        $indicator = Indicator::findOrFail($id);
        $projects = Project::where('organization_id', auth()->user()->organization_id)->get();
        return view('indicators/edit', ['indicator' => $indicator, 'projects' => $projects]);
    }

    public function store(IndicatorFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['code']= Indicator::generateCode();


        $indicator = Indicator::create($data);
        return redirect()->route('admin.indicator.show', ['id' => $indicator->id]);
    }

    public function update(Indicator $indicator, IndicatorFormRequest $req)
    {
        $data = $req->validated();



        $indicator->update($data);

        return redirect()->route('admin.indicator.show', ['id' => $indicator->id]);
    }

    public function updateSpeed(Indicator $indicator, Request $req)
    {
        foreach ($req->all() as $key => $value) {
            $indicator->update([
                $key => $value
            ]);
        }

        return [
            'isSuccess' => true,
            'data' => $req->all()
        ];
    }

    public function delete(Indicator $indicator)
    {

        $indicator->delete();

        return [
            'isSuccess' => true
        ];
    }

    public function indexIndicator(): View
    {
        $indicators = Indicator::orderBy('created_at', 'desc')->paginate(5);
        return view('ownpage.indicatorViews.index', ['indicators' => $indicators]);
    }

    public function showIndicator($id): View
    {
        $indicator = Indicator::findOrFail($id);
        $indicatorValues = IndicatorValue::where('id',$id)->get();

        return view('ownpage.indicatorViews.show',['indicator' => $indicator, 'indicatorValues' => $indicatorValues]);
    }

    public function createIndicator(): View
    {
        $projects = Project::where('organization_id', auth()->user()->organization_id)->get();
        return view('ownpage.indicatorViews.create',['projects' => $projects]);
    }

    public function editIndicator($id): View
    {
        $indicator = Indicator::findOrFail($id);
        $projects = Project::where('organization_id', auth()->user()->organization_id)->get();
        return view('ownpage.indicatorViews.edit', ['indicator' => $indicator, 'projects' => $projects]);
    }

    public function storeIndicator(IndicatorFormRequest $req): RedirectResponse
    {
        $data = $req->validated();
        $data['organization_id'] = auth()->user()->organization_id;
        $data['user_id'] = auth()->id();
        $data['code']= Indicator::generateCode();


        $indicator = Indicator::create($data);
        return redirect()->route('showIndicator', ['id' => $indicator->id]);
    }

    public function updateIndicator(Indicator $indicator, IndicatorFormRequest $req)
    {
        $data = $req->validated();



        $indicator->update($data);

        return redirect()->route('showIndicator', ['id' => $indicator->id]);
    }

}
