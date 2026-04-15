<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OilFilling;
use App\Models\jobcard;
use App\Models\MOC;
use App\Models\Flange;
use App\Models\Capillary;
use App\Models\User;

class OilFillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oil_fillings = OilFilling::with(['jobcard', 'moc', 'flange', 'capillary', 'user'])->latest()->get();
        return view('oil_filling.index', compact('oil_fillings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobcards = jobcard::all();
        $mocs = MOC::where('status', 'active')->get();
        $flanges = Flange::where('status', 'active')->get();
        $capillaries = Capillary::where('status', 'active')->get();
        $users = User::all();
        return view('oil_filling.create', compact('jobcards', 'mocs', 'flanges', 'capillaries', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jobcard_id' => 'required|exists:jobcards,id',
            'oil_type' => 'required|string',
            'quantity' => 'required|string',
            'filling_date' => 'required|date',
            'moc_id' => 'required|exists:m_o_c_s,id',
            'flange_id' => 'required|exists:flanges,id',
            'capillary_id' => 'required|exists:capillaries,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();
        $data['filled_by'] = 'DILIPBHAI PATEL'; // Keep for legacy compatibility if needed

        OilFilling::create($data);

        return redirect()->route('oil-fillings.index')->with('success', 'Oil Filling record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $oil_filling = OilFilling::with(['jobcard', 'moc', 'flange', 'capillary', 'user'])->findOrFail($id);
        return view('oil_filling.show', compact('oil_filling'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $oil_filling = OilFilling::findOrFail($id);
        $jobcards = jobcard::all();
        $mocs = MOC::where('status', 'active')->get();
        $flanges = Flange::where('status', 'active')->get();
        $capillaries = Capillary::where('status', 'active')->get();
        $users = User::all();
        return view('oil_filling.edit', compact('oil_filling', 'jobcards', 'mocs', 'flanges', 'capillaries', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oil_filling = OilFilling::findOrFail($id);

        $request->validate([
            'jobcard_id' => 'required|exists:jobcards,id',
            'oil_type' => 'required|string',
            'quantity' => 'required|string',
            'filling_date' => 'required|date',
            'moc_id' => 'required|exists:m_o_c_s,id',
            'flange_id' => 'required|exists:flanges,id',
            'capillary_id' => 'required|exists:capillaries,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $data = $request->all();
        $data['filled_by'] = 'DILIPBHAI PATEL';

        $oil_filling->update($data);

        return redirect()->route('oil-fillings.index')->with('success', 'Oil Filling record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $oil_filling = OilFilling::findOrFail($id);
        $oil_filling->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Oil Filling record deleted successfully.']);
        }

        return redirect()->route('oil-fillings.index')->with('success', 'Oil Filling record deleted successfully.');
    }
}
