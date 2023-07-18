<?php

namespace App\Http\Controllers;

use App\Events\LogEntryAknowledged;
use App\Events\LogEntryCreated;
use App\Events\LogEntryUnaknowledged;
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
        $query = LogEntry::query();

        if (isset($filters))
        {
            if (isset($filters["id"]) && $filters["id"] != "") {
                $query->where('id', 'like',$filters["id"]);
            }
            if (isset($filters["source"]) && $filters["source"] != "") {
                $query->where('source', 'like',$filters["source"]);
            }
            if (isset($filters["class"]) && $filters["class"] != "") {
                $query->where('class', 'like',$filters["class"]);
            }
            if (isset($filters["aknowledged"]) && $filters["aknowledged"] != "" && $filters["aknowledged"] == "true" ) {
                $query->whereNotNull('aknowledged_at');
            }
            if (isset($filters["not_aknowledged"]) && $filters["not_aknowledged"] != "" && $filters["not_aknowledged"] == "true" ) {
                $query->whereNull('aknowledged_at');
            }
            if (isset($filters["device"]) && $filters["device"] != "") {
                $query->where(function ($query) use ($filters) {
                    $query->whereRelation('device', 'name', 'like', $filters["device"])
                          ->orWhereRelation('device', 'deviceidentifier', 'like', $filters["device"])
                          ->orWhereRelation('device', 'id', '=', $filters["device"]);
                });
            }
           
        }

        return Inertia::render('LogEntries/Index', [
            'logEntries' => LogEntryResource::collection($query->latest()
            ->paginate(25)),
            'filters' => $filters,
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



    public function aknowledge(Request $request, LogEntry $logEntry)
    {
        $logEntry->aknowledged_at = Carbon::now();
        $logEntry->aknowledged_from = Auth::user()->id;
        $logEntry->save();
        event(new LogEntryAknowledged($logEntry));

        return redirect('/logEntries')->with('success', 'Entry has been aknowledged!');

    }

    public function unaknowledge(Request $request, LogEntry $logEntry)
    {
        $logEntry->aknowledged_at = null;
        $logEntry->aknowledged_from = null;
        $logEntry->save();
        event(new LogEntryUnaknowledged($logEntry));
        return redirect('/logEntries')->with('success', 'Entry has been unaknowledged!');
    }



}
