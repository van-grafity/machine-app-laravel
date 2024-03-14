@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Machines</h3>
                        <div class="card-tools d-flex">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_machine" id="btn_add">
                                Add Machine
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="machines_table" class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">No</th>
                                        <th>Model</th>
                                        <th>Serial Number</th>
                                        <th>Machine Type</th>
                                        <th>Brand</th>
                                        <th width="14%">Action</th>
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
                    { data: 'machine_type.name', name: 'machine_type.name' },
                    { data: 'brand.name', name: 'brand.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush