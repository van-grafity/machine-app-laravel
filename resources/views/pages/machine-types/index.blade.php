@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Machine Types</h3>
                        <div class="card-tools d-flex">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_machine_type" id="btn_add">
                                Add Machine Type
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="machine_types_table" class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
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

    <div class="modal fade" id="modal_machine_type" tabindex="-1" role="dialog" aria-labelledby="modal_formLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_machine_type" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal_title" id="modal_title">Add Machine Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
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
            // DataTable initialization
            var table = $('#machine_types_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('machine-types.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {
                        data: null,
                        render: function (data) {
                            return '<button class="btn btn-primary btn-sm detail" data-id="' + data.id + '">Detail</button>' +
                                '<button class="btn btn-danger btn-sm delete" data-id="' + data.id + '">Delete</button>';
                        }
                    }
                ],
                order: [[0, 'asc']],
                lengthChange: true,
                searching: true,
                autoWidth: false,
                responsive: true
            });
            
            // Add Machine Type
            $('#btn_add').on('click', function () {
                showFormModal(true);
            });
            
            // Show modal for detail
            $('#machine_types_table').on('click', '.detail', function () {
                var id = $(this).data('id');
                showFormModal(false, id);
            });

            // Delete machine type
            $('#machine_types_table').on('click', '.delete', function () {
                var id = $(this).data('id');
                deleteData(id);
            });

            // Function to show modal
            function showFormModal(add, id = null) {
                var $modal = $('#modal_machine_type');
                var $form = $('#form_machine_type');
                var $title = $('#modal_title');
                var $btn = $('#modal_btn');
                var $name = $('#name');

                if (add) {
                    $form.attr('action', "{{ route('machine-types.store') }}");
                    $form.trigger('reset');
                    $title.text('Add Machine Type');
                    $btn.text('Save');
                    $modal.modal('show');
                } else {
                    $.ajax({
                        url: "{{ route('machine-types.show', '') }}" + '/' + id,
                        type: 'GET',
                        success: function (response) {
                            $form.append('<input type="hidden" name="_method" value="PUT">');
                            $form.attr('action', "{{ route('machine-types.update', '') }}" + '/' + id);
                            $name.val(response.name);
                            $title.text('Edit Machine Type');
                            $btn.text('Update');
                            $modal.modal('show');
                        }
                    });
                }
            }

            // Function to delete data
            function deleteData(id) {
                if (confirm('Are you sure you want to delete this machine type?')) {
                    $.ajax({
                        url: "{{ route('machine-types.destroy', '') }}" + '/' + id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            table.ajax.reload();
                        }
                    });
                }
            }
        });
    </script>
@endpush