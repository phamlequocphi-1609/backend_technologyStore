<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\brand\Brandrequest;
use App\Models\admin\brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getBrand()
    {
        return view('admin.brand.add');
    }
    public function create(Brandrequest $request)
    {
        $brand = $request->all();
        if(brand::create($brand)){
            return redirect('/admin/brand/list')->with('success', 'Data added successfully');
        }else{
            return redirect()->back()->withErrors('Data added failed');
        }
    }
    public function show()
    {
        $dataBrand = brand::all();
        return view('admin.brand.list', compact('dataBrand'));
    }
    public function delete(string $id)
    {
        $brandDelete = brand::find($id);
        $brandDelete->delete();
        return redirect()->back()->with('success', 'Your brand has been deleted successfully');
    }
}