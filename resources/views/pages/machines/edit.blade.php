@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Machine</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('machines.update', $machine->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="model">Model:</label>
                                <input type="text" name="model" class="form-control" value="{{ $machine->model }}">
                            </div>
                            <div class="form-group">
                                <label for="serial_number">Serial Number:</label>
                                <input type="text" name="serial_number" class="form-control" value="{{ $machine->serial_number }}">
                            </div>
                            <div class="form-group">
                                <label for="machine_type_id">Machine Type:</label>
                                <select name="machine_type_id" class="form-control">
                                    @foreach($machine_types as $type)
                                        <option value="{{ $type->id }}" {{ $machine->machine_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brand_id">Brand:</label>
                                <select name="brand_id" class="form-control">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $machine->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection