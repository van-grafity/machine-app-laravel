@extends('layouts.master')

@section('content')
    <div class="container">
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

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="machine_types_table" class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">No</th>
                                        <th>Name</th>
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
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
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
            $('#machine_types_table').on('click', '.btn-detail', function () {
                var id = $(this).data('id');
                showFormModal(false, id);
            });

            // Delete machine type
            $('#machine_types_table').on('click', '.btn-delete', function () {
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
                        url: "{{ url('machine-types') }}" + '/' + id + '/edit',
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
                confirmAction("Are you sure?", "You won't be able to revert this!", "warning", function() {
                    $.ajax({
                        url: '{{ route('machine-types.destroy', '') }}/' + id,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            showAlert("Deleted!", "Your file has been deleted.", "success", function() {
                                table.ajax.reload();
                            });
                        },
                        error: function(data) {
                            showAlert("Error!", "There is an error deleting the data.", "error");
                        }
                    });
                });
            }

             // Function to confirm action
            function confirmAction(title, text, icon, callback) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        callback();
                    }
                });
            }

            // Function to show alert
            function showAlert(title, text, icon, callback = null) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    confirmButtonColor: '#3085d6',
                }).then((result) => {
                    if (callback && result.value) {
                        callback();
                    }
                });
            }
            });
    </script>
@endpush