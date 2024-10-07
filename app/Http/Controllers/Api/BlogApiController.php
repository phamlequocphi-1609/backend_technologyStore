<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\CommentBlogRequest;
use App\Http\Requests\api\RateBlogRequest;
use App\Models\admin\blog;
use App\Models\admin\comments;
use App\Models\admin\rate_blog;


class BlogApiController extends Controller
{
    public $successStatus = 200;

    public function blogList()
    {
        $blogs = blog::with('comment')->get();
        return response()->json([
            'blog'=>$blogs
        ]);
    }
    public function blogNew(){
     
      $newBlog = blog::orderBy('id', 'desc')
                ->limit(4)->get();
       if($newBlog){
            return response()->json([
                'status'=> 200,
                'data'=>$newBlog
            ]);  
       }else{
            return response()->json([
                'status'=>404,
                'error'=>'Not found',
            ]);
       }
    }
    public function detail(string $id)
    {
        $blogDetail = blog::with(['comment' => function($q){
            $q->orderBy('id', 'desc');
        }])->find($id);
        return response()->json([
            'status'=>'success',
            'data'=>$blogDetail,
        ], $this->successStatus);
    }

    public function comment(CommentBlogRequest $request, $id)
    {
        $data = $request->all();
        if($id)
        {
            $setComment = comments::create($data);
            if($setComment){
                return response()->json([
                    'status'=>200,
                    'data'=>$setComment
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'error'=>'Internal Servel Error',
                ]);
            }
        }else{
            return response()->json([
                'status'=>404,
                'error'=>'Not Found',
            ]);
        }
    }
   
    public function rateBlog($id)
    {
        $rateData = rate_blog::all()->where('id_blog', $id)->toArray();
        return response()->json([
           'status'=>'success',
           'data'=> $rateData,
        ],$this->successStatus);
    }
    public function createRate(RateBlogRequest $request){
        $input = $request->all();
        if(!empty($input['id_user']))
        {
            if(rate_blog::create($input)){
                return response()->json([
                    'status'=>200,
                    'message'=>'You have rate this blog successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'error'=>'Internal Servel Error',
                ]);
            }
        }
    }
    public function paginationBlogDetail(string $id){
        $blog = blog::find($id);
        
        $blogPrevious = blog::where('id', '<', $blog->id)->max('id');
        $blogNext = blog::where('id', '>', $blog->id)->min('id');
        
        if($blog){
            return response()->json([
                'status'=>200,
                'data'=>$blog,
                'previous'=>$blogPrevious,
                'next'=>$blogNext,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'error'=>'error'
            ]);
        }
    }
}