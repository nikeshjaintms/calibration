@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Clients</h3>

                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                        <a href="{{ route('clients.index') }}">Clients</a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                        <a href="#">Edit Clients</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Client</div>
                </div>

                <form method="POST" action="{{ route('clients.update', $client->id) }}" id="clientForm">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $client->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company <span style="color: red">*</span></label>
                                    <input type="text" name="company" class="form-control"
                                        value="{{ old('company', $client->company) }}" required>
                                    @error('company')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>GST Number <span style="color: red">*</span></label>
                                    <input type="text" name="gst_number" class="form-control"
                                        value="{{ old('gst_number', $client->gst_number) }}" minlength="15" maxlength="15"
                                        required>
                                    @error('gst_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Email <span style="color: red">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $client->email) }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Phone<span style="color: red">*</span></label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $client->phone) }}">
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Address<span style="color: red">*</span></label>
                                    <textarea type="text" name="address" class="form-control">{{ old('address', $client->address) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Status <span style="color: red">*</span></label>
                                    <select name="status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="active"
                                            {{ old('status', $client->status) == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $client->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-action">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-danger">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function() {

            $.validator.addMethod("regexEmail", function(value, element) {
                let regex = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;
                return this.optional(element) || regex.test(value);
            });

            $('input[name="phone"]').mask('0000000000');

            $('#clientForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    company: {
                        required: true
                    },
                    email: {
                        required: true,
                        regexEmail: true
                    },
                    gst_number: {
                        required: true,
                        minlength: 15,
                        maxlength: 15
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter client name",
                        minlength: "Name must be at least 2 characters"
                    },
                    company: {
                        required: "Please enter company name"
                    },
                    email: {
                        required: "Please enter email",
                        regexEmail: "Enter a valid email"
                    },
                    gst_number: {
                        required: "Please enter GST number",
                        minlength: "GST number must be 15 characters",
                        maxlength: "GST number must be 15 characters"
                    },
                    status: {
                        required: "Please select status"
                    }
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
    </script>

@endsection
