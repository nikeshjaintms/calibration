<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Clients::all();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:15|min:15',
            'status' => 'required|in:active,inactive',
        ]);

        $client = Clients::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Client created successfully.',
                'client' => $client
            ]);
        }

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clients $clients, $id)
    {
        $client = Clients::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clients $clients, $id)
    {
        $client = Clients::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $client = Clients::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clients $clients, $id)
    {
        $client = Clients::findOrFail($id);
        $client->delete();

        if (request()->ajax()) {
            if ($client->trashed()) {
                return response()->json(['status' => 'success', 'message' => 'Client deleted successfully.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to delete client.']);
            }
        }

        if ($client->trashed()) {
            return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
        } else {
            return redirect()->route('clients.index')->with('error', 'Failed to delete client.');
        }
    }
}
