<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    /**
     * Display the users.
     */
    public function show(Request $request): Response
    {
        return Inertia::render('Admin/Usermanagement',[
            'users' => User::get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
    $user->update([
        'isAdmin' => $request->boolean('isAdmin'),
        'isAllowedToView' => $request->boolean('isAllowedToView'),
    ]);

    return redirect()->to('/');
    }

}
