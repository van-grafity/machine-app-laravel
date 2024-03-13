<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::select('id', 'name')->get();
        if (request()->ajax()) {
            return datatables()->of($brands)
                ->addColumn('action', function($brand) {
                    return '<button type="button" class="btn btn-primary btn-sm btn-detail" data-id="' . $brand->id . '">Detail</button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $brand->id . '">Delete</button>';
                })
                ->toJson();
        }
        return view('pages.brands.index');
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
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $brand = Brand::create([
                'name' => $request->input('name'),
            ]);

            return redirect('brands')->with('success', 'Brand created successfully');
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->withErrors(['error' => 'Failed to create brand. Please try again later.']);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);
        return response()->json($brand, 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $brand = Brand::findOrFail($id);
            $brand->update([
                'name' => $request->input('name'),
                'updated_at' => Carbon::now(),
            ]);

            return redirect('brands')->with('success', 'Brand updated successfully');
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            return Redirect::back()->withInput()->withErrors(['error' => 'Failed to update brand. Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
            return redirect('brands')->with('success', 'Brand deleted successfully');
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'Failed to delete brand. Please try again later.']);
        }
    }
}
