<?php

namespace App\Http\Controllers;

use App\Events\LogEntryCreated;
use App\Http\Requests\DeviceRegisterRequest;
use App\Http\Requests\LogEntryRequest;
use App\Http\Resources\LogEntryResource;
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

class LogEntryController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $term = $request->input('term');

        return Inertia::render('LogEntries/Index', [
            'logEntries' => LogEntryResource::collection(LogEntry::when($term, function ($query, $term) {
                $query->where('source', 'LIKE', '%' . $term . '%');
            })->latest()
            ->paginate(25)),
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function create (LogEntryRequest $request)
    {
        $validatedData = $request->validated();
        $device = Auth::user();


        $logentry=$device->logEntries()->create($validatedData);
        event(new LogEntryCreated($logentry));

        $response = [
            'success' => true,
            'data' => [
                "log_id" => $logentry->id,
            ],
        ];

        return response()->json($response, 200);
    }



    public function aknowledge(Request $request, Device $device)
    {
        // $device->verified_at = Carbon::now();
        // $device->verified_from = Auth::user()->id;
        // $device->save();
        // event(new DeviceVerified($device));

        // return redirect('/devices')->with('success', 'Device has been verified!');

    }

    public function unaknowledge(Request $request, Device $device)
    {
        // $device->verified_at = null;
        // $device->verified_from = null;
        // $device->save();
        // event(new DeviceUnverified($device));
        // return redirect('/devices')->with('success', 'Device has been unverified!');
    }



}
