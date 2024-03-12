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
        $model = Brand::query();
        if (request()->ajax()) {
            return datatables()->eloquent($model)
                ->addColumn('action', function ($brand) {
                    return view('pages.brands.action', [
                        'brand' => $brand,
                        'url_show' => route('brands.show', $brand->id),
                        'url_destroy' => route('brands.destroy', $brand->id),
                    ]);
                })
                ->editColumn('created_at', function ($brand) {
                    return $brand->created_at ? with(new Carbon($brand->created_at))->format('d/m/Y') : Carbon::now();
                })
                ->editColumn('updated_at', function ($brand) {
                    return $brand->updated_at ? with(new Carbon($brand->updated_at))->format('d/m/Y') : Carbon::now();
                })
                ->rawColumns(['action'])
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
                // Add other fields here if necessary
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
