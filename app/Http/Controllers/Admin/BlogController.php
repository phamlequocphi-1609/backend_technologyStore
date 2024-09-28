<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\blog\BlogRequest;
use App\Http\Requests\admin\blog\UpdateRequest;
use App\Models\admin\blog;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use PDO;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $blogs = blog::all()->toArray();
        return view('admin.blog.list', compact('blogs'));
    }
    
    public function getData(){
        return view('admin.blog.add');
    }
    public function create(BlogRequest $request)
    {
        $images = [];
        if($request->hasFile('image')){
            foreach($request->file('image') as $image){
                $img = $image->getClientOriginalName();
                $img_2 = '2'.$image->getClientOriginalName();
                $img_3 = '3'.$image->getClientOriginalName();

                $path = public_path('upload/blog/'.$img);
                $path_2 = public_path('upload/blog/'.$img_2);
                $path_3 = public_path('upload/blog/'.$img_3);

                Image::make($image->getRealPath())->save($path);
                Image::make($image->getRealPath())->save($path_2);
                Image::make($image->getRealPath())->save($path_3);
                       
                $images[] = $img;
            }
        }
        $blog = new blog();
        $blog->title = $request->title;
        $blog->image = json_encode($images);
        $blog->description = $request->description;
        $blog->content = $request->content;

        if($blog->save())
        {
            return redirect('/admin/blog/list')->with('success', 'Data added successfully');
        }else{
            return redirect()->back()->withErrors('Data added failed');
        }    
    }
    public function edit(string $id)
    {   
        $dataEdit = blog::find($id);
        return view('admin.blog.edit', compact('dataEdit'));
      
    }
    public function update(UpdateRequest $request, string $id)
    {
        $blogEdit = blog::find($id);
        
        $images = json_decode($blogEdit->image, true);
        if($request->has('delete_img'))
        {
            $imgCheckbox = $request->delete_img;
            foreach($imgCheckbox as $imgDelete)
            {
                if(in_array($imgDelete, $images))
                {
                    $key = array_search($imgDelete, $images);
                    unset($images[$key]);
                }
            }
        }
        if($request->hasFile('image')){
            foreach($request->file('image') as $image)
            {
                $img = $image->getClientOriginalName();
                $img_2 = '2update'.$image->getClientOriginalName();
                $img_3 = '3update'.$image->getClientOriginalName();

                $path = public_path('upload/blog/'.$img);
                $path_2 = public_path('upload/blog/'.$img_2);
                $path_3 = public_path('upload/blog/'.$img_3);
                
                Image::make($image->getRealPath())->save($path);
                Image::make($image->getRealPath())->save($path_2);
                Image::make($image->getRealPath())->save($path_3);
                
                $images[] = $img;
            }
        }
        $images = array_values($images);
        if(count($images) > 3){
            return redirect()->back()->withErrors('The total number of images to be uploaded must be less than 3');
        }
        $blogEdit->title = $request->title;
        $blogEdit->image = json_encode($images);
        $blogEdit->description = $request->description;
        $blogEdit->content = $request->content;
        $blogEdit->update();
        return back()->with('success', 'Your blog has been updated successfully');
    }
    public function delete(string $id)
    {
        $blogDelete = blog::find($id);
        $blogDelete->delete();
        return redirect()->back()->with('success', 'Your blog has been deleted successfully');
    }
}