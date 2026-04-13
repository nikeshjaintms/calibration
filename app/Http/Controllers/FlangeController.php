<?php

namespace App\Http\Controllers;

use App\Models\Flange;
use Illuminate\Http\Request;

class FlangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flanges = Flange::all();
        return view('flange.index', compact('flanges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('flange.create');
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

        Flange::create($request->all());

        return redirect()->route('flanges.index')->with('success', 'Flange created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $flange = Flange::findOrFail($id);
        return view('flange.show', compact('flange'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $flange = Flange::findOrFail($id);
        return view('flange.edit', compact('flange'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $flange = Flange::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $flange->update($request->all());

        return redirect()->route('flanges.index')->with('success', 'Flange updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $flange = Flange::findOrFail($id);
        $flange->delete();

        if (request()->ajax()) {
            if ($flange->trashed()) {
                return response()->json(['status' => 'success', 'message' => 'Flange deleted successfully.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete Flange.']);
            }
        }

        if ($flange->trashed()) {
            return redirect()->route('flanges.index')->with('success', 'Flange deleted successfully.');
        } else {
            return redirect()->route('flanges.index')->with('error', 'Failed to delete Flange.');
        }
    }
}
