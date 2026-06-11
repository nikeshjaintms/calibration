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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jobcard<span style="color: red">*</span></label>
                                <select name="jobcard_id" id="jobcard_id" class="form-select" required>
                                    <option value="">Select Jobcard</option>
                                    @foreach($jobcards as $jobcard)
                                    <option value="{{ $jobcard->id }}"
                                        data-start="{{ $jobcard->start_range }}"
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
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
                                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Instrument<span style="color: red">*</span></label>
                                <input type="text" name="instrument" class="form-control" placeholder="e.g. Master Pressure Gauge" value="{{ old('instrument') }}" required>
                                @error('instrument')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label>Temp (°C)</label>
                                <input type="text" name="temperature" class="form-control" placeholder="25" value="{{ old('temperature') }}">
                            </div>
                        </div>

                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label>Humidity (%)</label>
                                <input type="text" name="humidity" class="form-control" placeholder="50" value="{{ old('humidity') }}">
                            </div>
                        </div>

                        <!-- NEW FIELDS ROW 1 -->
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>PO Number</label>
                                <input type="text" name="po_no" id="po_no" class="form-control" placeholder="e.g. 2026101402" value="{{ old('po_no') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>PO Date</label>
                                <input type="date" name="po_date" id="po_date" class="form-control" value="{{ old('po_date') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Pressure Unit</label>
                                <input type="text" name="pressure_unit" id="pressure_unit" class="form-control" placeholder="e.g. MMWC" value="{{ old('pressure_unit', 'MMWC') }}">
                            </div>
                        </div>

                        <!-- NEW FIELDS ROW 2 -->
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Warranty</label>
                                <input type="text" name="warranty" id="warranty" class="form-control" placeholder="e.g. 12 MONTHS" value="{{ old('warranty', '12 MONTHS') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Warranty Due Date</label>
                                <input type="date" name="warranty_due_date" id="warranty_due_date" class="form-control" value="{{ old('warranty_due_date') }}">
                            </div>
                        </div>

                        <!-- NEW FIELDS ROW 3 -->
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Master Accuracy</label>
                                <input type="text" name="master_accuracy" id="master_accuracy" class="form-control" placeholder="e.g. ± 0.0003%" value="{{ old('master_accuracy', '± 0.0003%') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Calibration Method</label>
                                <input type="text" name="calibration_method" id="calibration_method" class="form-control" placeholder="e.g. Compression" value="{{ old('calibration_method', 'Compression') }}">
                            </div>
                        </div>

                        <div class="col-md-8 mt-3">
                            <div class="form-group">
                                <label>Hart / Field Communicator Make</label>
                                <input type="text" name="communicator_make" id="communicator_make" class="form-control" placeholder="e.g. Prisys (Brazil), SKE, Automac, Siemens" value="{{ old('communicator_make', 'Prisys (Brazil), SKE, Automac, Siemens') }}">
                            </div>
                        </div>

                        <!-- NEW FIELDS ROW 4 -->
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Activity</label>
                                <input type="text" name="activity" id="activity" class="form-control" placeholder="e.g. Transmitter Health check, '0' set..." value="{{ old('activity', 'Transmitter Health check, \'0\' set, Range setting, Linearity check, Output check') }}">
                            </div>
                        </div>

                       <textarea
    name="work_details"
    id="work_details"
    class="form-control"
    rows="3"
    placeholder="Flange, Capillary and MOC details..."
    readonly
    style="background:#f5f5f5;"
