<?php

namespace App\Http\Controllers;

use App\Events\LogEntryCreated;
use App\Http\Requests\DeviceRegisterRequest;
use App\Http\Requests\LogEntryRequest;
use App\Models\LogEntry;
use App\Models\Organisation;
use Inertia\Inertia;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Resources\DeviceResource;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Events\DeviceCreated;
use App\Events\DeviceRemoved;
use App\Events\DeviceUnverified;
use App\Events\DeviceVerified;
use App\Events\DeviceUpdated;

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
                $query->where('name', 'LIKE', '%' . $term . '%')
                ->orwhere('deviceidentifier', 'LIKE', '%' . $term . '%');
            })->latest()
            ->paginate(5)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Devices/Create',[
            'organisation' => Auth::user()->organisation,
            'url' => config('app.url'),
        ]);
    }

     /**
     * register a new device.
     */
    public function register(DeviceRegisterRequest $request, Organisation $organisation)
    {
        $validatedData = $request->validated();

        if ($validatedData["organisationpassword"] != $organisation->registrationpassword)
        {
            $message = "organisationpassword not matching";
            $response = [
                'message' => "organisationpassword not matching",
                'errors' => [
                    'organisationpassword' => [
                        $message,
                    ],
                ],
            ];


            return response()->json($response, 422);
        }

        $device = Device::create($validatedData);
        $device->organisation()->associate($organisation) ;
        $device->save();
        $token = $device->createToken('Inittoken')->plainTextToken;

        event(new DeviceCreated($device));


        $response = [
            'success' => true,
            'token'    => $token,
            'message' => "registered successfully",
        ];


        return response()->json($response, 200);
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
    public function edit(Device $device)
    {
        return Inertia::render('Devices/Edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $device = Device::where('id', $id)->first();

        if (isset($device))
        {
            $device->update($request->all());
            event(new DeviceUpdated($device));
        }

        return redirect('/devices')->with('success', 'Device has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        
        $device->delete();

        event(new DeviceRemoved($device));

        return back()->with('delete', 'Device has been deleted!');
    }


    public function verify(Request $request, Device $device)
    {
        $device->verified_at = Carbon::now();
        $device->verified_from = Auth::user()->id;
        $device->save();
        event(new DeviceVerified($device));

        return back()->with('success', 'Device has been verified!');

    }

    public function unverify(Request $request, Device $device)
    {
        $device->verified_at = null;
        $device->verified_from = null;
        $device->save();
        event(new DeviceUnverified($device));
        return back()->with('success', 'Device has been unverified!');
    }



}
