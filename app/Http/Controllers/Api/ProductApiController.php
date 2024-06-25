<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\CommentProductRequest;
use App\Http\Requests\api\ProductAddRequest;
use App\Http\Requests\api\ProductEditRequest;
use App\Http\Requests\api\RateProductRequest;
use App\Models\admin\brand;
use App\Models\admin\category;
use App\Models\admin\commentProduct;
use App\Models\admin\product;
use App\Models\admin\rate_product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
class ProductApiController extends Controller
{
    public $successStatus = 200;
    public function categoryBrand()
    {
        $category = category::all()->toArray();
        $brand = brand::all()->toArray();
        return response()->json([
            'response'=>'success',
            'category'=>$category,
            'brand'=>$brand,
        ], $this->successStatus);
    }
    public function productAdd(ProductAddRequest $request)
    {
        $data = $request->all();
        if($request->hasFile('file')){
            $imageUpload = $this->uploadImageToDirectory($request->file('file'));
            $data['image'] = json_encode($imageUpload);
        }
        $data['id_category'] = $data['category'];
        $data['id_brand'] = $data['brand'];
        $data['id_user'] = Auth::user()->id;
        if($product = product::create($data)){
            return response()->json([
                'response'=> 'success',
                'data'=>$product
            ], $this->successStatus);
        }
    }
    public function uploadImageToDirectory($arrImage)
    {
        $imgArray = [];
        foreach($arrImage as $image)
        {
            $imgName = strtotime(date('Y-m-d H:i:s')).'_'.$image->getClientOriginalName();
            if(!file_exists('upload/product/'.Auth::user()->id)){
                mkdir('upload/product/'.Auth::user()->id);
            }
            $path = public_path('upload/product/'.Auth::user()->id.'/'.$imgName);
            $pathSmall = public_path('upload/product/'.Auth::user()->id.'/small_'.$imgName);
            $pathLarger = public_path('upload/product/'.Auth::user()->id.'/larger_'.$imgName);

            Image::make($image->getRealPath())->save($path);
            Image::make($image->getRealPath())->resize(84,84)->save($pathSmall);
            Image::make($image->getRealPath())->resize(330,380)->save($pathLarger);

            $imgArray[] = $imgName;
        }
        return $imgArray;
    }
    public function productShow()
    {
        $productData = product::all()->where('id_user', Auth::user()->id)->toArray();
        return response()->json([
            'response'=>'success',
            'data'=>$productData,
        ], $this->successStatus);
    }
    public function show(string $id)
    {
        $data = product::findOrFail($id);
        $data['image'] = json_decode($data['image']);
        return response()->json([
            'response'=>'success',
            'data'=>$data
        ],$this->successStatus);
    }
    public function edit(ProductEditRequest $request, $id)
    {
        $product = product::findOrFail($id);
        $data = $request->all();
        $imageProduct = json_decode($product['image'],true);
        if(!empty($data['avatarCheckBox'])){
            foreach($imageProduct as $key => $value){
                if(in_array($value, $data['avatarCheckBox'])){
                    if(file_exists('upload/product/'.Auth::user()->id.'/'.$value)){
                        unlink('upload/product/'.Auth::user()->id.'/'.$value);
                        unlink('upload/product/'.Auth::user()->id.'/small_'.$value);
                        unlink('upload/product/'.Auth::user()->id.'/larger_'.$value);
                    }
                    unset($imageProduct[$key]);
                }
            }
            $imageProduct = array_values($imageProduct);
        }
        $imageMerge = !empty($imageProduct) ? $imageProduct : '';
        if($request->hasFile('file')){
            $imageUpload = $this->uploadImageToDirectory($request->file('file'));
            $imageMerge = array_merge($imageUpload, $imageProduct);
        }
        if(count($imageMerge) > 6){
            return response()->json([
                'message' => 'Avatar only upload maximum 6 file',
            ]);
        }
        $data = $request->all();
        $data['image'] = json_encode($imageMerge);
        $data['id_category'] = $data['category'];
        $data['id_brand'] = $data['brand'];
        $data['id_user'] = Auth::user()->id;
        if($product->update($data)){
            if($request->hasFile('file')){
                $imageUpload = $this->uploadImageToDirectory($request->file('file'));
            }
            return response()->json([
                'response'=>'success',
                'data'=>$product,
            ],$this->successStatus);
        }
    }
    public function remove(string $id)
    {
        $dataProduct = product::find($id)->toArray();
        $imgArray = json_decode($dataProduct['image'], true);
        if(product::find($id)->delete()){
            foreach($imgArray as $value){
                if(file_exists('upload/product/'.Auth::user()->id.'/'.$value)){
                    unlink('upload/product/'.Auth::user()->id.'/'.$value);
                    unlink('upload/product/'.Auth::user()->id.'/small_'.$value);
                    unlink('upload/product/'.Auth::user()->id.'/larger'.$value);
                }
            }
            $productUser = product::all()->where('id_user', Auth::user()->id)->toArray();
            return response()->json([
                'response'=>'success',
                'data'=>$productUser,
            ],$this->successStatus);
        }
    }
    public function productall(){
        $productAll = product::all()->toArray();
        return response()->json([
            'response'=>'success',
            'data'=>$productAll
        ], $this->successStatus);
    }
    public function productHome()
    {
        $productHome = product::orderBy('id', 'desc')->get()->toArray();
        return response()->json([
            'response'=>'success',
            'data'=>$productHome,
        ],$this->successStatus);
    }
    public function newProduct(){
        $productNew = product::where('status', '=', 0)->orderBy('id', 'desc')->get()->toArray();
        return response()->json([
            'response'=>'success',
            'data'=>$productNew,
        ],$this->successStatus);
    }
    public function saleProduct(){
        $productSale = product::where('status', '=', 1)->orderBy('id', 'desc')->get()->toArray();
        return response()->json([
            'response'=>'success',
            'data'=>$productSale,
        ],$this->successStatus);
    }
    public function wishlist(){
        $product = product::all()->toArray();
        return response()->json([
            'response'=>'success',
            'data'=>$product,
        ],$this->successStatus);
    }
    public function productDetail(string $id){
        
        $productDetail = product::with(['commentProduct' => function($q){
            $q->orderBy('id', 'desc');
        }])->find($id);
        return response()->json([
            'response'=>'success',
            'data'=>$productDetail,
        ],$this->successStatus); 
    }
    public function cart(Request $request){
        $data = $request->json()->all();
        $getProduct = [];
        foreach($data as $key => $value){
            $get = product::findOrFail($key)->toArray();
            $get['qty'] = $value;
            $getProduct[] = $get;
        }
        return response()->json([
            'response'=>'success',
            'data'=>$getProduct,
        ],$this->successStatus);
    }
    public function productRate(RateProductRequest $request)
    {   
        $input = $request->all();
        if(!empty($input['id_user'])){
            if(rate_product::create($input)){
                return response()->json([
                    'status'=>200,
                    'message'=>'You have rate this product successfully'
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'error'=>'Internal Servel Error',
                ]);
            }
        }
    }
    public function getProductRate($id){
        $rateProductData = rate_product::all()->where('id_product',$id)->toArray();
        return response()->json([
            'status'=>'success',
            'data'=> $rateProductData,
        ], $this->successStatus);
    }
    public function productRecommend()
    {
        $productRecommend = product::orderBy('id','desc')->limit(6)->get()->toArray();
        return response()->json([
            'response'=>'success',
            'data'=>$productRecommend,
        ],$this->successStatus);
    }
    public function productSearch(Request $request){
        $productSearch = $request->search;
        $idCategory = $request->category;  
        $query = product::query();
        if(!empty($productSearch)){
            $query->where('name', 'like', '%' . $productSearch . '%');
        }
        if(!empty($idCategory)){
            $query->where('id_category', '=', $idCategory);
        }
        $product = $query->get()->toArray();
        return response()->json([
            'response' => 'success',
            'data' => $product,
        ], $this->successStatus);
    }
    public function productPriceRange(Request $request)
    {
        $productSearchPriceRange = product::query();
        if(!empty($request->price)){
            $prices = $request->price;
            $price = explode('-', $prices);
            $productSearchPriceRange->where('price','>=' , $price[0])
                                    -> where('price', '<=', $price[1]);
        }
        $product = $productSearchPriceRange->get()->toArray();
        return response()->json([
            'response'=> 'success',
            'data' => $product
        ], $this->successStatus);
    }
    public function productSearchAdvanced(Request $request)
    {
        $productSearchAdvanced = product::query();
        if(!empty($request->name)){
            $productSearchAdvanced->where('name','like', '%' .$request->name . '%');
        }
        if(!empty($request->price)){
            $prices = $request->price;
            $price = explode('-', $prices);
            $productSearchAdvanced->where('price',$price);
        }
        if(!empty($request->id_category)){
            $productSearchAdvanced->where('id_category','=', $request->id_category);
        }
        if(!empty($request->id_brand)){
            $productSearchAdvanced->where('id_brand','=', $request->id_brand);
        }
        if(!empty($request->status)){
            $productSearchAdvanced->where('status','=',$request->status);
        }
        $product = $productSearchAdvanced->get()->toArray();
        return response()->json([
            'response'=>'success',
            'data'=> $product,
        ],$this->successStatus);
    }
    public function comment(CommentProductRequest $request, $id){
        $data = $request->all();
        if($id){
            $comment = commentProduct::create($data);
            if($comment){
                return response()->json([
                    'status'=>200,
                    'data'=>$comment
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
}