<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Resources\DeviceResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DeviceController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $term = $request->input('term');

        return Inertia::render('Devices/Index', [
            'devices' => DeviceResource::collection(Device::when($term, function ($query, $term) {
                $query->where('name', 'LIKE', '%' . $term . '%');
            })->latest()
            ->paginate(5)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return Inertia::render('Devices/Create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(DeviceStoreRequest $request)
    // {
    //     $validatedData = $request->validated();
    //     Device::create($validatedData);

    //     return redirect()->route('devices.index')->with('success', 'Device has been created!');
    // }

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
    public function edit(Device $device)
    {
        return Inertia::render('Devices/Edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Device::where('id', $id)->update($request->all());

        return redirect('/devices')->with('success', 'Device has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        if ($device->id == 1)
        {
            return back()->with('error', 'Default Device can not be deleted!');
        }

        $device->delete();

        return back()->with('delete', 'Device has been deleted!');
    }


    public function verify(Request $request, Device $device)
    {
        $device->verified_at = Carbon::now();
        $device->verified_from = Auth::user()->id;
        $device->save();
        return redirect('/devices')->with('success', 'Device has been verified!');

    }

    public function unverify(Request $request, Device $device)
    {
        $device->verified_at = null;
        $device->verified_from = null;
        $device->save();
        return redirect('/devices')->with('success', 'Device has been unverified!');
    }



}
