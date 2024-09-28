<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\category\CategoryRequest;
use App\Http\Requests\admin\category\UpdateCategoryRequest;
use App\Models\admin\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getCategory()
    {
        return view('admin.category.add');
    }
    
    public function create(CategoryRequest $request)
    {
        $category = $request->all();
        $file = $request->image;
        if(!empty($file)){
            $category['image'] = $file->getClientOriginalName();
         
            $file->move(public_path('upload/category'), $file->getClientOriginalName());
        }
        if(category::create($category)){
            return redirect('/admin/category/list')->with('success', 'Data added successfully');
        }else{
            return redirect()->back()->withErrors('Data added failed');
        }
    }
    public function show()
    {
        $data = category::all();
        return view('/admin/category/list', compact('data'));
    }
    public function delete(string $id)
    {
        $dataRemove = category::find($id);
        $dataRemove->delete();
        return redirect()->back()->with('success', 'Your category has been deleted successfully');
    }

    public function edit(string $id){
        $dataEdit = category::find($id);
        return view('admin.category.edit', compact('dataEdit'));
    }
    public function update(UpdateCategoryRequest $request,string $id)
    {
        $categoryEdit = category::find($id);
        $data = $request->all();
        $file = $request->image;
        if(!empty($file)){
            $data['image'] = $file->getClientOriginalName();
        }
        if($categoryEdit->update($data)){
            if(!empty($file)){
                $file->move(public_path('upload/category'), $file->getClientOriginalName());
            }
            return redirect('/admin/category/list')->with('success', 'Data updated successfully');
        }else{
            return redirect()->back()->withErrors('Data updated failed');
        }
    }
}