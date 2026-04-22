<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calibration;
use App\Models\CalibrationPoint;
use App\Models\jobcard;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CalibrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calibrations = Calibration::with(['jobcard', 'points'])->latest()->get();
        return view('calibration.index', compact('calibrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jobcard_id = $request->query('jobcard_id');
        $jobcards = jobcard::where('status', 'active')->get();
        $users = User::where('status', 'active')->get();
        return view('calibration.create', compact('jobcards', 'jobcard_id', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'jobcard_id' => 'required|exists:jobcards,id',
    //         'user_id' => 'nullable|exists:users,id',
    //         'date' => 'required|date',
    //         'instrument' => 'required|string',
    //         'certificate_number' => 'required|string',
    //         'temperature' => 'nullable|string',
    //         'humidity' => 'nullable|string',
    //         'result' => 'required|in:pass,fail',
    //         'points' => 'required|array|min:1',
    //         'points.*.expected' => 'required|numeric',
    //         'points.*.as_found' => 'nullable|numeric',
    //         'points.*.as_left' => 'nullable|numeric',
    //         'points.*.error' => 'nullable|numeric',
    //         'points.*.error_percentage' => 'nullable|numeric',
    //     ]);

    //     DB::transaction(function () use ($request) {
    //         $data = $request->except(['points', 'user_id']);

    //         if ($request->user_id) {
    //             $user = User::findOrFail($request->user_id);
    //             $data['user_id'] = $user->id;
    //             $data['calibration_by'] = $user->name;
    //         } else {
    //             $data['user_id'] = null;
    //             $data['calibration_by'] = null;
    //         }

    //         $calibration = Calibration::create($data);

    //         foreach ($request->points as $point) {
    //             $calibration->points()->create($point);
    //         }
    //     });

    //     return redirect()->route('calibrations.index')->with('success', 'Calibration record created successfully.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'jobcard_id' => 'required|exists:jobcards,id',
            'user_id' => 'nullable|exists:users,id',
            'date' => 'required|date',
            'instrument' => 'required|string',
            'temperature' => 'nullable|string',
            'humidity' => 'nullable|string',
            'result' => 'required|in:pass,fail',
            'points' => 'required|array|min:1',
            'points.*.set_point_percentage' => 'nullable|string',
            'points.*.expected' => 'required|numeric',
            'points.*.as_found' => 'nullable|numeric',
            'points.*.as_left' => 'nullable|numeric',
            'points.*.error' => 'nullable|numeric',
            'points.*.error_percentage' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {

            $data = $request->except(['points', 'user_id', 'certificate_number']);

            // 👇 Financial Year Logic (April to March)
            $year = date('Y');
            $month = date('m');

            if ($month >= 4) {
                $startYear = $year;
                $endYear = substr($year + 1, -2);
            } else {
                $startYear = $year - 1;
                $endYear = substr($year, -2);
            }

            $financialYear = $startYear . '-' . $endYear;

            // 👇 Get Last Certificate Number
            $lastCalibration = Calibration::where('certificate_number', 'like', "CERT-$financialYear-%")
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if ($lastCalibration) {
                $lastNumber = (int) substr($lastCalibration->certificate_number, -3);
                $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }

            // 👇 Final Certificate Number
            $data['certificate_number'] = "CERT-$financialYear-$newNumber";

            // 👇 User Handling
            if ($request->user_id) {
                $user = User::findOrFail($request->user_id);
                $data['user_id'] = $user->id;
                $data['calibration_by'] = $user->name;
            } else {
                $data['user_id'] = null;
                $data['calibration_by'] = null;
            }

            // 👇 Create Calibration
            $calibration = Calibration::create($data);

            if($calibration->result === 'fail') {
                $calibration->jobcard->update(['status' => 'failed']);
            }
            else{
                $calibration->jobcard->update(['status' => 'completed']);
            }

            // 👇 Save Points
            foreach ($request->points as $point) {
                $calibration->points()->create($point);
            }
        });

        return redirect()->route('calibrations.index')
            ->with('success', 'Calibration record created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $calibration = Calibration::with(['jobcard', 'points'])->findOrFail($id);
        return view('calibration.show', compact('calibration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $calibration = Calibration::with('points')->findOrFail($id);
        $jobcards = jobcard::all();
        $users = User::all();
        return view('calibration.edit', compact('calibration', 'jobcards', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $calibration = Calibration::findOrFail($id);

        $request->validate([
            'jobcard_id' => 'required|exists:jobcards,id',
            'user_id' => 'nullable|exists:users,id',
            'date' => 'required|date',
            'instrument' => 'required|string',
            'certificate_number' => 'required|string',
            'temperature' => 'nullable|string',
            'humidity' => 'nullable|string',
            'result' => 'required|in:pass,fail',
            'points' => 'required|array|min:1',
            'points.*.set_point_percentage' => 'nullable|string',
            'points.*.expected' => 'required|numeric',
            'points.*.as_found' => 'nullable|numeric',
            'points.*.as_left' => 'nullable|numeric',
            'points.*.error' => 'nullable|numeric',
            'points.*.error_percentage' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request, $calibration) {
            $data = $request->except(['points', 'user_id']);

            if ($request->user_id) {
                $user = User::findOrFail($request->user_id);
                $data['user_id'] = $user->id;
                $data['calibration_by'] = $user->name;
            } else {
                $data['user_id'] = null;
                $data['calibration_by'] = null;
            }

            $calibration->update($data);

            // Delete existing points and recreate them
            $calibration->points()->delete();
            foreach ($request->points as $point) {
                $calibration->points()->create($point);
            }
        });

        return redirect()->route('calibrations.index')->with('success', 'Calibration record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $calibration = Calibration::findOrFail($id);
        $calibration->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Calibration record deleted successfully.']);
        }

        return redirect()->route('calibrations.index')->with('success', 'Calibration record deleted successfully.');
    }
}