>{{ old('work_details') }}</textarea>
                    </div>

                    <hr class="mt-4 mb-4">

                    <div id="dynamicSection" style="{{ old('jobcard_id') ? '' : 'display: none;' }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="fw-bold mb-0">Calibration Points</h4>

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="pointsTable">
                                        <thead>
                                            <tr class="bg-light">
                                                <th style="width: 120px;">Set Point %</th>
                                                <th>Expected Value</th>
                                                <th>Measured mA (As Found)</th>
                                                <th>Measured mA (As Left)</th>
                                                <th>Error</th>
                                                <th>Error %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(old('points'))
                                                @foreach(old('points') as $index => $point)
                                                <tr>
                                                    <td><input type="text" name="points[{{ $index }}][set_point_percentage]" class="form-control set-point-pct" value="{{ $point['set_point_percentage'] ?? '' }}" readonly></td>
                                                    <td><input type="number" step="0.01" name="points[{{ $index }}][expected]" class="form-control expected-val" value="{{ $point['expected'] }}" required readonly></td>
                                                    <td><input type="number" step="0.01" name="points[{{ $index }}][as_found]" class="form-control found-val" value="{{ $point['as_found'] }}"></td>
                                                    <td><input type="number" step="0.01" name="points[{{ $index }}][as_left]" class="form-control left-val" value="{{ $point['as_left'] }}"></td>
                                                    <td><input type="number" step="0.01" name="points[{{ $index }}][error]" class="form-control error-val" value="{{ $point['error'] }}" readonly></td>
                                                    <td><input type="number" step="0.0001" name="points[{{ $index }}][error_percentage]" class="form-control error-pct" value="{{ $point['error_percentage'] }}" readonly></td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input type="text" name="points[0][set_point_percentage]" class="form-control set-point-pct" readonly></td>
                                                    <td><input type="number" step="0.01" name="points[0][expected]" class="form-control expected-val" required readonly></td>
                                                    <td><input type="number" step="0.01" name="points[0][as_found]" class="form-control found-val"></td>
                                                    <td><input type="number" step="0.01" name="points[0][as_left]" class="form-control left-val"></td>
                                                    <td><input type="number" step="0.01" name="points[0][error]" class="form-control error-val" readonly></td>
                                                    <td><input type="number" step="0.0001" name="points[0][error_percentage]" class="form-control error-pct" readonly></td>
                                                    <td></td>
                                                </tr>
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
                                        <option value="pass" {{ old('result') == 'pass' ? 'selected' : '' }}>PASS</option>
                                        <option value="fail" {{ old('result') == 'fail' ? 'selected' : '' }}>FAIL</option>
                                    </select>
                                </div>
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
       let rowIdx = Number("{{ count(old('points', [])) }}");

        // Auto-generate rows and fetch details on Jobcard change
        $('#jobcard_id').change(function() {
            let selected = $(this).find('option:selected');
            if (selected.val() === "") {
                $('#dynamicSection').hide();
                $('#pointsTable tbody').empty();
                $('#po_no').val('');
                $('#po_date').val('');
                $('#work_details').val('');
                $('#warranty_due_date').val('');
                return;
            }

            $('#dynamicSection').show();
            let start = parseFloat(selected.data('start')) || 0;
            let end = parseFloat(selected.data('end')) || 0;
            let span = end - start;

            // Calculate 5 equal points
            let calibrationPoints = [
                { pct: '0%', val: start },
                { pct: '25%', val: start + (span * 0.25) },
                { pct: '50%', val: start + (span * 0.50) },
                { pct: '75%', val: start + (span * 0.75) },
                { pct: '100%', val: end }
            ];

            $('#pointsTable tbody').empty();
            rowIdx = 0;

            calibrationPoints.forEach(point => {
                let newRow = `
                    <tr>
                        <td><input type="text" name="points[${rowIdx}][set_point_percentage]" class="form-control set-point-pct" value="${point.pct}" readonly></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][expected]" class="form-control expected-val" value="${point.val.toFixed(2)}" required readonly></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][as_found]" class="form-control found-val"></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][as_left]" class="form-control left-val"></td>
                        <td><input type="number" step="0.01" name="points[${rowIdx}][error]" class="form-control error-val" readonly></td>
                        <td><input type="number" step="0.0001" name="points[${rowIdx}][error_percentage]" class="form-control error-pct" readonly></td>
                    </tr>
                `;
                $('#pointsTable tbody').append(newRow);
                rowIdx++;
            });

            // Fetch Jobcard dynamic details via AJAX
            let jobcardId = selected.val();
            $.ajax({
                url: `/calibrations/jobcard-details/${jobcardId}`,
                type: 'GET',
                success: function(response) {
                    if(response.default_work_details) {
                        $('#work_details').val(response.default_work_details);
                    }
                    // Auto-calculate warranty due date based on order/receiving date + 1 year (as default)
                    let orderDate = response.jobcard.jobcard_date;
                    if(orderDate) {
                        let dateObj = new Date(orderDate);
                        dateObj.setFullYear(dateObj.getFullYear() + 1);
                        dateObj.setDate(dateObj.getDate() - 1);
                        let dd = String(dateObj.getDate()).padStart(2, '0');
                        let mm = String(dateObj.getMonth() + 1).padStart(2, '0');
                        let yyyy = dateObj.getFullYear();
                        $('#warranty_due_date').val(`${yyyy}-${mm}-${dd}`);
                    }
                },
                error: function(err) {
                    console.error("Error fetching jobcard details:", err);
                }
            });
        });




        // Calculations
        $(document).on('input', '.found-val, .left-val, .expected-val', function() {
            let row = $(this).closest('tr');
            calculateRow(row);
        });

        function calculateRow(row) {
            let setPointStr = row.find('.set-point-pct').val() || "0";
            let pct = parseFloat(setPointStr.replace('%', '')) || 0;
            let desired = 4 + (pct / 100) * 16;
            
            let found = parseFloat(row.find('.found-val').val());
            let left = parseFloat(row.find('.left-val').val());

            // If left is entered, use left, else use found.
            let measured = NaN;
            if (!isNaN(left)) {
                measured = left;
            } else if (!isNaN(found)) {
                measured = found;
            }

            if (isNaN(measured)) {
                row.find('.error-val').val("");
                row.find('.error-pct').val("");
                return;
            }

            // Error = Measured mA - Desired Output mA
            let error = measured - desired;
            row.find('.error-val').val(error.toFixed(3));

            // Error % = (Error / 16) * 100
            let errorPct = (error / 16) * 100;
            row.find('.error-pct').val(errorPct.toFixed(4));
        }

        // Trigger on initial selection (for old input fallback)
        if ($('#jobcard_id').val() !== "" && $('#pointsTable tbody tr').length === 0) {
            $('#jobcard_id').trigger('change');
        }

        // Recalculate errors when form is reloaded with old input
        $('#pointsTable tbody tr').each(function() {
            calculateRow($(this));
        });
    });
</script>

@endsection
