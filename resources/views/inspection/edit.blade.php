@extends('layouts.app')

@section('title', 'Edit Inspection')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Inspections</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('inspections.index') }}">Inspections</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">Edit Inspection</a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Edit Inspection</div>
            </div>

            <form method="POST" action="{{ route('inspections.update', $inspection->id) }}" id="inspectionForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jobcard<span style="color: red">*</span></label>
                                <select name="jobcard_id" class="form-select" required>
                                    <option value="">Select Jobcard</option>
                                    @foreach($jobcards as $jobcard)
                                    <option value="{{ $jobcard->id }}" {{ $inspection->jobcard_id == $jobcard->id ? 'selected' : '' }}>
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
                                <label>Body Condition<span style="color: red">*</span></label>
                                <select name="body_condition" class="form-select" required>
                                    <option value="ok" {{ $inspection->body_condition == 'ok' ? 'selected' : '' }}>OK</option>
                                    <option value="damage" {{ $inspection->body_condition == 'damage' ? 'selected' : '' }}>Damage</option>
                                </select>
                                @error('body_condition')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Display Status<span style="color: red">*</span></label>
                                <select name="display_status" class="form-select" required>
                                    <option value="working" {{ $inspection->display_status == 'working' ? 'selected' : '' }}>Working</option>
                                    <option value="not_working" {{ $inspection->display_status == 'not_working' ? 'selected' : '' }}>Not Working</option>
                                </select>
                                @error('display_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Motherboard Status<span style="color: red">*</span></label>
                                <select name="motherboard_status" class="form-select" required>
                                    <option value="ok" {{ $inspection->motherboard_status == 'ok' ? 'selected' : '' }}>OK</option>
                                    <option value="damage" {{ $inspection->motherboard_status == 'damage' ? 'selected' : '' }}>Damage</option>
                                </select>
                                @error('motherboard_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Power Card Status<span style="color: red">*</span></label>
                                <select name="power_card_status" class="form-select" required>
                                    <option value="ok" {{ $inspection->power_card_status == 'ok' ? 'selected' : '' }}>OK</option>
                                    <option value="damage" {{ $inspection->power_card_status == 'damage' ? 'selected' : '' }}>Damage</option>
                                </select>
                                @error('power_card_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Sensor Status<span style="color: red">*</span></label>
                                <select name="sensor_status" class="form-select" required>
                                    <option value="ok" {{ $inspection->sensor_status == 'ok' ? 'selected' : '' }}>OK</option>
                                    <option value="damage" {{ $inspection->sensor_status == 'damage' ? 'selected' : '' }}>Damage</option>
                                </select>
                                @error('sensor_status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" rows="3">{{ $inspection->remarks }}</textarea>
                                @error('remarks')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Photo</label>
                                @if($inspection->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset($inspection->photo) }}" alt="Current Photo" style="max-width: 200px; border-radius: 8px; border: 1px solid #ddd;">
                                        <p class="small text-muted">Current Photo</p>
                                    </div>
                                @endif
                                <input type="file" name="photo" class="form-control" onchange="previewImage(this)">
                                <div id="imagePreview" class="mt-2" style="display:none;">
                                    <img src="" alt="Preview" style="max-width: 250px; border-radius: 8px; border: 1px solid #ddd;">
                                    <p class="small text-muted">New Photo Preview</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('inspections.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        $('#inspectionForm').validate({
            rules: {
                jobcard_id: { required: true },
                body_condition: { required: true },
                display_status: { required: true },
                motherboard_status: { required: true },
                power_card_status: { required: true },
                sensor_status: { required: true }
            },
            messages: {
                jobcard_id: "Please select a jobcard",
                body_condition: "Please select body condition",
                display_status: "Please select display status",
                motherboard_status: "Please select motherboard status",
                power_card_status: "Please select power card status",
                sensor_status: "Please select sensor status"
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function(element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                $(element).removeClass("is-invalid");
            }
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').show();
                $('#imagePreview img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
