<?php

namespace App\Http\Controllers;

use App\Models\jobcard;
use App\Models\Clients;
use Illuminate\Http\Request;

class JobcardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobcards = jobcard::with('client')->latest()->get();
        return view('jobcard.index', compact('jobcards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Clients::where('status', 'active')->get();
        return view('jobcard.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'jobcard_number' => 'required|string|unique:jobcards,jobcard_number',
            'jobcard_date' => 'required|date',
            'reciving_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'tag_no' => 'required|string|max:255',
            'model_no' => 'required|string|max:255',
            'serial_no' => 'required|string|max:255',
            'start_range' => 'required|string|max:255',
            'end_range' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        jobcard::create($request->all());

        return redirect()->route('jobcards.index')->with('success', 'Jobcard created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jobcard = jobcard::with([
            'client', 
            'inspections', 
            'oil_filling.moc', 
            'oil_filling.flange', 
            'oil_filling.capillary', 
            'calibration.points'
        ])->findOrFail($id);
        return view('jobcard.show', compact('jobcard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jobcard = jobcard::findOrFail($id);
        $clients = Clients::where('status', 'active')->get();
        return view('jobcard.edit', compact('jobcard', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jobcard = jobcard::findOrFail($id);
        $request->validate([
            'client_id' => 'required',
            'jobcard_number' => 'required|string|unique:jobcards,jobcard_number,' . $id,
            'jobcard_date' => 'required|date',
            'reciving_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'tag_no' => 'required|string|max:255',
            'model_no' => 'required|string|max:255',
            'serial_no' => 'required|string|max:255',
            'start_range' => 'required|string|max:255',
            'end_range' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $jobcard->update($request->all());

        return redirect()->route('jobcards.index')->with('success', 'Jobcard updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jobcard = jobcard::findOrFail($id);
        $jobcard->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Jobcard deleted successfully.']);
        }

        return redirect()->route('jobcards.index')->with('success', 'Jobcard deleted successfully.');
    }
}
