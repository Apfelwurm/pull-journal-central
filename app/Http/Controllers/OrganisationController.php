<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganisationStoreRequest;
use App\Http\Resources\OrganisationResource;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Events\OrganisationCreated;
use App\Events\OrganisationRemoved;
use App\Events\OrganisationUpdated;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('term');

        return Inertia::render('Organisations/Index', [
            'organisations' => OrganisationResource::collection(Organisation::when($term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%');
            })->latest()
            ->paginate(5)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Organisations/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganisationStoreRequest $request)
    {
        $validatedData = $request->validated();
        $organisation = Organisation::create($validatedData);

        event(new OrganisationCreated($organisation));

        return redirect()->route('organisations.index')->with('success', 'Organisation has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organisation $organisation)
    {
        return Inertia::render('Organisations/Edit', compact('organisation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $organisation = Organisation::where('id', $id)->first();
        if (isset($organisation))
        {
            $organisation->update($request->all());
            event(new OrganisationUpdated($organisation));
        }
        
        return redirect('/organisations')->with('success', 'Organisation has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organisation $organisation)
    {
        if ($organisation->id == 1)
        {
            return back()->with('error', 'Default Organisation can not be deleted!');
        }

        $organisation->delete();
        event(new OrganisationRemoved($organisation));

        return back()->with('delete', 'Organisation has been deleted!');
    }
}
