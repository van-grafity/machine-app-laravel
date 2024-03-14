<?php

namespace App\Http\Controllers;

use App\Models\MachineType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MachineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = MachineType::select('id', 'name');
        if (request()->ajax()) {
            return datatables()->of($model)
                ->addIndexColumn()
                ->addColumn('action', function($machineType) {
                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-edit" data-id="' . $machineType->id . '"><i class="fas fa-edit"></i></a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-id="' . $machineType->id . '"><i class="fas fa-trash"></i></a>';
                })
                ->toJson();
        }
        return view('pages.machine-types.index');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:machine_types|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $machineType = new MachineType();
            $machineType->name = $request->input('name');
            $machineType->created_at = Carbon::now();
            $machineType->updated_at = Carbon::now();
            $machineType->save();

            return redirect('machine-types')->with('success', 'Machine Type created successfully');
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors(['error' => 'Failed to create machine type. Please try again later.']);
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
        $machineType = MachineType::findOrFail($id);
        return response()->json($machineType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $machineType = MachineType::findOrFail($id);
            $machineType->update([
                'name' => $request->input('name'),
                'updated_at' => Carbon::now(),
            ]);

            return redirect('machine-types')->with('success', 'Machine Type updated successfully');
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors(['error' => 'Failed to update machine type. Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $machineType = MachineType::findOrFail($id);
            $machineType->delete();

            return response()->json(['success' => 'Machine Type deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete machine type. Please try again later.']);
        }
    }
}
