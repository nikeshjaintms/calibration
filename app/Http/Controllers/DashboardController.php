<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Clients;
use App\Models\jobcard;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Clients::count();
        $totalJobcards = jobcard::count();
        $activeJobcards = jobcard::where('status', 'active')->count();
        $completedJobcards = jobcard::where('status', 'completed')->count();

        return view('index', compact('totalClients', 'totalJobcards', 'activeJobcards', 'completedJobcards'));
    }
}

