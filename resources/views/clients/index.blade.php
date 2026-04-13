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
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('clients.index') }}">Clients</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Clients</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{-- @can('create-user') --}}
                            <a href="{{ route('clients.create') }}" class=" float-end btn btn-sm btn-rounded btn-primary"><i
                                    class="fas fa-plus"></i> Client</a>
                            {{-- @endcan --}}
                            <h4 class="card-title">Client</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>GST Number</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($clients as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->company }}</td>
                                                <td>{{ $item->gst_number }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $item->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($item->status) }}</span>
                                                </td>

                                                <td>
                                                    {{-- @can('show-user') --}}
                                                    <a href="{{ route('clients.show', $item->id) }}"
                                                        class="btn btn-lg btn-link btn-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    {{-- @endcan --}}

                                                    {{-- @can('edit-user') --}}
                                                    <a href="{{ route('clients.edit', $item->id) }}"
                                                        class="btn btn-lg btn-link btn-primary">
                                                        <i class="fa fa-edit">
                                                        </i></a>
                                                    {{-- @endcan --}}
                                                    {{-- @can('delete-user') --}}
                                                    <button onclick="deleteuser_info({{ $item->id }})"
                                                        class="btn btn-link btn-danger">
                                                        <i class="fa fa-trash">
                                                        </i>
                                                    </button>
                                                    {{-- @endcan --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteuser_info(id) {
            var url = "{{ url('clients') }}/" + id;
            console.log(url);
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred: ' + xhr.responseText,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>

@endsection
