<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\country\CountryRequest;
use App\Models\admin\country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
       $data = country::all();
       return view('admin.country.list', compact('data'));    
    }
    public function getdata(){
        return view('admin.country.add');
    }
    public function create(CountryRequest $request)
    {
        $data = $request->all();
        if(country::create($data)){
            return redirect('/admin/country/list')->with('success', 'Data added successfully');
        }else{
            return redirect()->back()->withErrors('Data added failed');
        }
    }
    public function delete(string $id){
        $country_id = country::find($id);
        $country_id->delete();
        return redirect()->back()->with('success', 'Data deleted successfully');
    }
}