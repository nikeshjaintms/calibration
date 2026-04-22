@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content-page')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Jobcards</h3>

            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('jobcards.index') }}">Jobcards</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">Add Jobcard</a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Add Jobcard</div>
            </div>

            <form method="POST" action="{{ route('jobcards.store') }}" id="jobcardForm">
                @csrf

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group border">
                                <label>Client<span style="color: red">*</span></label>
                                <div class="input-group">
                                    <select name="client_id" id="client_id" class="form-select" required>
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @error('client_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jobcard Number<span style="color: red">*</span></label>
                                <input type="text" name="jobcard_number" class="form-control" value="{{ old('jobcard_number') }}" required>
                                @error('jobcard_number')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jobcard Date<span style="color: red">*</span></label>
                                <input type="date" name="jobcard_date" class="form-control" value="{{ old('jobcard_date') }}" required>
                                @error('jobcard_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bill Number</label>
                                <input type="text" name="bill_no" class="form-control" value="{{ old('bill_no') }}">
                                @error('bill_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bill Date</label>
                                <input type="date" name="bill_date" class="form-control" value="{{ old('bill_date') }}">
                                @error('bill_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Receiving Date<span style="color: red">*</span></label>
                                <input type="date" name="reciving_date" class="form-control" value="{{ old('reciving_date') }}" required>
                                @error('reciving_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Customer Name<span style="color: red">*</span></label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Tag No<span style="color: red">*</span></label>
                                <input type="text" name="tag_no" class="form-control" value="{{ old('tag_no') }}" required>
                                @error('tag_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Model No<span style="color: red">*</span></label>
                                <input type="text" name="model_no" class="form-control" value="{{ old('model_no') }}" required>
                                @error('model_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Serial No<span style="color: red">*</span></label>
                                <input type="text" name="serial_no" class="form-control" value="{{ old('serial_no') }}" required>
                                @error('serial_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Start Range<span style="color: red">*</span></label>
                                <input type="text" name="start_range" class="form-control" value="{{ old('start_range') }}" required>
                                @error('start_range')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>End Range<span style="color: red">*</span></label>
                                <input type="text" name="end_range" class="form-control" value="{{ old('end_range') }}" required>
                                @error('end_range')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <label>Status <span style="color: red">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('jobcards.index') }}" class="btn btn-danger">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Add Client Modal -->
<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <span class="fw-mediumbold"> New</span>
                    <span class="fw-light"> Client </span>
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ajaxClientForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-default">
                                <label>Name<span style="color: red">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label>Email<span style="color: red">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>Company</label>
                                <input type="text" name="company" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label>GST Number</label>
                                <input type="text" name="gst_number" class="form-control" maxlength="15" minlength="15">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label>Status<span style="color: red">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" id="saveClientBtn" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#jobcardForm').validate({
            rules: {
                client_id: {
                    required: true
                },
                jobcard_number: {
                    required: true
                },
                jobcard_date: {
                    required: true
                },
                reciving_date: {
                    required: true
                },
                customer_name: {
                    required: true
                },
                tag_no: {
                    required: true
                },
                model_no: {
                    required: true
                },
                serial_no: {
                    required: true
                },
                end_range: {
                    required: true,
                    number: true
                },
                start_range: {
                    required: true,
                    number: true
                },
                customer_name: {
                    required: true,
                    pattern: /^[a-zA-Z\s]+$/
                },
                status: {
                    required: true
                }
            },
            messages: {
                client_id: "Please select a client",
                jobcard_number: "Please enter jobcard number",
                jobcard_date: "Please select jobcard date",
                reciving_date: "Please select receiving date",
                customer_name: "Please enter customer name",
                tag_no: "Please enter tag number",
                model_no: "Please enter model number",
                serial_no: "Please enter serial number",
                start_range: {
                    required: "Please enter start range",
                    number: "Please enter numbers only"
                },
                end_range: {
                    required: "Please enter end range",
                    number: "Please enter numbers only"
                },
                customer_name: {
                    required: "Please enter customer name",
                    pattern: "Please enter characters only"
                },
                status: "Please select status"
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

        $('#saveClientBtn').click(function() {
            var formData = $('#ajaxClientForm').serialize();
            $.ajax({
                url: "{{ route('clients.store') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == 'success') {
                        var newOption = new Option(response.client.name, response.client.id, true, true);
                        $('#client_id').append(newOption).trigger('change');
                        $('#addClientModal').modal('hide');
                        $('#ajaxClientForm')[0].reset();
                        Swal.fire('Success', response.message, 'success');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = '';
                    $.each(errors, function(key, value) {
                        errorMsg += value[0] + '<br>';
                    });
                    Swal.fire('Error', errorMsg, 'error');
                }
            });
        });
    });
</script>
@endsection