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
        $oil_fillings = OilFilling::with([
            'jobcard' => function($query) {
                $query->withTrashed();
            }, 
            'moc', 'flange', 'capillary', 'user'
        ])->latest()->get();
        return view('oil_filling.index', compact('oil_fillings'));
    }

    public function create()
    {
        $jobcards = jobcard::where('status', 'active')
            ->whereHas('inspections')
            ->whereDoesntHave('oil_filling')
            ->get();
        $mocs = MOC::where('status', 'active')->get();
        $flanges = Flange::where('status', 'active')->get();
        $capillaries = Capillary::where('status', 'active')->get();
        $users = User::where('status', 'active')->get();
        return view('oil_filling.create', compact('jobcards', 'mocs', 'flanges', 'capillaries', 'users'));
    }

    public function store(Request $request)
    {
        $jobcard = jobcard::find($request->jobcard_id);
        if (!$jobcard) {
            return back()->withInput()->withErrors(['jobcard_id' => 'Please create Jobcard before Inspection.']);
        }

        if (!$jobcard->inspections()->exists()) {
            return back()->withInput()->withErrors(['jobcard_id' => 'Please complete Inspection before Oil Filling.']);
        }

        $existing = OilFilling::where('jobcard_id', $request->jobcard_id)->exists();
        if ($existing) {
            return back()->withInput()->withErrors(['jobcard_id' => 'Oil Filling record already exists for this Jobcard.']);
        }

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

        OilFilling::create($data);

        return redirect()->route('oil-fillings.index')->with('success', 'Oil Filling record created successfully.');
    }

    public function show(string $id)
    {
        $oil_filling = OilFilling::with([
            'jobcard' => function($query) {
                $query->withTrashed();
            }, 
            'jobcard.client', 'moc', 'flange', 'capillary', 'user'
        ])->findOrFail($id);
        return view('oil_filling.show', compact('oil_filling'));
    }

    public function edit(string $id)
    {
        $oil_filling = OilFilling::findOrFail($id);
        $jobcards = jobcard::where('status', 'active')
            ->whereHas('inspections')
            ->where(function($query) use ($oil_filling) {
                $query->whereDoesntHave('oil_filling')
                      ->orWhere('id', $oil_filling->jobcard_id);
            })->get();
        $mocs = MOC::where('status', 'active')->get();
        $flanges = Flange::where('status', 'active')->get();
        $capillaries = Capillary::where('status', 'active')->get();
        $users = User::all();
        return view('oil_filling.edit', compact('oil_filling', 'jobcards', 'mocs', 'flanges', 'capillaries', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $oil_filling = OilFilling::findOrFail($id);

        $jobcard = jobcard::find($request->jobcard_id);
        if (!$jobcard) {
            return back()->withInput()->withErrors(['jobcard_id' => 'Please create Jobcard before Inspection.']);
        }

        if (!$jobcard->inspections()->exists()) {
            return back()->withInput()->withErrors(['jobcard_id' => 'Please complete Inspection before Oil Filling.']);
        }

        $existing = OilFilling::where('jobcard_id', $request->jobcard_id)->where('id', '!=', $id)->exists();
        if ($existing) {
            return back()->withInput()->withErrors(['jobcard_id' => 'Oil Filling record already exists for this Jobcard.']);
        }

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

    public function generatePdf($id)
    {
        $oil_filling = OilFilling::with([
            'jobcard.client', 
            'jobcard.inspections', 
            'moc', 
            'flange', 
            'capillary'
        ])->findOrFail($id);
        
        $jobcard = $oil_filling->jobcard;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.oil_filling_certificate', compact('jobcard', 'oil_filling'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("Oil_Filling_Certificate_{$jobcard->jobcard_number}.pdf");
    }
}
