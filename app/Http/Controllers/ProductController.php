<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class ProductController extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();

        }
    }
    public function addproduct(){
        $this->authLogin();
        $cate_product = DB::table('category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();

        return view ('admin.addProduct')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }
    public function allproduct(){
        $this->authLogin();
        
        $allproduct = DB::table('tbl_product')
        ->join('category_product','category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->get();
        


        // $allproduct = DB::table('tbl_product')->orderby('product_id', 'desc')->get();
        $manager_product = view('admin.allProduct')->with('allproduct',$allproduct);
        //$allproduct = allproduct::all();
       
        return view ('admin_layout')->with('admin.allProduct', $manager_product);
       
    }
    public function saveproduct(Request $request){
        $this->authLogin();

        $data= array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc; 
        $data['product_content'] = $request->product_content; 
        $data['category_id'] = $request->product_cate; 
        $data['brand_id'] = $request->product_brand; 
        $data['product_status'] = $request->product_status; 

        $get_image = $request -> file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            //$new_image = rand(0,99).'.'.$get_image->getClientOriginalExtension();
            //$get_image -> move('public/uploads/product', $new_image);
            $get_image->move(base_path().'/public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
            return Redirect::to('all-product');

        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message','Thêm sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function unactive_product($product_id){
        $this->authLogin();

        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>1]);
        Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-product');
        
    }

    public function active_product($product_id){
        $this->authLogin();

        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>0]);
        Session::put('message','Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-product');
        
    }

    public function editproduct($product_id){
        $this->authLogin();

        $cate_product = DB::table('category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();

        $editproduct = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $manager_product = view('admin.editProduct')->with('editproduct',$editproduct)->with('cate_product',$cate_product)
        ->with('brand_product', $brand_product);
        return view ('admin_layout')->with('admin.editProduct', $manager_product);
    }

    public function updateproduct(Request $request, $product_id){
        $this->authLogin();
       
        $data= array();
        $data['product_name'] = $request->product_name;
        $data['product_price'] = $request->product_price;
        $data['product_desc'] = $request->product_desc; 
        $data['product_content'] = $request->product_content; 
        $data['category_id'] = $request->product_cate; 
        $data['brand_id'] = $request->product_brand; 
        $data['product_status'] = $request->product_status; 
        $data['product_name'] = $request->product_name;
        $data['product_desc'] = $request->product_desc;

        $get_image = $request -> file('product_image');
        if($get_image){

            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move(base_path().'/public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');

        }
        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');

    }

    public function deteleproduct($product_id){
        $this->authLogin();

        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công'); 
        return Redirect::to('all-product');
    }
    //END CODE ADMIN
    public function details_product(Request $request, $product_id){
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();

        $details_product = DB::table('tbl_product')
        ->join('category_product','category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id', $product_id)->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            $meta_desc = $value ->product_desc;
            $meta_keywords = $value ->meta_keywords;
            $meta_title = $value ->product_name;
            $url_canonical = $request->url();
        }

        $realted_product = DB::table('tbl_product')
        ->join('category_product','category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('category_product.category_id', $category_id)
        ->whereNotIn('tbl_product.product_id', [$product_id])->get();

        return view ('pages.product.show_details')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('product_details',$details_product)
        ->with('relate',$realted_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
    }
}