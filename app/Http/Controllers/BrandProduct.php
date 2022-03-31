<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class BrandProduct extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();

        }
    }
    public function addBrand(){
        $this->authLogin();
        return view ('admin.addBrandProduct');
    }
    public function allBrand(){
        $this->authLogin();

        $allbrand = DB::table('tbl_brand')->get();
        $manager_brand = view('admin.allBrandProduct')->with('allbrand',$allbrand);
        return view ('admin_layout')->with('admin.allBrandProduct', $manager_brand);
       
    }
    public function saveBrand(Request $request){
        $this->authLogin();

        $data= array();
        $data['brand_name'] = $request->brand_name;
        $data['brand_desc'] = $request->brand_desc; 
        $data['brand_status'] = $request->brand_status; 

        DB::table('tbl_brand')->insert($data);
        Session::put('message','Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand');
    }

    public function unactive_brand($brand_id){
        $this->authLogin();

        DB::table('tbl_brand')->where('brand_id', $brand_id)->update(['brand_status'=>1]);
        Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-brand');
        
    }

    public function active_brand($brand_id){
        $this->authLogin();

        DB::table('tbl_brand')->where('brand_id', $brand_id)->update(['brand_status'=>0]);
        Session::put('message','Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-brand');
        
    }

    public function editBrand($brand_id){
        $this->authLogin();

        $edit_Brand_Product = DB::table('tbl_brand')->where('brand_id', $brand_id)->get();
        
        $manager_brand = view('admin.editBrandProduct')->with('editBrand',$edit_Brand_Product);
        
        return view ('admin_layout')->with('admin.editBrandProduct', $manager_brand);
    }

    public function updatebrand(Request $request, $brand_id){
        $this->authLogin();

        $data = array();
        $data['brand_name'] = $request->brand_name;
        $data['brand_desc'] = $request->brand_desc;
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update($data);
        Session::put('message','Cập nhật thành công');
        return Redirect::to('all-brand');

    }

    public function detelebrand($brand_id){
        $this->authLogin();

        DB::table('tbl_brand')->where('brand_id',$brand_id)->delete();
        Session::put('message','Cập nhật thành công');
        return Redirect::to('all-brand');
    }

    //End code Admin
    public function show_brand(request $request, $brand_id){
            $cate_product = DB::table('category_product')->where('category_status', '0')->orderby('category_id','desc')->get();
    
            $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get();
            
            $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=',
            'tbl_brand.brand_id')->where('tbl_product.brand_id', $brand_id)->get();
            foreach($brand_by_id as $key =>$val ){
                $meta_desc = $val ->brand_desc;
                $meta_keywords = $val ->meta_keywords;
                $meta_title = $val ->brand_name;
                $url_canonical = $request->url();
            }

            $brand_by_name = DB::table('tbl_brand')->where('tbl_brand.brand_id','=',$brand_id)
            ->limit(1)->get();
    
            return view('pages.brand.show_brand')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('brand_by_id', $brand_by_id)
            ->with('brand_by_name', $brand_by_name)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical);
   
    }
}
