<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use \App\Enums\UserRoleEnum;

use App\Models\Organisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('term');


            return Inertia::render('Users/Index', [
                'users' => UserResource::collection(User::with('organisation')->when($term, function ($query, $term) {
                    $query->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('email', 'LIKE', '%' . $term . '%');
                })->latest()
                ->paginate(5)),
            ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => UserRoleEnum::all(),
            'organisations' => Organisation::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        $user->organisation()->associate(Organisation::find($validatedData['organisation_id'])) ;
        $user->save();
        $user->notificationSetting()->create();

        return redirect()->route('users.index')->with('success', 'User has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $getUser = User::with('organisation')->findOrFail($id);

        return Inertia::render('Users/Show', compact('getUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('organisation')->findOrFail($id);

        return Inertia::render('Users/Edit',[
            'roles' => UserRoleEnum::all(),
            'organisations' => Organisation::all(),
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        User::where('id', $id)->update($request->all());

        return redirect('/users')->with('success', 'User has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);

        return back()->with('delete', 'User has been deleted!');
    }

}
