<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use App\Models\Machine;
use App\Models\MachineType;
use App\Models\Brand;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machines = Machine::select('id', 'model', 'serial_number', 'machine_type_id', 'brand_id')
        ->with('machineType:id,name', 'brand:id,name')
        ->get();
        if (request()->ajax()) {
            return datatables()->of($machines)
                ->addIndexColumn()
                ->addColumn('action', function($machine) {
                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-edit" data-id="' . $machine->id . '"><i class="fas fa-edit"></i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="' . $machine->id . '"><i class="fas fa-trash"></i></a>';
                })
                ->toJson();
        }
        return view('pages.machines.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
