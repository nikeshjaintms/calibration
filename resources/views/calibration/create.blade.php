@extends('layouts.app')

@section('title', 'Add Calibration')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Calibration</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                        <a href="{{ route('calibrations.index') }}">Calibrations</a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                        <a href="#">Add Calibration</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Add Calibration</div>
                </div>

                <form method="POST" action="{{ route('calibrations.store') }}" id="calibrationForm">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jobcard<span style="color: red">*</span></label>
                                    <select name="jobcard_id" id="jobcard_id" class="form-select" required>
                                        <option value="">Select Jobcard</option>
                                        @foreach ($jobcards as $jobcard)
                                            <option value="{{ $jobcard->id }}" data-start="{{ $jobcard->start_range }}"
                                                data-end="{{ $jobcard->end_range }}"
                                                {{ (isset($jobcard_id) && $jobcard_id == $jobcard->id) || old('jobcard_id') == $jobcard->id ? 'selected' : '' }}>
                                                {{ $jobcard->jobcard_number }} - {{ $jobcard->customer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jobcard_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Calibration By</label>
                                    <select name="user_id" class="form-select select2">
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date<span style="color: red">*</span></label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ old('date', date('Y-m-d')) }}" required>
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Instrument<span style="color: red">*</span></label>
                                    <input type="text" name="instrument" class="form-control"
                                        placeholder="e.g. Master Pressure Gauge" value="{{ old('instrument') }}" required>
                                    @error('instrument')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Temp (°C)</label>
                                    <input type="text" name="temperature" class="form-control" placeholder="25"
                                        value="{{ old('temperature') }}">
                                </div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label>Humidity (%)</label>
                                    <input type="text" name="humidity" class="form-control" placeholder="50"
                                        value="{{ old('humidity') }}">
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fw-bold mb-3">Calibration Points</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="pointsTable">
                                        <thead>
                                            <tr class="bg-light">
                                                <th style="width: 120px;">Set Point %</th>
                                                <th>Expected Value</th>
                                                <th>As Found</th>
                                                <th>As Left</th>
                                                <th>Error</th>
                                                <th>Error %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (old('points'))
                                                @foreach (old('points') as $index => $point)
                                                    <tr>
                                                        <td><input type="text"
                                                                name="points[{{ $index }}][set_point_percentage]"
                                                                class="form-control set-point-pct"
                                                                value="{{ $point['set_point_percentage'] }}" readonly></td>
                                                        <td><input type="number" step="0.01"
                                                                name="points[{{ $index }}][expected]"
                                                                class="form-control expected-val"
                                                                value="{{ $point['expected'] }}" required readonly></td>
                                                        <td><input type="number" step="0.01"
                                                                name="points[{{ $index }}][as_found]"
                                                                class="form-control found-val"
                                                                value="{{ $point['as_found'] }}"></td>
                                                        <td><input type="number" step="0.01"
                                                                name="points[{{ $index }}][as_left]"
                                                                class="form-control left-val"
                                                                value="{{ $point['as_left'] }}"></td>
                                                        <td><input type="number" step="0.01"
                                                                name="points[{{ $index }}][error]"
                                                                class="form-control error-val"
                                                                value="{{ $point['error'] }}" readonly></td>
                                                        <td><input type="number" step="0.0001"
                                                                name="points[{{ $index }}][error_percentage]"
                                                                class="form-control error-pct"
                                                                value="{{ $point['error_percentage'] }}" readonly></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Final Result<span style="color: red">*</span></label>
                                    <select name="result" class="form-select" required>
                                        <option value="pass" {{ old('result') == 'pass' ? 'selected' : '' }}>PASS
                                        </option>
                                        <option value="fail" {{ old('result') == 'fail' ? 'selected' : '' }}>FAIL
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('calibrations.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script>
        $(document).ready(function() {
            let rowIdx = {{ old('points') ? count(old('points')) : 0 }};

            // Auto-generate rows on Jobcard change
            $('#jobcard_id').change(function() {
                let selected = $(this).find('option:selected');
                if (selected.val() === "") {
                    $('#pointsTable tbody').empty();
                    return;
                }

                let start = parseFloat(selected.data('start')) || 0;
                let end = parseFloat(selected.data('end')) || 0;
                let span = end - start;

                // Calculate 5 equal points
                let expectedPoints = [{
                        pct: '0%',
                        val: start
                    },
                    {
                        pct: '25%',
                        val: start + (span * 0.25)
                    },
                    {
                        pct: '50%',
                        val: start + (span * 0.50)
                    },
                    {
                        pct: '75%',
                        val: start + (span * 0.75)
                    },
                    {
                        pct: '100%',
                        val: end
                    }
                ];

                $('#pointsTable tbody').empty();
                rowIdx = 0;

                expectedPoints.forEach(point => {
                    let newRow = `
                    <tr>
                        <td><input type="text" name="points[${rowIdx}][set_point_percentage]" class="form-control set-point-pct" value="${point.pct}" readonly></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][expected]" class="form-control expected-val" value="${point.val.toFixed(4)}" required readonly></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][as_found]" class="form-control found-val"></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][as_left]" class="form-control left-val"></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][error]" class="form-control error-val" readonly></td>
                        <td><input type="number" step="0.0001" name="points[${rowIdx}][error_percentage]" class="form-control error-pct" readonly></td>
                    </tr>
                `;
                    $('#pointsTable tbody').append(newRow);
                    rowIdx++;
                });
            });

            // Remove Row script removed as points are fixed

            // Calculations
            $(document).on('input', '.found-val, .left-val, .expected-val', function() {
                let row = $(this).closest('tr');
                calculateRow(row);
            });

            function calculateRow(row) {
                let expected = parseFloat(row.find('.expected-val').val()) || 0;
                let left = parseFloat(row.find('.left-val').val());
                let found = parseFloat(row.find('.found-val').val());

                // Use As Left if present, else As Found
                let valToUse = !isNaN(left) ? left : (!isNaN(found) ? found : null);

                if (valToUse === null) {
                    row.find('.error-val').val("");
                    row.find('.error-pct').val("");
                    return;
                }

                // Error = As Left - Expected
                let error = valToUse - expected;
                row.find('.error-val').val(error.toFixed(2));

                // Error % = (Error / Expected) * 100
                // Handling division by zero for the 0 point
                let selected = $('#jobcard_id option:selected');
                let start = parseFloat(selected.data('start')) || 0;
                let end = parseFloat(selected.data('end')) || 1;
                let span = end - start;

                // Always use span for % error
                let errorPct = (error / span) * 100;
                row.find('.error-pct').val(errorPct.toFixed(4));
            }

            // Trigger on initial selection (for old input fallback)
            if ($('#jobcard_id').val() !== "" && $('#pointsTable tbody tr').length === 0) {
                $('#jobcard_id').trigger('change');
            }
        });
    </script>
@endsection
