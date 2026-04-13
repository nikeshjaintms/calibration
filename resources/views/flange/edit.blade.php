@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Flanges</h3>

                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                        <a href="{{ route('flanges.index') }}">Flanges</a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                        <a href="#">Edit Flange</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Flange</div>
                </div>

                <form method="POST" action="{{ route('flanges.update', $flange->id) }}" id="flangeForm">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span style="color: red">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $flange->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Size<span style="color: red">*</span></label>
                                    <input type="text" name="size" class="form-control" value="{{ old('size', $flange->size) }}" required>
                                    @error('size')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <label>Status <span style="color: red">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $flange->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $flange->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <a href="{{ route('flanges.index') }}" class="btn btn-danger">Cancel</a>
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
            $('#flangeForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    size: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter Flange name",
                        minlength: "Name must be at least 2 characters"
                    },
                    size: {
                        required: "Please enter Flange size"
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
