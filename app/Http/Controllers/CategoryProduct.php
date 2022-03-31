<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class CategoryProduct extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();

        }
    }
    public function addCategory(){
        $this->authLogin();
        return view ('admin.addProductCategory');
    }
    public function allCategory(){
        $this->authLogin();
        $allCategory = DB::table('category_product')->get();
        $manager_category_product = view('admin.allProductCategory')->with('allCategory',$allCategory);
        return view ('admin_layout')->with('admin.allProductCategory', $manager_category_product);
       
    }
    public function saveCategory(Request $request){
        $this->authLogin();
        $data= array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc; 
        $data['category_status'] = $request->category_product_status;
        $data['meta_keywords'] = $request->meta_keywords;
        $data['slug_category_product'] = $request->slug_category_product;


        DB::table('category_product')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function unactive_category_product($category_product_id){
        $this->authLogin();
        DB::table('category_product')->where('category_id', $category_product_id)->update(['category_status'=>1]);
        Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
        
    }

    public function active_category_product($category_product_id){
        $this->authLogin();
        DB::table('category_product')->where('category_id', $category_product_id)->update(['category_status'=>0]);
        Session::put('message','Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function editCategory($category_product_id){
        $this->authLogin();
        
        $editCategory = DB::table('category_product')->where('category_id', $category_product_id)->get();
        $manager_category_product = view('admin.editProductCategory')->with('editCategory',$editCategory);
        return view ('admin_layout')->with('admin.editProductCategory', $manager_category_product);
    }

    public function updateCategory(Request $request, $category_product_id){
        $this->authLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['meta_keywords'] = $request->meta_keywords;
        $data['slug_category_product'] = $request->slug_category_product;
        DB::table('category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật thành công');
        return Redirect::to('all-category-product');

    }

    public function deteleCategory($category_product_id){
        $this->authLogin();
        DB::table('category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Cập nhật thành công');
        return Redirect::to('all-category-product');
    }
    
    //End Admin funcion
    public function show_category(request $request, $category_id){
        $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();
        
        $category_by_id = DB::table('tbl_product')->join('category_product','tbl_product.category_id','=',
        'category_product.category_id')->where('tbl_product.category_id', $category_id)->get();

        $category_by_name = DB::table('category_product')->where('category_product.category_id','=',$category_id)
        ->limit(1)->get();
        foreach($category_by_id as $key =>$val ){
            $meta_desc = $val ->category_desc;
            $meta_keywords = $val ->meta_keywords;
            $meta_title = $val ->category_name;
            $url_canonical = $request->url();
        }
        return view('pages.category.show_category')
        ->with('category', $cate_product)
        ->with('brand', $brand_product)
        ->with('category_by_id', $category_by_id)
        ->with('category_by_name',$category_by_name)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical);
    }

}
