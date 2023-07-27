<?php

namespace App\Http\Controllers;

use App\Events\LogEntryAcknowledged;
use App\Events\LogEntryCreated;
use App\Events\LogEntryUnacknowledged;
use App\Filters\LogEntryFilters;
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
        $filters = $request->input('filters');


        return Inertia::render('LogEntries/Index', [
            'logEntries' => LogEntryResource::collection(LogEntry::filter($filters)->latest()
                ->paginate(25)),
            'filters' => $filters,
        ]);
    }


    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $logEntry = LogEntryResource::make(
            LogEntry::with(["device", "acknowledgedfrom", "device.organisation"])->findOrFail($id)
        );

        return Inertia::render('LogEntries/Show', compact('logEntry'));
    }

    public function create(LogEntryRequest $request)
    {
        $validatedData = $request->validated();

        $validator = $request->getValidatorInstance();
        $device = Auth::user();

        if ($validator->fails()) {
            $response = [
                'message' => "validation errors",
                'errors' => $validator->errors()->all(),
            ];
            return response()->json($response, 422);

        }


        $logentry = $device->logEntries()->create($validatedData);

        if (!$logentry)
        {
            $response = [
                'message' => "Logentry could not be created",
                'errors' => [
                    'logEntry' => [
                        "Logentry could not be created",
                    ],
                ],
            ];
            return response()->json($response, 500);
        }

        event(new LogEntryCreated($logentry));

        $response = [
            'success' => true,
            'data' => [
                "log_id" => $logentry->id,
            ],
        ];

        return response()->json($response, 200);
    }



    public function aknowledge(Request $request, LogEntry $logEntry)
    {
        $logEntry->acknowledged_at = Carbon::now();
        $logEntry->acknowledged_from = Auth::user()->id;
        $logEntry->save();
        event(new LogEntryAcknowledged($logEntry));

        return back()->with('success', 'Entry has been acknowledged!');

    }

    public function unaknowledge(Request $request, LogEntry $logEntry)
    {
        $logEntry->acknowledged_at = null;
        $logEntry->acknowledged_from = null;
        $logEntry->save();
        event(new LogEntryUnacknowledged($logEntry));
        return back()->with('success', 'Entry has been unacknowledged!');
    }



}