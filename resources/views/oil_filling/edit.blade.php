@extends('layouts.app')

@section('title', 'Edit Oil Filling')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Oil Filling</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('oil-fillings.index') }}">Oil Filling</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">Edit</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('oil-fillings.update', $oil_filling->id) }}" method="POST" id="oilFillingForm">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4 class="card-title">Edit Oil Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jobcard_id" class="form-label">Jobcard Number <span class="text-danger">*</span></label>
                                    <select name="jobcard_id" id="jobcard_id" class="form-select select2" required>
                                        <option value="">Select Jobcard</option>
                                        @foreach($jobcards as $jobcard)
                                            <option value="{{ $jobcard->id }}" {{ $oil_filling->jobcard_id == $jobcard->id ? 'selected' : '' }}>
                                                {{ $jobcard->jobcard_number }} ({{ $jobcard->customer_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filling_date" class="form-label">Filling Date <span class="text-danger">*</span></label>
                                    <input type="date" name="filling_date" id="filling_date" class="form-control" value="{{ $oil_filling->filling_date }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="oil_type" class="form-label">Oil Type <span class="text-danger">*</span></label>
                                    <input type="text" name="oil_type" id="oil_type" class="form-control" value="{{ $oil_filling->oil_type }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" value="{{ $oil_filling->quantity }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="moc_id" class="form-label">MOC <span class="text-danger">*</span></label>
                                    <select name="moc_id" id="moc_id" class="form-select" required>
                                        <option value="">Select MOC</option>
                                        @foreach($mocs as $moc)
                                            <option value="{{ $moc->id }}" {{ $oil_filling->moc_id == $moc->id ? 'selected' : '' }}>{{ $moc->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="flange_id" class="form-label">FLANGE <span class="text-danger">*</span></label>
                                    <select name="flange_id" id="flange_id" class="form-select" required>
                                        <option value="">Select Flange</option>
                                        @foreach($flanges as $flange)
                                            <option value="{{ $flange->id }}" {{ $oil_filling->flange_id == $flange->id ? 'selected' : '' }}>{{ $flange->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="capillary_id" class="form-label">CAPILLARY <span class="text-danger">*</span></label>
                                    <select name="capillary_id" id="capillary_id" class="form-select" required>
                                        <option value="">Select Capillary</option>
                                        @foreach($capillaries as $capillary)
                                            <option value="{{ $capillary->id }}" {{ $oil_filling->capillary_id == $capillary->id ? 'selected' : '' }}>{{ $capillary->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="user_id" class="form-label">Filled By (User)</label>
                                    <select name="user_id" id="user_id" class="form-select select2">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ (old('user_id', $oil_filling->user_id) == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filled_by_display" class="form-label">Filled By (Static - Legacy)</label>
                                    <input type="text" id="filled_by_display" class="form-control" value="DILIPBHAI PATEL" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update Oil Filling</button>
                            <a href="{{ route('oil-fillings.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        $("#oilFillingForm").validate({
            rules: {
                jobcard_id: "required",
                filling_date: "required",
                oil_type: "required",
                quantity: {
                    required: true,
                    number: true
                },
                moc_id: "required",
                flange_id: "required",
                capillary_id: "required"
            },
            messages: {
                jobcard_id: "Please select a jobcard",
                filling_date: "Please select a date",
                oil_type: "Please enter oil type",
                quantity: {
                    required: "Please enter quantity",
                    number: "Please enter numbers only"
                },
                moc_id: "Please select MOC",
                flange_id: "Please select flange",
                capillary_id: "Please select capillary"
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback text-danger");
                element.closest(".mb-3").append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass("is-invalid");
            }
        });
    });
</script>
@endsection
@endsection
