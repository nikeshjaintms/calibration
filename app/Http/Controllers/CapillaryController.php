<?php

namespace App\Http\Controllers;

use App\Models\Capillary;
use Illuminate\Http\Request;

class CapillaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capillaries = Capillary::all();
        return view('capillary.index', compact('capillaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('capillary.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Capillary::create($request->all());

        return redirect()->route('capillaries.index')->with('success', 'Capillary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $capillary = Capillary::findOrFail($id);
        return view('capillary.show', compact('capillary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $capillary = Capillary::findOrFail($id);
        return view('capillary.edit', compact('capillary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $capillary = Capillary::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $capillary->update($request->all());

        return redirect()->route('capillaries.index')->with('success', 'Capillary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $capillary = Capillary::findOrFail($id);
        $capillary->delete();

        if (request()->ajax()) {
            if ($capillary->trashed()) {
                return response()->json(['status' => 'success', 'message' => 'Capillary deleted successfully.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete Capillary.']);
            }
        }

        if ($capillary->trashed()) {
            return redirect()->route('capillaries.index')->with('success', 'Capillary deleted successfully.');
        } else {
            return redirect()->route('capillaries.index')->with('error', 'Failed to delete Capillary.');
        }
    }
}
