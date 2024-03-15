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
        ->with('type:id,name', 'brand:id,name')
        ->get();

        if (request()->ajax()) {
            return datatables()->of($machines)
                ->addIndexColumn()
                ->addColumn('action', function($machine) {
                    return '<a href="' . route('machines.edit', $machine->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-machine" data-id="' . $machine->id . '"><i class="fas fa-trash"></i></a>';
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
        $machine_types = MachineType::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        return view('pages.machines.create', compact('machine_types', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'serial_number' => 'required',
            'machine_type_id' => 'required',
            'brand_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            Machine::create($request->all());
            return Redirect::route('machines.index')->with('success', 'Machine has been created successfully!');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
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
        $machine = Machine::find($id);
        $machine_types = MachineType::select('id', 'name')->get();
        $brands = Brand::select('id', 'name')->get();
        return view('pages.machines.edit', compact('machine', 'machine_types', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'serial_number' => 'required',
            'machine_type_id' => 'required',
            'brand_id' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            Machine::find($id)->update($request->all());
            return Redirect::route('machines.index')->with('success', 'Machine has been updated successfully!');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $machine = Machine::findOrfail($id);
            $machine->delete();

            return response()->json(['success' => 'Machine has been deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}