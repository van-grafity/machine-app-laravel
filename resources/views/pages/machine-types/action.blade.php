<!-- resources/views/pages/machine-types/action.blade.php -->
<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="editData({{ $machineType->id }})">
    <i class="fas fa-pencil-alt"></i>
</a>
<a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteData({{ $machineType->id }})">
    <i class="fas fa-trash"></i>
</a>