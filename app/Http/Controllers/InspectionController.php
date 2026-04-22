<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inspection;
use App\Models\jobcard;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inspections = Inspection::with('jobcard')->latest()->get();
        return view('inspection.index', compact('inspections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jobcard_id = $request->query('jobcard_id');
        $jobcards = jobcard::where('status', 'active')->get();
        return view('inspection.create', compact('jobcards', 'jobcard_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jobcard_id' => 'required|exists:jobcards,id',
            'body_condition' => 'required|in:ok,damage',
            'display_status' => 'required|in:working,not_working',
            'motherboard_status' => 'required|in:ok,damage',
            'power_card_status' => 'required|in:ok,damage',
            'sensor_status' => 'required|in:ok,damage',
            'remarks' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/inspections');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $data['photo'] = 'uploads/inspections/' . $name;
        }

        Inspection::create($data);

        return redirect()->route('inspections.index')->with('success', 'Inspection added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inspection = Inspection::with('jobcard')->findOrFail($id);
        return view('inspection.show', compact('inspection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inspection = Inspection::findOrFail($id);
        $jobcards = jobcard::all();
        return view('inspection.edit', compact('inspection', 'jobcards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inspection = Inspection::findOrFail($id);
        
        $request->validate([
            'jobcard_id' => 'required|exists:jobcards,id',
            'body_condition' => 'required|in:ok,damage',
            'display_status' => 'required|in:working,not_working',
            'motherboard_status' => 'required|in:ok,damage',
            'power_card_status' => 'required|in:ok,damage',
            'sensor_status' => 'required|in:ok,damage',
            'remarks' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($inspection->photo && file_exists(public_path($inspection->photo))) {
                unlink(public_path($inspection->photo));
            }

            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/inspections');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $data['photo'] = 'uploads/inspections/' . $name;
        }

        $inspection->update($data);

        return redirect()->route('inspections.index')->with('success', 'Inspection updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inspection = Inspection::findOrFail($id);
        $inspection->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Inspection deleted successfully.']);
        }

        return redirect()->route('inspections.index')->with('success', 'Inspection deleted successfully.');
    }
}
