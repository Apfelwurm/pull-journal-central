<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganisationStoreRequest;
use App\Http\Resources\OrganisationResource;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        Organisation::create($validatedData);

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
        Organisation::where('id', $id)->update($request->all());

        return redirect('/organisations')->with('success', 'Organisation has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organisation $organisation)
    {
        $organisation->delete();

        return back()->with('delete', 'Organisation has been deleted!');
    }
}
