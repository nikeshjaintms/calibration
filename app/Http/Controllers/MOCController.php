<?php

namespace App\Http\Controllers;

use App\Models\MOC;
use Illuminate\Http\Request;

class MOCController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mocs = MOC::all();
        return view('moc.index', compact('mocs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('moc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        MOC::create($request->all());

        return redirect()->route('mocs.index')->with('success', 'MOC created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $moc = MOC::findOrFail($id);
        return view('moc.show', compact('moc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $moc = MOC::findOrFail($id);
        return view('moc.edit', compact('moc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $moc = MOC::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $moc->update($request->all());

        return redirect()->route('mocs.index')->with('success', 'MOC updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $moc = MOC::findOrFail($id);
        $moc->delete();

        if (request()->ajax()) {
            if ($moc->trashed()) {
                return response()->json(['status' => 'success', 'message' => 'MOC deleted successfully.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete MOC.']);
            }
        }

        if ($moc->trashed()) {
            return redirect()->route('mocs.index')->with('success', 'MOC deleted successfully.');
        } else {
            return redirect()->route('mocs.index')->with('error', 'Failed to delete MOC.');
        }
    }
}
