@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Brands</h3>
                        <div class="card-tools d-flex">
                            <button type="button" class="btn btn-primary btn-sm" onclick="showModal(true)">Add Brand</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="brands_table" class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
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

    <div class="modal fade" id="modal_brand" tabindex="-1" role="dialog" aria-labelledby="modal_formLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form_brand" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal_title" id="modal_title">Add Brand</h5>
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
    function showModal(add, id = null) {
        $modal = $('#modal_brand');
        $form = $('#form_brand');
        $title = $('#modal_title');
        $btn = $('#modal_btn');
        $name = $('#name');

        if (add) {
            $form.attr('action', '{{ route('brands.store') }}');
            $form.trigger('reset');
            $title.text('Add Brand');
            $btn.text('Save');
        } else {
            $form.append('<input type="hidden" name="_method" value="PUT">');
            $form.attr('action', '{{ route('brands.update', '') }}/' + id);
            $title.text('Edit Brand');
            $btn.text('Update');

            $.get('{{ route('brands.show', '') }}/' + id, function(data) {
                $name.val(data.name);
            });
        }

        $modal.modal('show');
    }

    function deleteData(id) {
        confirmAction("Are you sure?", "You won't be able to revert this!", "warning", function() {
            $.ajax({
                url: '{{ route('brands.destroy', '') }}/' + id,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    showAlert("Deleted!", "Your file has been deleted.", "success", function() {
                        location.reload();
                    });
                },
                error: function(data) {
                    showAlert("Error!", "There is an error deleting the data.", "error");
                }
            });
        });
    }

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

    $(function() {
        $('#brands_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('brands.index') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { 
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return `<a href="#" class="btn btn-info btn-sm" onclick="showModal(false, ${full.id})">Detail</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteData(${full.id})">Delete</a>`;
                    }
                }
            ]
        });
    });
</script>
@endpush