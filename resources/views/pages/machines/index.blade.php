@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Machines</h3>
                        <div class="card-tools d-flex">
                            <a href="{{ route('machines.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Create Machine
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="machines_table" class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="2%">No</th>
                                        <th>Model</th>
                                        <th>Serial Number</th>
                                        <th>Machine Type</th>
                                        <th>Brand</th>
                                        <th width="8%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_machine" tabindex="-1" role="dialog" aria-labelledby="modal_formLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_machine" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal_title" id="modal_title">Add Machine</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" id="model" name="model" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" id="serial_number" name="serial_number" class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="machine_type_id">Machine Type</label>
                            <select id="machine_type_id" name="machine_type_id" class="form-control" required>
                                <option value="">Select Machine Type</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="brand_id">Brand</label>
                            <select id="brand_id" name="brand_id" class="form-control" required>
                                <option value="">Select Brand</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="modal_btn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            var table = $('#machines_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('machines.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'model', name: 'model' },
                    { data: 'serial_number', name: 'serial_number' },
                    { data: 'type.name', name: 'type.name' },
                    { data: 'brand.name', name: 'brand.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']],
                lengthChange: true,
                searching: true,
                autoWidth: false,
                responsive: true
            });

            @if(session('success'))
                Swal.fire({
                    title: 'Success',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Error',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

            $('#machines_table').on('click', '.delete-machine', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('machines.destroy', '') }}/" + id,
                        data: {
                            "_method": 'DELETE',
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            table.draw();
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            Swal.fire(
                                'Error!',
                                'Something went wrong',
                                'error'
                            );
                        }
                    });
                });
            });
        });
    </script>
@endpush